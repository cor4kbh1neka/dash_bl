<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Transactions;
use App\Models\TransactionStatus;
use App\Models\TransactionSaldo;
use App\Models\DepoWd;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Jobs\createWdJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Cache;


class ApiBolaController extends Controller
{
    public function GetBalance(Request $request)
    {
        $validasiSBO = $this->validasiSBO($request);
        if ($validasiSBO !== true) {
            return $validasiSBO;
        }

        $validator = Validator::make($request->all(), [
            'Username' => 'required',
            'CompanyKey' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $saldo = $this->apiGetBalance($request)["balance"];

        // if ($saldo <= 0) {
        //     $saldoDpWd = DepoWd::where('username', $request->Username)->where('status', 1)->get();
        //     $sumSaldoDp = $saldoDpWd->whereIn('jenis', ['DP', 'DPM'])->sum('amount');
        //     $sumSaldoWd = $saldoDpWd->whereIn('jenis', ['WD', 'WDM'])->sum('amount');
        //     $totalSaldoDpWd = $sumSaldoDp - $sumSaldoWd;

        //     $saldo = $totalSaldoDpWd + $this->saldoBerjalan($request);
        // }

        $response = [
            "AccountName" => $request->Username,
            "Balance" => $saldo,
            "ErrorCode" => 0,
            "ErrorMessage" => "No Error"
        ];
        return response()->json($response, 200);
    }

    public function GetBetStatus(Request $request)
    {
        $validasiSBO = $this->validasiSBO($request);
        if ($validasiSBO !== true) {
            return $validasiSBO;
        }

        $validator = Validator::make($request->all(), [
            'Username' => 'required',
            'CompanyKey' => 'required',
            'TransferCode' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $dataTransaction = Transactions::where('transactionid', $request->TransactionId)->first();
        if (!$dataTransaction) {
            return $this->errorResponse($request->Username, 6);
        }

        $statusTransaction = TransactionStatus::where('trans_id', $dataTransaction->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

        if ($statusTransaction->status == 'Rollback' || $statusTransaction->status == 'Running') {
            $status = 'Running';
        } else if ($statusTransaction->status == 'Cancel') {
            $status = 'Void';
        } else {
            $status = $statusTransaction->status;
        }


        return response()->json([
            'TransferCode' => $request->TransferCode,
            'TransactionId' => $request->TransactionId,
            "Status" => $status,
            'ErrorCode' => 0,
            'ErrorMessage' => 'No Error'
        ])->header('Content-Type', 'application/json; charset=UTF-8');
    }

    public function Deduct(Request $request)
    {
        $validasiSBO = $this->validasiSBO($request);
        if ($validasiSBO !== true) {
            return $validasiSBO;
        }

        $validator = Validator::make($request->all(), [
            'Username' => 'required',
            'CompanyKey' => 'required',
            "Amount" => 'required',
            "TransferCode" => 'required',
            "TransactionId" => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $cekTransaction = Transactions::where('transactionid', $request->TransactionId)->first();

        if ($cekTransaction) {
            if ($request->ProductType == 3 || $request->ProductType == 7) {
                $cetLastStatus = TransactionStatus::where('trans_id', $cekTransaction->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

                if ($cetLastStatus->status == 'Running') {
                    $totalTransaction = TransactionSaldo::where('transtatus_id', $cetLastStatus->id)->sum('amount');
                    if ($request->Amount > $totalTransaction) {
                        return $this->setTransaction($request);
                    } else {
                        return $this->errorResponse($request->Username, 7);
                    }
                } else {
                    return $this->errorResponse($request->Username, 5003);
                }
            } else {
                return $this->errorResponse($request->Username, 5003);
            }
        }

        return $this->setTransaction($request);
    }

    public function Settle(Request $request)
    {
        $validasiSBO = $this->validasiSBO($request);
        if ($validasiSBO !== true) {
            return $validasiSBO;
        }

        $validator = Validator::make($request->all(), [
            'Username' => 'required',
            'CompanyKey' => 'required',
            "WinLoss" => 'required',
            "TransferCode" => 'required'

        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $dataTransactions = Transactions::where('transfercode', $request->TransferCode)->orderBy('created_at', 'DESC')->get();
        if ($dataTransactions->isEmpty()) {
            return $this->errorResponse($request->Username, 6);
        }
        foreach ($dataTransactions as $index => $dataTransaction) {
            $results[] = $this->setSettle($request, $dataTransaction, $index);
        }
        // $filterResults = [];
        // foreach (array_reverse($results) as $item) {
        //     $balance = $item->original['Balance'];
        //     if ($balance > 0) {
        //         $filterResults[] = $item;
        //         break;
        //     }
        // }
        return reset($results);
    }

    public function Cancel(Request $request)
    {
        $validasiSBO = $this->validasiSBO($request);
        if ($validasiSBO !== true) {
            return $validasiSBO;
        }

        $validator = Validator::make($request->all(), [
            'Username' => 'required',
            'CompanyKey' => 'required',
            "IsCancelAll" => 'required',
            "TransferCode" => 'required'

        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $dataTransaction = Transactions::where('transactionid', $request->TransactionId)->first();
        if (!$dataTransaction) {
            return $this->errorResponse($request->Username, 6);
        }
        $lastStatus = TransactionStatus::where('trans_id', $dataTransaction->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

        if ($request->ProductType == 9 && $lastStatus->status == 'Settled') {
            $dataTransactions = Transactions::where('transfercode', $request->TransferCode)->get();

            if ($dataTransactions->isEmpty()) {
                return $this->errorResponse($request->Username, 6);
            }

            foreach ($dataTransactions as $dataTransaction) {
                $results[] = $this->setCancel($request, $dataTransaction);
            }
            return end($results);
        }

        return $this->setCancel($request, $dataTransaction);
    }

    public function Rollback(Request $request)
    {
        $validasiSBO = $this->validasiSBO($request);
        if ($validasiSBO !== true) {
            return $validasiSBO;
        }

        $validator = Validator::make($request->all(), [
            'Username' => 'required',
            'CompanyKey' => 'required',
            "TransferCode" => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $dataTransaction = Transactions::where('transfercode', $request->TransferCode)->first();

        if (!$dataTransaction) {
            return $this->errorResponse($request->Username, 6);
        }

        if ($request->ProductType == 9) {
            $dataTransactions = Transactions::where('transfercode', $request->TransferCode)->get();

            if ($dataTransactions->isEmpty()) {
                return $this->errorResponse($request->Username, 6);
            }

            foreach ($dataTransactions as $dataTransaction) {
                $results[] = $this->setRollback($request, $dataTransaction);
            }
            return end($results);
        }

        return $this->setRollback($request, $dataTransaction);
    }

    public function Bonus(Request $request)
    {
        $cekTransaction = Transactions::where('transfercode', $request->TransferCode)->first();
        if ($cekTransaction) {
            return $this->errorResponse($request->Username, 5003);
        }

        $createTransaction = $this->createTransaction($request, 'Bonus');
        $crteateStatusTransaction = $this->updateTranStatus($createTransaction->id, 'Running');

        if ($crteateStatusTransaction) {
            $txnid = $this->generateTxnid('D');
            $transactionTransaction = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, "D", $request->Amount, 1);


            if ($transactionTransaction) {
                $saldo = $this->apiGetBalance($request)["balance"];

                return response()->json([
                    'AccountName' => $request->Username,
                    'Balance' => $saldo,
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ])->header('Content-Type', 'application/json; charset=UTF-8');
            }

            return $this->errorResponse($request->Username, 5003);
        }
        return $this->errorResponse($request->Username, 5003);
    }

    public function ReturnStake(Request $request)
    {
        $cekTransaction = Transactions::where('transactionid', $request->TransactionId)->first();
        if (!$cekTransaction) {
            return $this->errorResponse($request->Username, 6);
        }

        $lastStatus = TransactionStatus::where('trans_id', $cekTransaction->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first()->status;

        $txnid = $this->generateTxnid('D');
        if ($lastStatus === 'Running') {
            $createTransaction = $cekTransaction;
            $crteateStatusTransaction = $this->updateTranStatus($createTransaction->id, 'ReturnStake');

            if ($crteateStatusTransaction) {
                $transactionTransaction = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, "D", $request->CurrentStake, 1);

                if ($transactionTransaction) {
                    $saldo = $this->apiGetBalance($request)["balance"];
                    return response()->json([
                        'AccountName' => $request->Username,
                        'Balance' => $saldo,
                        'ErrorCode' => 0,
                        'ErrorMessage' => 'No Error'
                    ])->header('Content-Type', 'application/json; charset=UTF-8');
                }
            }
        } else if ($lastStatus === 'ReturnStake') {
            return $this->errorResponse($request->Username, 5008);
        } else if ($lastStatus === 'Cancel') {
            return $this->errorResponse($request->Username, 2002);
        }
        return $this->errorResponse($request->Username, 6);
    }










    /* ====================== Validasi SBO ======================= */
    private function validasiSBO(Request $request)
    {
        if ($request->Username == '') {
            return $this->errorResponse($request->Username, 3);
        }



        // if ($request->Username != 'poorgas321') {
        //     return $this->errorResponse($request->Username, 1);
        // }
        $data = $this->apiGetBalance($request);
        dd($data);
        if ($data["error"] !== 0) {
            return $this->errorResponse($request->Username, 1);
        }

        if ($request->CompanyKey != env('COMPANY_KEY')) {
            return $this->errorResponse($request->Username, 4);
        }

        return true;
    }

    /* ====================== Rollback ======================= */
    private function setRollback(Request $request, $dataTransaction)
    {
        try {
            $dataTransactions = Transactions::where('transactionid', $dataTransaction->transactionid)->first();
            $lastStatus = TransactionStatus::where('trans_id', $dataTransaction->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

            if ($lastStatus->status === 'Cancel') {
                $crteateStatusTransaction = $this->updateTranStatus($dataTransaction->id, 'Rollback');
                return $this->rollbackTransaction($request, $dataTransaction, $crteateStatusTransaction, 1);
            } else if ($lastStatus->status === 'Settled') {
                return $this->cancelTransaction($request, $dataTransaction, $lastStatus, 1);
            } else if ($lastStatus->status === 'Rollback') {
                return $this->errorResponse($request->Username, 2003);
            } else {
                $this->errorResponse($request->Username, 6);
            }
        } catch (\Exception $e) {
            // Tangani kesalahan di sini
            return response()->json([
                'error' => $e->getMessage()
            ], 200);
        }
    }

    private function rollbackTransaction(Request $request, $dataTransaction, $crteateStatusTransaction = null, $isrollback = 0)
    {
        $lastRunningStatus = TransactionStatus::where('trans_id', $dataTransaction->id)->where('status', 'Running')->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

        if ($lastRunningStatus) {
            if ($request->ProductType == 3 || $request->ProductType == 7) {
                $totalAmount = TransactionSaldo::where('transtatus_id', $lastRunningStatus->id)->sum('amount');
            } else {
                $dataTransactions = TransactionSaldo::where('transtatus_id', $lastRunningStatus->id)->first();
                $totalAmount = $dataTransactions->amount;
            }
            $txnid = $this->generateTxnid('W');

            if ($crteateStatusTransaction) {
                $transactionTransaction = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, "W", $totalAmount, 3);

                if ($transactionTransaction) {
                    $saldo = $this->apiGetBalance($request)["balance"];
                    return response()->json([
                        'AccountName' => $request->Username,
                        'Balance' => $saldo,
                        'ErrorCode' => 0,
                        'ErrorMessage' => 'No Error'
                    ])->header('Content-Type', 'application/json; charset=UTF-8');
                }
            }
            return 'error $transactionTransaction : ' . $transactionTransaction;
        }
    }


    /* ====================== Cancel ======================= */
    private function setCancel(Request $request, $dataTransaction)
    {
        $lastStatus = TransactionStatus::where('trans_id', $dataTransaction->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();
        $last2ndStatus = TransactionStatus::where('trans_id', $dataTransaction->id)
            ->where('id', '!=', $lastStatus->id)
            // ->where('created_at', '<', $lastStatus->created_at) 
            ->whereIn('status', ['Running', 'Settled', 'Rollback'])
            ->orderBy('created_at', 'DESC')
            ->orderBy('urutan', 'DESC')
            ->first();

        if ($lastStatus->status != 'Cancel') {
            $crteateStatusTransaction = $this->updateTranStatus($dataTransaction->id, 'Cancel');

            if ($crteateStatusTransaction) {

                if ($lastStatus->status == 'Settled') {
                    $dataTransactions = TransactionSaldo::where('transtatus_id', $lastStatus->id)->first();

                    $jenis = 'W';
                    $rangeNumber = 10;
                    $txnid = $this->generateTxnid($jenis);
                    $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $dataTransactions->amount, 1);

                    if ($last2ndStatus->status != 'Running' || $last2ndStatus->status != 'Rollback') {
                        if ($request->ProductType == 3 || $request->ProductType == 7) {
                            $totalAmount = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->sum('amount');
                        } else {
                            $dataTransactions = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

                            $totalAmount = $dataTransactions->amount;
                        }

                        $jenis = 'D';
                        $rangeNumber = 17;
                        $txnid = $this->generateTxnid($jenis);
                        $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $totalAmount, 3);

                        if ($request->ProductType == 9) {
                            $checkReturnStakeStatus = TransactionStatus::where('trans_id', $dataTransaction->id)
                                ->where('id', '!=', $lastStatus->id)
                                ->where('status', 'ReturnStake')
                                ->where('created_at', '<=', $lastStatus->created_at)
                                ->where('created_at', '>=', $last2ndStatus->created_at)
                                ->orderBy('created_at', 'DESC')
                                ->orderBy('urutan', 'DESC')
                                ->first();

                            if ($checkReturnStakeStatus) {
                                $trReturnStake = TransactionSaldo::where('transtatus_id', $checkReturnStakeStatus->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

                                $jenis = 'W';
                                $rangeNumber = 10;
                                $txnid = $this->generateTxnid($jenis);
                                $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $trReturnStake->amount, 2);
                            }
                        }
                    }
                } else if ($lastStatus->status == 'Running' || $lastStatus->status == 'Rollback') {
                    if ($request->ProductType == 3 || $request->ProductType == 7) {
                        $totalAmount = TransactionSaldo::where('transtatus_id', $lastStatus->id)->sum('amount');
                    } else {
                        $dataTransactions = TransactionSaldo::where('transtatus_id', $lastStatus->id)->first();
                        $totalAmount = $dataTransactions->amount;
                    }

                    $jenis = 'D';
                    $rangeNumber = 17;
                    $txnid = $this->generateTxnid($jenis);

                    $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $totalAmount, 1);
                } else if ($lastStatus->status == 'ReturnStake') {
                    if ($last2ndStatus->status != 'Running' || $last2ndStatus->status != 'Rollback') {
                        if ($request->ProductType == 3 || $request->ProductType == 7) {
                            $totalAmount = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->sum('amount');
                        } else {
                            $dataTransactions = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

                            $totalAmount = $dataTransactions->amount;
                        }

                        if ($request->ProductType == 9) {
                            $checkReturnStakeStatus = TransactionStatus::where('trans_id', $dataTransaction->id)
                                ->where('id', '!=', $lastStatus->id)
                                ->where('status', 'ReturnStake')
                                ->where('created_at', '<', $lastStatus->created_at)
                                ->where('created_at', '>', $last2ndStatus->created_at)
                                ->orderBy('created_at', 'DESC')
                                ->orderBy('urutan', 'DESC')
                                ->first();
                            $trReturnStake = TransactionSaldo::where('transtatus_id', $checkReturnStakeStatus->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();
                            if ($checkReturnStakeStatus) {
                                $jenis = 'W';
                                $rangeNumber = 10;
                                $txnid = $this->generateTxnid($jenis);
                                $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $trReturnStake->amount, 1);
                            }
                        }

                        $jenis = 'D';
                        $rangeNumber = 17;
                        $txnid = $this->generateTxnid($jenis);
                        $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $totalAmount, 2);
                    }
                }

                // $dataTransactions = TransactionSaldo::where('transtatus_id', $dtStatusTransaction->id)->first();
                // $jenis = $dataTransactions->jenis == 'W' ? 'D' : 'W';
                // $rangeNumber = $jenis == 'D' ? 17 : 10;
                // $txnid = $this->generateTxnid($jenis, $rangeNumber);

                // if ($dataTransactions->jenis == 'W') {
                //     $request->merge(['WinLoss' => $dataTransactions->amount]);
                //     $addTransactions = $this->deposit($request, $txnid);
                // } else {
                //     $request->merge(['Amount' => $dataTransactions->amount]);
                //     $addTransactions = $this->withdraw($request, $txnid);
                // }

                // if ($addTransactions["error"]["id"] === 9720) {
                //     $addTransactions = $this->requestWitdraw9720($request, $txnid);
                // }

                // if ($addTransactions["error"]["id"] === 4404) {
                //     return $this->errorResponse($request->Username, $addTransactions["error"]["id"]);
                // }

                // $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $dataTransactions->amount);
            }

            $saldo = $this->apiGetBalance($request)["balance"];
            return response()->json([
                'AccountName' => $request->Username,
                'Balance' => $saldo,
                'ErrorCode' => 0,
                'ErrorMessage' => 'No Error'
            ])->header('Content-Type', 'application/json; charset=UTF-8');
        } else {
            return $this->errorResponse($request->Username, 2002);
        }
    }

    private function cancelTransaction(Request $request, $dataTransaction, $lastStatus, $isrollback)
    {
        $last2ndStatus = TransactionStatus::where('trans_id', $dataTransaction->id)
            ->where('id', '!=', $lastStatus->id)
            // ->where('created_at', '<', $lastStatus->created_at) 
            ->whereIn('status', ['Running', 'Settled', 'Rollback'])
            ->orderBy('created_at', 'DESC')
            ->orderBy('urutan', 'DESC')
            ->first();

        $crteateStatusTransaction = $this->updateTranStatus($dataTransaction->id, 'Rollback');
        if ($crteateStatusTransaction) {
            $dataTransactions = TransactionSaldo::where('transtatus_id', $lastStatus->id)->first();
            $jenis = 'W';
            $txnid = $this->generateTxnid($jenis);
            $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $dataTransactions->amount, 1, $isrollback);

            if ($last2ndStatus->status != 'Running' || $last2ndStatus->status != 'Rollback') {
                if ($request->ProductType == 3 || $request->ProductType == 7) {
                    $totalAmount = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->sum('amount');
                } else {
                    $dataTransactions = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

                    $totalAmount = $dataTransactions->amount;
                }

                $jenis = 'D';
                $txnid = $this->generateTxnid($jenis);
                $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $totalAmount, 2, $isrollback);
            }

            return $this->rollbackTransaction($request, $dataTransaction, $crteateStatusTransaction, $isrollback);
        }
    }

    /* ====================== Settle ======================= */
    private function setSettle(Request $request, $dataTransaction, $index)
    {
        // $dataTransaction = Transactions::where('transactionid', $dataTransaction->transactionid)->first();
        $dataStatusTransaction = TransactionStatus::where('trans_id', $dataTransaction->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

        if ($dataStatusTransaction->status == 'Running' || $dataStatusTransaction->status == 'Rollback' || $dataStatusTransaction->status == 'ReturnStake') {
            $txnid = $this->generateTxnid('D');
            // $DpSaldo = $this->deposit($request, $txnid);

            // if ($DpSaldo["error"]["id"] === 9720) {
            //     return $this->errorResponse($request->Username, $DpSaldo["error"]["id"]);
            // }

            // if ($DpSaldo["error"]["id"] === 4404) {
            //     return $this->errorResponse($request->Username, $DpSaldo["error"]["id"]);
            // }

            $crteateStatusTransaction = $this->updateTranStatus($dataTransaction->id, 'Settled');
            if ($crteateStatusTransaction) {
                $WinLoss = $index == 0 ? $request->WinLoss : 0;
                $transactionTransaction = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, "D", $WinLoss, 1);
                if ($transactionTransaction) {
                    $saldo = $this->apiGetBalance($request)["balance"];
                    return [
                        'AccountName' => $request->Username,
                        'Balance' => $saldo,
                        'ErrorCode' => 0,
                        'ErrorMessage' => 'No Error'
                    ];
                }
            }
        } else if ($dataStatusTransaction->status == 'Cancel') {
            $WinLoss = $index == 0 ? $request->WinLoss : 0;
            return $this->errorResponse($request->Username, 2002);
        } else {
            $WinLoss = $index == 0 ? $request->WinLoss : 0;
            return $this->errorResponse($request->Username, 2001);
        }
    }

    private function deposit($username, $txnid, $amount)
    {
        $dataSaldo = [
            "Username" => $username,
            "TxnId" => $txnid,
            "Amount" => $amount,
            "CompanyKey" => env('COMPANY_KEY'),
            "ServerId" => env('SERVERID')
        ];
        $DpSaldo = $this->requestApi('deposit', $dataSaldo);
        return $DpSaldo;
    }


    /* ====================== Deduct ======================= */
    private function saldoBerjalan(Request $request)
    {
        $allTransactionTransaction = $this->getAllTransactions($request);

        $dataAllTransactionsWD = $allTransactionTransaction->where('jenis', 'W')->sum('amount');
        $dataAllTransactionsDP = $allTransactionTransaction->where('jenis', 'D')->sum('amount');

        $saldoBerjalan = $dataAllTransactionsDP  - $dataAllTransactionsWD;

        return $saldoBerjalan;
    }

    private function requestWitdraw9720(Request $request, $txnid)
    {
        set_time_limit(60);
        sleep(4.5);
        $addTransactions = $this->withdraw($request, $txnid);

        if ($addTransactions["error"]["id"] === 9720) {
            sleep(1.5);
            $addTransactions = $this->withdraw($request, $txnid);
            return $addTransactions;
        }

        return $addTransactions;
    }

    private function setTransaction(Request $request)
    {
        $saldoMember = $this->apiGetBalance($request)["balance"];

        if ($request->ProductType == 3 || $request->ProductType == 7) {
            $cekTransaction = Transactions::where('transactionid', $request->TransactionId)->first();

            if ($cekTransaction) {
                $cekLastStatus = TransactionStatus::where('trans_id', $cekTransaction->id)->first();

                $dataTransactions = TransactionSaldo::where('transtatus_id', $cekLastStatus->id)->first();
                $saldoMember = $saldoMember + $dataTransactions->amount;
            }
        }

        if ($saldoMember < $request->Amount) {
            return $this->errorResponse($request->Username, 5);
        }

        $txnid = $this->generateTxnid('W');

        // $WdSaldo = $this->withdraw($request, $txnid);

        // if ($WdSaldo["error"]["id"] === 9720) {
        //     $WdSaldo = $this->requestWitdraw9720($request, $txnid);
        // }

        // if ($WdSaldo["error"]["id"] === 4404) {
        //     return $this->errorResponse($request->Username, $WdSaldo["error"]["id"]);
        // }
        if (($request->ProductType == 3 && $cekTransaction) || ($request->ProductType == 7 && $cekTransaction)) {
            $createTransaction = $cekTransaction;
            $crteateStatusTransaction = $cekLastStatus;
        } else {
            $createTransaction = $this->createTransaction($request, 'Betting');
            $crteateStatusTransaction = $this->updateTranStatus($createTransaction->id, 'Running');
        }

        if ($crteateStatusTransaction) {
            if ($request->ProductType == 3 && $cekTransaction || $request->ProductType == 7 && $cekTransaction) {
                $amount = $request->Amount - $dataTransactions->amount;
                $transactionTransaction = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, "W", $amount, 1);
            } else {
                $transactionTransaction = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, "W", $request->Amount, 1);
            }

            if ($transactionTransaction) {
                $saldo = $this->apiGetBalance($request)["balance"];
                return response()->json([
                    'AccountName' => $request->Username,
                    'Balance' => $saldo,
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ])->header('Content-Type', 'application/json; charset=UTF-8');
            }
            return 'error deduct';
        }
    }

    private function withdraw($username, $txnid, $amount)
    {
        $dataSaldo = [
            "Username" => $username,
            "txnId" => $txnid,
            "IsFullAmount" => false,
            "Amount" => $amount,
            "CompanyKey" => env('COMPANY_KEY'),
            "ServerId" => env('SERVERID')
        ];
        $WdSaldo = $this->requestApi('withdraw', $dataSaldo);
        return $WdSaldo;
    }

    private function createTransaction(Request $request, $type)
    {
        $createTransaction = Transactions::create([
            "transactionid" => $request->TransactionId,
            "transfercode" => $request->TransferCode,
            "username" => $request->Username,
            "type" => $type,
            "status" => 0
        ]);

        return $createTransaction;
    }

    private function updateTranStatus($trans_id, $status)
    {
        $results = TransactionStatus::create([
            "trans_id" => $trans_id,
            "status" => $status
        ]);
        return $results;
    }

    private function createSaldoTransaction($transtatus_id, $txnid, $jenis, $amount, $urutan, $isrollback = 0)
    {
        $trans_id = TransactionStatus::where('id', $transtatus_id)->first()->trans_id;
        $dataTransaction = Transactions::where('id', $trans_id)->first();

        if ($jenis == 'W') {
            $transaction = $this->withdraw($dataTransaction->username, $txnid, $amount);
        } else {
            $transaction = $this->deposit($dataTransaction->username, $txnid, $amount);
        }

        $results = null;
        if ($transaction["error"]["id"] === 0) {
            $results = TransactionSaldo::create([
                "transtatus_id" => $transtatus_id,
                "txnid" => $txnid,
                "jenis" => $jenis,
                "amount" => $amount,
                "urutan" => $urutan
            ]);
        } else if ($transaction["error"]["id"] === 9720) {
            sleep(6);
            $transaction = $this->withdraw($dataTransaction->username, $txnid, $amount);
            if ($transaction["error"]["id"] === 0) {
                $results = TransactionSaldo::create([
                    "transtatus_id" => $transtatus_id,
                    "txnid" => $txnid,
                    "jenis" => $jenis,
                    "amount" => $amount,
                    "urutan" => $urutan
                ]);
            }
        } else if ($transaction["error"]["id"] === 4501) {
            if ($isrollback == 1) {
                $results = TransactionSaldo::create([
                    "transtatus_id" => $transtatus_id,
                    "txnid" => $txnid,
                    "jenis" => $jenis,
                    "amount" => $amount,
                    "ishutang" => 1,
                    "urutan" => $urutan
                ]);
            }
        }

        return $results;
    }

    private function getAllTransactions(Request $request)
    {
        $username = $request->Username;
        $transactions = Transactions::where('username', $username)->get();
        $transactionTransactions = collect();

        foreach ($transactions as $transaction) {
            $transactions = $transaction->transactionstatus->flatMap(function ($status) {
                return $status->transactionsaldo;
            });

            $transactionTransactions = $transactionTransactions->concat($transactions);
        }
        return $transactionTransactions;
    }

    /* ====================== GetBelance ======================= */
    private function apiGetBalance(Request $request)
    {
        // $cacheKey = 'balance_' . $request->Username;

        // if (Cache::has($cacheKey)) {
        //     return Cache::get($cacheKey);
        // }

        $dataSaldo = [
            "Username" => $request->Username,
            "CompanyKey" => env('COMPANY_KEY'),
            "ServerId" => env('SERVERID')
        ];
        $saldo = $this->requestApi('get-player-balance', $dataSaldo);

        $saldoDpWd = DepoWd::where('username', $request->Username)->where('status', 1)->get();
        $sumSaldoDp = $saldoDpWd->whereIn('jenis', ['DP', 'DPM'])->sum('amount');
        $sumSaldoWd = $saldoDpWd->whereIn('jenis', ['WD', 'WDM'])->sum('amount');

        if ($saldo["balance"] <= 0) {
            $totalSaldoDpWd = $sumSaldoDp - $sumSaldoWd;
            $saldo["balance"] = $totalSaldoDpWd + $this->saldoBerjalan($request);
        } else if ($saldo["balance"] > 0) {
            // $transaction = Transactions::where('transactionid', $request->)->first();
            // $transactionStatus = $transaction->transactionStatus;
            // if ($transactionStatus) {
            //     $transactionCode = $transactionStatus->TransactionCode;
            // }
        }

        // Cache::put($cacheKey, $saldo, 3600);

        return $saldo;
    }



















    function requestApi($endpoint, $data)
    {
        $url = 'https://ex-api-demo-yy.568win.com/web-root/restricted/player/' . $endpoint . '.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post($url, $data);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }

        return $responseData;
    }

    private function errorResponse($username, $errorCode)
    {
        if ($errorCode == '0') {
            $errorMessage = 'No Error';
        } else if ($errorCode == '1') {
            $errorMessage = 'Member not exist';
        } else if ($errorCode == '2') {
            $errorMessage = 'Invalid Ip';
        } else if ($errorCode == '3') {
            $errorMessage = 'Username empty';
        } else if ($errorCode == '4') {
            $errorMessage = 'CompanyKey Error';
        } else if ($errorCode == '5') {
            $errorMessage = 'Not enough balance';
        } else if ($errorCode == '6') {
            $errorMessage = 'Bet not exists';
        } else if ($errorCode == '7') {
            $errorMessage = 'Internal Error';
        } else if ($errorCode == '2001') {
            $errorMessage = 'Bet Already Settled';
        } else if ($errorCode == '2002') {
            $errorMessage = 'Bet Already Canceled';
        } else if ($errorCode == '2003') {
            $errorMessage = 'Bet Already Rollback';
        } else if ($errorCode == '5003') {
            $errorMessage = 'Bet With Same RefNo Exists';
        } else if ($errorCode == '5008') {
            $errorMessage = 'Bet Already Returned Stake';
        } else if ($errorCode == '9720') {
            $errorMessage = 'Withdraw request so frequent';
        } else {
            $errorMessage = 'Internal Error';
        }


        return response()->json([
            'AccountName' => $username,
            'Balance' => 0,
            'ErrorCode' => $errorCode,
            'ErrorMessage' => $errorMessage
        ])->header('Content-Type', 'application/json; charset=UTF-8');
    }

    private function generateTxnid($jenis)
    {
        $characters = '0123456789';
        $length = $jenis == 'D' ? 17 : 10;

        $maxAttempts = 5;
        $attempts = 0;

        while ($attempts < $maxAttempts) {
            $randomString = '';

            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            $randomString = $jenis . $randomString;
            $dataApiCheckBalance = [
                "TxnId" => $randomString,
                "CompanyKey" => env('COMPANY_KEY'),
                "ServerId" => env('SERVERID')
            ];

            $resultsApi = $this->requestApi('check-transaction-status', $dataApiCheckBalance);
            if ($resultsApi["error"]["id"] === 4602) {
                return $randomString;
            }

            $attempts++;
        }

        return null;
    }














    public function login($username, $iswap)
    {
        try {
            $dataLogin['Username'] = $username;
            $dataLogin['CompanyKey'] = env('COMPANY_KEY');
            $dataLogin['Portfolio'] = env('PORTFOLIO');
            $dataLogin['IsWapSports'] = $iswap;
            $dataLogin['ServerId'] = "YY-TEST";
            $getLogin = $this->requestApiLogin($dataLogin);
            return $getLogin;
        } catch (\Exception $e) {
            return $this->errorResponse($username, 99, $e->getMessage());
        }
    }

    function requestApiLogin($data)
    {
        $url = 'https://ex-api-demo-yy.568win.com/web-root/restricted/player/login.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post($url, $data);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }
        return ['url' => $responseData["url"]];
    }

    public function register(Request $request)
    {
        $token = $request->bearerToken();
        $expectedToken = env('BEARER_TOKEN');

        if ($token !== $expectedToken) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $data = [
            "Username" => $request->Username,
            "UserGroup" => "c",
            "Agent" => "Agent_C_001",
            "CompanyKey" => env('COMPANY_KEY'),
            "ServerId" => "YY-TEST"
        ];

        $url = 'https://ex-api-demo-yy.568win.com/web-root/restricted/player/register-player.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8'
        ])->post($url, $data);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }

        if ($responseData["error"]["id"] === 0) {
            return response()->json([
                'message' => 'Data berhasil disimpan.'
            ], 200);
        } else {
            return response()->json([
                'message' => $responseData["error"]["msg"] ?? 'Error tidak teridentifikasi.'
            ], 400);
        }
    }

    public function getRecomMatch(Request $request)
    {
        // $token = $request->bearerToken();
        // $expectedToken = env('BEARER_TOKEN');
        // if ($token !== $expectedToken) {
        //     return response()->json(['message' => 'Unauthorized.'], 401);
        // }

        $data = [
            "language" => 'en',
            "companyKey" => env('COMPANY_KEY'),
            "serverId" =>  env('SERVERID')
        ];

        $url = 'https://ex-api-demo-yy.568win.com/web-root/restricted/information/get-recommend-matches.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8'
        ])->post($url, $data);
        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }

        return $responseData;
    }

    public function deleteTransactions()
    {
        try {
            Transactions::query()->delete();
            TransactionStatus::query()->delete();
            TransactionSaldo::query()->delete();

            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data: ' . $e->getMessage()], 400);
        }
    }
}
