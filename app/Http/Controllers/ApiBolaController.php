<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Transactions;
use App\Models\TransactionStatus;
use App\Models\TransactionSaldo;
use App\Models\TransactionsSaldoMin;
use App\Models\ProductType;
use App\Models\Member;
use App\Models\MemberAktif;
use App\Models\Outstanding;
use App\Models\Referral;
use App\Models\Xreferral;
use App\Models\Persentase;
use App\Models\Xtrans;

use Illuminate\Support\Facades\Http;

class ApiBolaController extends Controller

{
    public function GetBalance(Request $request)
    {
        $validasiSBO = $this->validasiSBO($request);

        if (isset($validasiSBO["ErrorCode"])) {
            return $validasiSBO;
        }

        $saldo = $validasiSBO["balance"];

        return [
            "AccountName" => $request->Username,
            "Balance" => $saldo,
            "ErrorCode" => 0,
            "ErrorMessage" => "No Error"
        ];
    }

    public function GetBetStatus(Request $request)
    {
        $validasiSBO = $this->validasiSBO($request);
        if (isset($validasiSBO["ErrorCode"])) {
            return $validasiSBO;
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


        return [
            'TransferCode' => $request->TransferCode,
            'TransactionId' => $request->TransactionId,
            "Status" => $status,
            'ErrorCode' => 0,
            'ErrorMessage' => 'No Error'
        ];
    }

    public function Deduct(Request $request)
    {
        $validasiSBO = $this->validasiSBO($request);
        if (isset($validasiSBO["ErrorCode"])) {
            return $validasiSBO;
        }

        return $this->setTransaction($request, $validasiSBO);
    }

    public function Settle(Request $request)
    {
        $validasiSBO = $this->validasiSBO($request);
        if (isset($validasiSBO["ErrorCode"])) {
            return $validasiSBO;
        }

        $dataTransactions = Transactions::where('transfercode', $request->TransferCode)->orderBy('created_at', 'DESC')->get();
        if ($dataTransactions->isEmpty()) {
            return $this->errorResponse($request->Username, 6);
        }
        foreach ($dataTransactions as $index => $dataTransaction) {
            $results[] = $this->setSettle($request, $dataTransaction, $index);
        }

        return reset($results);
    }

    public function Cancel(Request $request)
    {
        $validasiSBO = $this->validasiSBO($request);
        if (isset($validasiSBO["ErrorCode"])) {
            return $validasiSBO;
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

        if (isset($validasiSBO["ErrorCode"])) {
            return $validasiSBO;
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
            $txnid = $this->generateTxnid('D', 17);
            $transactionTransaction = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, "D", $request->Amount, 1);


            if ($transactionTransaction) {
                /* Add Saldo */
                $data = [
                    "Username" => $request->Username,
                    "TxnId" => $txnid,
                    "Amount" => $request->Amount,
                    "CompanyKey" => env('COMPANY_KEY'),
                    "ServerId" => env('SERVERID')
                ];
                $this->deposit($data, $transactionTransaction);

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

        $txnid = $this->generateTxnid('D', 17);
        if ($lastStatus === 'Running') {
            $createTransaction = $cekTransaction;
            $crteateStatusTransaction = $this->updateTranStatus($createTransaction->id, 'ReturnStake');

            if ($crteateStatusTransaction) {
                $transactionTransaction = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, "D", $request->CurrentStake, 1);

                if ($transactionTransaction) {
                    $data = [
                        "Username" => $request->Username,
                        "TxnId" => $txnid,
                        "Amount" => $request->CurrentStake,
                        "CompanyKey" => env('COMPANY_KEY'),
                        "ServerId" => env('SERVERID')
                    ];
                    $this->deposit($data, $transactionTransaction);

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







    /* ======================= OUTSTANDING ======================= */
    private function createOutstanding($data)
    {
        $dataOutstanding = Outstanding::where('transactionid', $data["transactionid"])->first();
        if (!$dataOutstanding) {
            return Outstanding::create($data);
        }
        return [];
    }

    private function deleteOutstanding($transfercode)
    {
        return Outstanding::where('transfercode', $transfercode)->delete();
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
        if ($data["error"]["id"] !== 0) {
            return $this->errorResponse($request->Username, 1);
        }

        if ($request->CompanyKey != env('COMPANY_KEY')) {
            return $this->errorResponse($request->Username, 4);
        }

        return $data;
    }

    /* ====================== Rollback ======================= */
    private function setRollback(Request $request, $dataTransaction)
    {
        try {
            $dataTransactions = Transactions::where('transactionid', $dataTransaction->transactionid)->first();
            $lastStatus = TransactionStatus::where('trans_id', $dataTransaction->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();
            if ($lastStatus->status === 'Cancel') {
                $crteateStatusTransaction = $this->updateTranStatus($dataTransaction->id, 'Rollback');
                return $this->rollbackTransaction($request, $dataTransaction, $crteateStatusTransaction);
            } else if ($lastStatus->status === 'Settled') {
                return $this->cancelTransaction($request, $dataTransaction, $lastStatus);
            } else if ($lastStatus->status === 'Rollback') {
                return $this->errorResponse($request->Username, 2003);
            } else {
                $this->errorResponse($request->Username, 6);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 200);
        }
    }

    private function rollbackTransaction(Request $request, $dataTransaction, $crteateStatusTransaction = null)
    {
        $lastRunningStatus = TransactionStatus::where('trans_id', $dataTransaction->id)->where('status', 'Running')->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

        if ($lastRunningStatus) {
            if ($request->ProductType == 3 || $request->ProductType == 7) {
                $totalAmount = TransactionSaldo::where('transtatus_id', $lastRunningStatus->id)->sum('amount');
            } else {
                $dataTransactions = TransactionSaldo::where('transtatus_id', $lastRunningStatus->id)->first();
                $totalAmount = $dataTransactions->amount;
            }
            $txnid = $this->generateTxnid('W', 10);

            if ($crteateStatusTransaction) {
                $this->createOutstanding([
                    "transactionid" => $dataTransaction->transactionid,
                    "transfercode" => $dataTransaction->transfercode,
                    "username" => $dataTransaction->username,
                    "portfolio" => ProductType::where('id', $request->ProductType)->first()->portfolio,
                    "gametype" => ($request->ProductType == 5 || $request->ProductType == 1) ? $request->ExtraInfo['sportType'] : ProductType::where('id', $request->ProductType)->first()->productsname,
                    "status" => 'Running',
                    "amount" => $totalAmount
                ]);

                $transactionTransaction = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, "W", $totalAmount, 3);

                if ($transactionTransaction) {
                    /* Potong Saldo */
                    $data = [
                        "Username" => $request->Username,
                        "txnId" => $txnid,
                        "IsFullAmount" => false,
                        "Amount" => $totalAmount,
                        "CompanyKey" => env('COMPANY_KEY'),
                        "ServerId" => env('SERVERID')
                    ];
                    $responseWD = $this->withdraw($data, $transactionTransaction);
                    if ($responseWD["error"]["id"] === 4501) {
                        $dataTransMin = TransactionsSaldoMin::where('transfercode', $request->TransferCode)->first();
                        if (!$dataTransMin) {
                            TransactionsSaldoMin::create([
                                'transaldo_id' => $transactionTransaction->id,
                                'transactionid' => '-',
                                'transfercode' => $request->TransferCode,
                                'username' => $request->Username,
                                'amount' => $totalAmount
                            ]);
                            $transactionTransaction->update([
                                'txnid' => null
                            ]);
                        }
                    }

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
            if ($lastStatus->status == 'Running' || $lastStatus->status == 'Rollback') {
                $this->deleteOutstanding($request->TransferCode);
            }

            $crteateStatusTransaction = $this->updateTranStatus($dataTransaction->id, 'Cancel');

            if ($crteateStatusTransaction) {

                if ($lastStatus->status == 'Settled') {
                    $dataTransactions = TransactionSaldo::where('transtatus_id', $lastStatus->id)->first();

                    $jenis = 'W';
                    $rangeNumber = 10;
                    $txnid = $this->generateTxnid($jenis, $rangeNumber);
                    $createSaldo1 = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $dataTransactions->amount, 1);
                    if ($createSaldo1) {
                        /* Potong Saldo */
                        $data = [
                            "Username" => $request->Username,
                            "txnId" => $txnid,
                            "IsFullAmount" => false,
                            "Amount" => $dataTransactions->amount,
                            "CompanyKey" => env('COMPANY_KEY'),
                            "ServerId" => env('SERVERID')
                        ];
                        $responseWD =  $this->withdraw($data, $createSaldo1);

                        if ($responseWD["error"]["id"] === 4501) {
                            $dataTransMin = TransactionsSaldoMin::where('transfercode', $request->TransferCode)->first();
                            if (!$dataTransMin) {
                                TransactionsSaldoMin::create([
                                    'transaldo_id' => $createSaldo1->id,
                                    'transactionid' => '-',
                                    'transfercode' => $request->TransferCode,
                                    'username' => $request->Username,
                                    'amount' => $dataTransactions->amount
                                ]);
                                $createSaldo1->update([
                                    'txnid' => null
                                ]);
                            }
                        }
                    }

                    if ($last2ndStatus->status != 'Running' || $last2ndStatus->status != 'Rollback') {
                        if ($request->ProductType == 3 || $request->ProductType == 7) {
                            $totalAmount = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->sum('amount');
                        } else {
                            $dataTransactions = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

                            $totalAmount = $dataTransactions->amount;
                        }

                        $jenis = 'D';
                        $rangeNumber = 17;
                        $txnid = $this->generateTxnid($jenis, $rangeNumber);
                        $createSaldo2 = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $totalAmount, 3);
                        if ($createSaldo2) {
                            /* Add Saldo */
                            $data = [
                                "Username" => $request->Username,
                                "TxnId" => $txnid,
                                "Amount" => $totalAmount,
                                "CompanyKey" => env('COMPANY_KEY'),
                                "ServerId" => env('SERVERID')
                            ];
                            $this->deposit($data, $createSaldo2);
                        }

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
                                $txnid = $this->generateTxnid($jenis, $rangeNumber);
                                $createSaldo3 = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $trReturnStake->amount, 2);
                                if ($createSaldo3) {
                                    /* Potong Saldo */
                                    $data = [
                                        "Username" => $request->Username,
                                        "txnId" => $txnid,
                                        "IsFullAmount" => false,
                                        "Amount" => $trReturnStake->amount,
                                        "CompanyKey" => env('COMPANY_KEY'),
                                        "ServerId" => env('SERVERID')
                                    ];
                                    $this->withdraw($data, $createSaldo3);
                                }
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
                    $txnid = $this->generateTxnid($jenis, $rangeNumber);

                    $createSaldo4 = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $totalAmount, 1);

                    if ($createSaldo4) {
                        /* Add Saldo */
                        $data = [
                            "Username" => $request->Username,
                            "TxnId" => $txnid,
                            "Amount" => $totalAmount,
                            "CompanyKey" => env('COMPANY_KEY'),
                            "ServerId" => env('SERVERID')
                        ];
                        $this->deposit($data, $createSaldo4);
                    }
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
                                $txnid = $this->generateTxnid($jenis, $rangeNumber);
                                $createSaldo5 = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $trReturnStake->amount, 1);

                                if ($createSaldo5) {
                                    /* Potong Saldo */
                                    $data = [
                                        "Username" => $request->Username,
                                        "txnId" => $txnid,
                                        "IsFullAmount" => false,
                                        "Amount" => $trReturnStake->amount,
                                        "CompanyKey" => env('COMPANY_KEY'),
                                        "ServerId" => env('SERVERID')
                                    ];
                                    $responseWD = $this->withdraw($data, $createSaldo5);

                                    if ($responseWD["error"]["id"] === 4501) {
                                        $dataTransMin = TransactionsSaldoMin::where('transfercode', $request->TransferCode)->first();
                                        if (!$dataTransMin) {
                                            TransactionsSaldoMin::create([
                                                'transaldo_id' => $createSaldo5->id,
                                                'transactionid' => '-',
                                                'transfercode' => $request->TransferCode,
                                                'username' => $request->Username,
                                                'amount' => $trReturnStake->amount
                                            ]);
                                            $createSaldo5->update([
                                                'txnid' => null
                                            ]);
                                        }
                                    }
                                }
                            }
                        }

                        $jenis = 'D';
                        $rangeNumber = 17;
                        $txnid = $this->generateTxnid($jenis, $rangeNumber);
                        $createSaldo6 = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $totalAmount, 2);
                        if ($createSaldo6) {
                            /* Add Saldo */
                            $data = [
                                "Username" => $request->Username,
                                "TxnId" => $txnid,
                                "Amount" => $totalAmount,
                                "CompanyKey" => env('COMPANY_KEY'),
                                "ServerId" => env('SERVERID')
                            ];
                            $this->deposit($data, $createSaldo6);
                        }
                    }
                }
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

    private function cancelTransaction(Request $request, $dataTransaction, $lastStatus)
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
            $rangeNumber = 10;
            $txnid = $this->generateTxnid($jenis, $rangeNumber);
            $createSaldo1 = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $dataTransactions->amount, 1);

            if ($createSaldo1) {
                /* Potong Saldo */
                $data = [
                    "Username" => $request->Username,
                    "txnId" => $txnid,
                    "IsFullAmount" => false,
                    "Amount" => $dataTransactions->amount,
                    "CompanyKey" => env('COMPANY_KEY'),
                    "ServerId" => env('SERVERID')
                ];
                $responseWD = $this->withdraw($data, $createSaldo1);
                if ($responseWD["error"]["id"] === 4501) {
                    $dataTransMin = TransactionsSaldoMin::where('transfercode', $request->TransferCode)->first();
                    if (!$dataTransMin) {
                        TransactionsSaldoMin::create([
                            'transaldo_id' => $createSaldo1->id,
                            'transactionid' => '-',
                            'transfercode' => $request->TransferCode,
                            'username' => $request->Username,
                            'amount' => $dataTransactions->amount
                        ]);
                        $createSaldo1->update([
                            'txnid' => null
                        ]);
                    }
                }
            }

            if ($last2ndStatus->status != 'Running' || $last2ndStatus->status != 'Rollback') {
                if ($request->ProductType == 3 || $request->ProductType == 7) {
                    $totalAmount = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->sum('amount');
                } else {
                    $dataTransactions = TransactionSaldo::where('transtatus_id', $last2ndStatus->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

                    $totalAmount = $dataTransactions->amount;
                }

                $jenis = 'D';
                $rangeNumber = 17;
                $txnid = $this->generateTxnid($jenis, $rangeNumber);
                $createSaldo2 = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, $jenis, $totalAmount, 2);

                if ($createSaldo2) {
                    /* Add Saldo */
                    $data = [
                        "Username" => $request->Username,
                        "TxnId" => $txnid,
                        "Amount" => $totalAmount,
                        "CompanyKey" => env('COMPANY_KEY'),
                        "ServerId" => env('SERVERID')
                    ];
                    $this->deposit($data, $createSaldo2);
                }
            }

            return $this->rollbackTransaction($request, $dataTransaction, $crteateStatusTransaction);
        }
    }

    /* ====================== Settle ======================= */
    private function setSettle(Request $request, $dataTransaction, $index)
    {
        $dataStatusTransaction = TransactionStatus::where('trans_id', $dataTransaction->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

        if ($dataStatusTransaction->status == 'Running' || $dataStatusTransaction->status == 'Rollback' || $dataStatusTransaction->status == 'ReturnStake') {
            $txnid = $this->generateTxnid('D', 17);

            $crteateStatusTransaction = $this->updateTranStatus($dataTransaction->id, 'Settled');
            if ($crteateStatusTransaction) {
                $this->deleteOutstanding($request->TransferCode);

                $WinLoss = $index == 0 ? $request->WinLoss : 0;
                $transactionTransaction = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, "D", $WinLoss, 1);
                if ($transactionTransaction) {

                    $checkXtrans = Xtrans::where('username', $request->Username)->whereDate('created_at', '=', date('Y-m-d'))->first();

                    if ($WinLoss >= 0) {
                        if ($checkXtrans) {
                            $checkXtrans->update([
                                'sum_winloss' => $checkXtrans->sum_winloss + $WinLoss
                            ]);
                        } else {
                            Xtrans::create([
                                'bank' => '-'
                            ]);
                        }
                        /* Add Saldo */
                        $data = [
                            "Username" => $request->Username,
                            "TxnId" => $txnid,
                            "Amount" => $WinLoss,
                            "CompanyKey" => env('COMPANY_KEY'),
                            "ServerId" => env('SERVERID')
                        ];
                        $this->deposit($data, $transactionTransaction);
                    } else {
                    }

                    /* Record Data Referral */
                    if ($WinLoss <= 0 && $WinLoss >= 0) {
                        $this->execReferral($request, $dataStatusTransaction, $WinLoss);
                    }

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

    private function execReferral(Request $request, $dataStatusTransaction, $WinLoss)
    {
        $dataAktif = MemberAktif::where('username', $request->Username)->first();
        if (!$dataAktif) {
            $dataAktif = Member::where('username', $request->Username)->first();
        }

        if ($dataAktif) {
            $amount = TransactionSaldo::where('transtatus_id', $dataStatusTransaction->id)->first()->amount;
            $persentase = Persentase::first();
            $persentase = $persentase ? $persentase->persentase : 0;

            $referralAmount = $amount * $persentase;

            if ($referralAmount > 0) {
                $attempt = 0;
                while ($attempt < 5) {
                    if ($WinLoss === 0) {
                        $txnidReferral = $this->generateTxnid('D', 17);
                        $dataDepoReferral = [
                            "Username" => $dataAktif->referral,
                            "TxnId" => $txnidReferral,
                            "Amount" => $referralAmount,
                            "CompanyKey" => env('COMPANY_KEY'),
                            "ServerId" => env('SERVERID')
                        ];
                        $depositReferral = $this->requestApi('deposit', $dataDepoReferral);
                        if ($depositReferral["error"]["id"] === 0) {
                            Referral::create([
                                'username' => $dataAktif->referral,
                                'downline' => $request->Username,
                                'amount' => $referralAmount
                            ]);

                            $this->execXreferral($dataAktif->referral, $referralAmount);
                            break;
                        }
                    }

                    $attempt++;
                }
            }
        }
    }

    private function execXreferral($username, $amount)
    {
        $dataXreferrral = Xreferral::where('username', $username)->first();
        if ($dataXreferrral) {
            $dataXreferrral->update([
                'sum_amount' => $dataXreferrral->sum_amount + $amount
            ]);
        } else {
            Xreferral::create([
                'username' => $username,
                'count_referral' => 0,
                'sum_amount' => $amount
            ]);
        }
    }

    private function deposit($data, $transactionTransaction)
    {
        $deductBalence = $this->requestApi('deposit', $data);

        $maxAttempts4404 = 10;
        $attempt4404 = 0;
        while ($deductBalence["error"]["id"] === 4404 && $attempt4404 < $maxAttempts4404) {
            $txnid = $this->generateTxnid('D', 17);
            $data["txnId"] = $txnid;
            $deductBalence = $this->requestApi('deposit', $data);
            if ($deductBalence["error"]["id"] === 0) {
                $transactionTransaction->update([
                    'txnid' => $txnid
                ]);
            }
            $attempt4404++;
        }
        return $deductBalence;
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

    private function setTransaction(Request $request, $validasiSBO)
    {
        $saldoMember = $validasiSBO["balance"];
        $cekTransaction = Transactions::where('transactionid', $request->TransactionId)->first();

        if ($cekTransaction) {
            if ($request->ProductType == 3 || $request->ProductType == 7) {
                $cekLastStatus = TransactionStatus::where('trans_id', $cekTransaction->id)->orderBy('created_at', 'DESC')->orderBy('urutan', 'DESC')->first();

                if ($cekLastStatus->status == 'Running') {
                    $totalTransaction = TransactionSaldo::where('transtatus_id', $cekLastStatus->id)->sum('amount');
                    if (!($request->Amount > $totalTransaction)) {
                        return $this->errorResponse($request->Username, 7);
                    }
                } else {
                    return $this->errorResponse($request->Username, 5003);
                }

                $dataTransactions = TransactionSaldo::where('transtatus_id', $cekLastStatus->id)->first();
                $saldoMember = $saldoMember + $dataTransactions->amount;
            } else {
                return $this->errorResponse($request->Username, 5003);
            }
        }

        if ($saldoMember < $request->Amount) {
            return $this->errorResponse($request->Username, 5);
        }

        $txnid = $this->generateTxnid('W', 10);

        if (($request->ProductType == 3 || $request->ProductType == 7) && $cekTransaction) {
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
                $amount = $request->Amount;
                $transactionTransaction = $this->createSaldoTransaction($crteateStatusTransaction->id, $txnid, "W", $request->Amount, 1);
            }

            if ($transactionTransaction) {
                /* Potong Saldo */
                $data = [
                    "Username" => $request->Username,
                    "txnId" => $txnid,
                    "IsFullAmount" => false,
                    "Amount" => $amount,
                    "CompanyKey" => env('COMPANY_KEY'),
                    "ServerId" => env('SERVERID')
                ];
                $this->withdraw($data, $transactionTransaction);

                /* Create Outstanding */
                $this->createOutstanding([
                    "transactionid" => $request->TransactionId,
                    "transfercode" => $request->TransferCode,
                    "username" => $request->Username,
                    "portfolio" => ProductType::where('id', $request->ProductType)->first()->portfolio,
                    "gametype" => isset($request->ExtraInfo['sportType']) ? $request->ExtraInfo['sportType'] : ProductType::where('id', $request->ProductType)->first()->productsname,
                    "status" => 'Running',
                    "amount" => $amount
                ]);

                $saldo = $this->apiGetBalance($request)["balance"];
                return [
                    'AccountName' => $request->Username,
                    'Balance' => $saldo,
                    'ErrorCode' => 0,
                    'ErrorMessage' => 'No Error'
                ];
            }
        }
    }

    private function withdraw($data, $transactionTransaction)
    {
        $WdSaldo = $this->requestApi('withdraw', $data);

        $maxAttempts9720 = 10;
        $attempt9720 = 0;
        while ($WdSaldo["error"]["id"] === 9720 && $attempt9720 < $maxAttempts9720) {
            sleep(6);
            $WdSaldo = $this->requestApi('withdraw', $data);
            $attempt9720++;
        }

        $maxAttempts4404 = 10;
        $attempt4404 = 0;
        while ($WdSaldo["error"]["id"] === 4404 && $attempt4404 < $maxAttempts4404) {
            $txnid = $this->generateTxnid('W', 10);
            $data["txnId"] = $txnid;
            $WdSaldo = $this->requestApi('withdraw', $data);
            if ($WdSaldo["error"]["id"] === 0) {
                $transactionTransaction->update([
                    'txnid' => $txnid
                ]);
            }
            $attempt4404++;
        }

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

    private function createSaldoTransaction($transtatus_id, $txnid, $jenis, $amount, $urutan)
    {
        $results = TransactionSaldo::create([
            "transtatus_id" => $transtatus_id,
            "txnid" => $txnid,
            "jenis" => $jenis,
            "amount" => $amount,
            "urutan" => $urutan
        ]);

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
        $dataSaldo = [
            "Username" => $request->Username,
            "CompanyKey" => env('COMPANY_KEY'),
            "ServerId" => env('SERVERID')
        ];
        $saldo = $this->requestApi('get-player-balance', $dataSaldo);

        $dataMinSaldo = TransactionsSaldoMin::where('username', $request->Username)->get();
        $totalMinSaldo = $dataMinSaldo->sum('amount');

        if ($totalMinSaldo > 0 && ($saldo['balance'] >= $totalMinSaldo)) {
            foreach ($dataMinSaldo as $d) {
                $txnid = $this->generateTxnid('W', 10);

                /* Potong Saldo */
                $data = [
                    "Username" => $d->username,
                    "txnId" => $txnid,
                    "IsFullAmount" => false,
                    "Amount" => $d->amount,
                    "CompanyKey" => env('COMPANY_KEY'),
                    "ServerId" => env('SERVERID')
                ];
                $responseWD = $this->withdraw($data, $d);

                if ($responseWD["error"]["id"] === 0) {
                    $dataTransSaldo = TransactionSaldo::where('id', $d->transaldo_id)->first();
                    if ($dataTransSaldo) {
                        if ($dataTransSaldo->txnid == null || $dataTransSaldo->txnid == '') {
                            $dataTransSaldo->update([
                                'txnid' => $txnid
                            ]);
                        }
                        $saldo['balance'] = $saldo['balance'] - $d->amount;
                        TransactionsSaldoMin::where('id', $d->id)->delete();
                    } else {
                        TransactionsSaldoMin::where('id', $d->id)->delete();
                    }
                }
            }
        } else if ($totalMinSaldo > 0 && ($saldo['balance'] < $totalMinSaldo)) {
            $saldo['balance'] = $saldo['balance'] - $totalMinSaldo;
        }

        return $saldo;
    }



















    function requestApi($endpoint, $data)
    {
        $url = 'https://ex-api-demo-yy.568win.com/web-root/restricted/player/' . $endpoint . '.aspx';

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post($url, $data);

        $responseData = $response->json();

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

        return [
            'AccountName' => $username,
            'Balance' => 0,
            'ErrorCode' => $errorCode,
            'ErrorMessage' => $errorMessage
        ];
    }

    function generateTxnid($jenis, $length)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        if ($jenis == 'D') {
            $length = 17;
        } else {
            $length = 10;
        }

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        $randomString = $jenis . $randomString;
        return $randomString;
    }
}
