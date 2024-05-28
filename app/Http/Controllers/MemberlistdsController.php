<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Member;
use App\Models\DepoWd;
use App\Models\ListError;
use App\Models\Referral1;
use App\Models\Referral2;
use App\Models\Referral3;
use App\Models\Referral4;
use App\Models\Referral5;
use App\Models\winlossDay;
use App\Models\winlossMonth;
use App\Models\winlossYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class MemberlistdsController extends Controller
{
    // public function index(Request $request)
    // {
    //     $username = $request->input('username');
    //     $checkusername = $request->input('checkusername');
    //     $norek = $request->input('norek');
    //     $namerek = $request->input('namerek');
    //     $bank = $request->input('bank');
    //     $nope = $request->input('nope');
    //     $referral = $request->input('referral');
    //     $gabungdari = $request->input('gabungdari') == '' ? date('Y-m-d') : $request->input('gabungdari');
    //     $gabunghingga = $request->input('gabunghingga') == '' ? date('Y-m-d') : $request->input('gabunghingga');
    //     $status = $request->input('status');

    //     $query = Member::query()->join('balance', 'balance.username', '=', 'member.username')
    //         ->select('member.*', 'balance.amount');;
    //     if ($username) {
    //         if (!isset($checkusername)) {
    //             $query->where('member.username', 'like', '%' . $username . '%');
    //         } else {
    //             $query->where('member.username',  $username);
    //         }
    //     }
    //     if ($norek) {
    //         $query->where('norek', 'like', '%' . $norek . '%');
    //     }
    //     if ($namerek) {
    //         $query->where('namerek', 'like', '%' . $namerek . '%');
    //     }
    //     if ($bank) {
    //         $query->where('bank', 'like', '%' . $bank . '%');
    //     }
    //     if ($nope) {
    //         $query->where('nohp', 'like', '%' . $nope . '%');
    //     }
    //     if ($referral) {
    //         $query->where('referral', 'like', '%' . $referral . '%');
    //     }
    //     if ($gabungdari && $gabunghingga) {
    //        $query->whereBetween('member.created_at', [$gabungdari . " 00:00:00", $gabunghingga . " 23:59:59"]);
    //     }
    //     if ($status) {
    //         $query->where('status', $status);
    //     }

    //     $members = $query->orderBy('member.created_at', 'DESC')->get();
    //     dd($members);
    //     // $data = $this->filterAndPaginate($members, 10);

    //     // ->map(function ($member) {
    //     //     $member->status = $member->status == 0 ? 'New Member' : 'Default';
    //     //     return $member;
    //     // });

    //     return view('memberlistds.index', [
    //         'title' => 'Member List',
    //         'data' => $members,
    //         'totalnote' => 0,
    //         'username' => $username,
    //         'norek' => $norek,
    //         'namerek' => $namerek,
    //         'bank' => $bank,
    //         'nope' => $nope,
    //         'referral' => $referral,
    //         'gabungdari' => $gabungdari,
    //         'gabunghingga' => $gabunghingga,
    //         'status' => $status,
    //         'checkusername' => $checkusername
    //     ]);
    // }
    public function index()
    {
        $query = Member::query()->join('balance', 'balance.username', '=', 'member.username')
                    ->select('member.*', 'balance.amount');
        $data = $this->filterAndPaginate($query->get(), 10);
        return view('memberlistds.index', [
            'title' => 'Member List',
            'data' => $data,
        ]);
    }

    public function update($id)
    {
        $data = Member::where('id', $id)->first();

        if ($data) {
            $username = $data->username;
        } else {
            $username = $id;
        }

        $dataUser = $this->getApiUser($username);
        if (is_array($dataUser)) {
            $dataUser = $dataUser["data"]["datauser"];
        } else {
            $dataUser = [];
        }

        return view('memberlistds.update', [
            'title' => 'Edit Member',
            'data' => $data,
            'id' => $id,
            'datauser' => $dataUser,
            'totalnote' => 0,
        ]);
    }

    private function getApiUser($username)
    {
        $url = 'https://back-staging.bosraka.com/users/' . $username;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->get($url);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }

        return $responseData;
    }

    public function updateUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'xybanknamexyy' => 'required',
            'xybankuserxy' => 'required',
            'group' => 'required',
            'groupwd' => 'required',
            'xxybanknumberxy' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            try {
                $data = [
                    "xybanknamexyy" => $request->xybanknamexyy,
                    "xybankuserxy" => $request->xybankuserxy,
                    "group" => $request->group,
                    "groupwd" => $request->groupwd,
                    "xxybanknumberxy" => $request->xxybanknumberxy,
                ];
                $updateUser = $this->reqApiUpdateUser($data, $request->xyusernamexxy);

                if ($updateUser["status"] === 'success') {

                    $this->updateIsVerif($request->xyusernamexxy, $request->isverified);

                    Member::where('username', $request->xyusernamexxy)->update([
                        'bank' => $request->xybanknamexyy,
                        'namarek' => $request->xybankuserxy,
                        'norek' => $request->xxybanknumberxy
                    ]);

                    return redirect('/memberlistds/edit/' . $id)->with('success', 'Update data member berhasil.');
                }

                return redirect()->back()->with('error', $updateUser["status"]);
            } catch (\Exception $e) {
                dd($e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
            }
        }
    }

    private function updateIsVerif($username, $isverified)
    {

        $url = 'https://back-staging.bosraka.com/users/vip/' . $username;
        $data = [
            "is_verified" => $isverified == 1 ? true : false
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->put($url, $data);

        $responseData = $response->json();
        return $responseData;
    }

    public function updatePassowrd(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'xyusernamexxy' => 'required',
                'changepassword' => 'required',
                'repassword' => 'required|same:changepassword',
            ],
            [
                'repassword.same' => 'Konfirmasi password harus sama dengan password.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            try {
                $data = [
                    "password" => $request->changepassword,
                ];

                $updateUser = $this->reqApiUpdatePassword($data, $request->xyusernamexxy);

                if ($updateUser["status"] === 'success') {
                    return redirect('/memberlistds/edit/' . $id)->with('success', 'Update password berhasil.');
                }

                return redirect()->back()->with('error', $updateUser["status"]);
            } catch (\Exception $e) {
                dd($e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
            }
        }
    }

    public function updateMember(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'minbet' => 'required|numeric|min:0',
            'maxbet' => 'required|numeric|min:0',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            try {
                Member::where('id', $id)->update([
                    'keterangan' => $request->informasiplayer,
                    'status' => $request->status,
                    'max_bet' => $request->minbet,
                    'min_bet' => $request->maxbet
                ]);

                return redirect('/memberlistds/edit/' . $id)->with('success', 'Update informasi member berhasil.');
            } catch (\Exception $e) {
                dd($e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
            }
        }
    }


    private function reqApiUpdateUser($data, $username)
    {
        $url = 'https://back-staging.bosraka.com/users/' . $username;
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->put($url, $data);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            // $responseData = "Error: $statusCode - $errorMessage";
            $responseData = $response->json();
        }

        return $responseData;
    }

    private function reqApiUpdatePassword($data, $username)
    {
        $url = 'https://back-staging.bosraka.com/users/pswdy/' . $username;
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->put($url, $data);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            // $responseData = "Error: $statusCode - $errorMessage";
            $responseData = $response->json();
        }

        return $responseData;
    }

    public function winloseyear($username)
    {
        $data = winlossYear::where('username', $username)->get();
        return view('memberlistds.winlose_year', [
            'title' => 'Win Lose Informasi',
            'totalnote' => 0,
            'data' => $data,
            'username' => $username
        ]);
    }

    public function winlosemonth($username, $year)
    {
        $data = winlossMonth::where('username', $username)->where('year', $year)->get();
        return view('memberlistds.winlose_month', [
            'title' => 'Win Lose Informasi',
            'totalnote' => 0,
            'data' => $data,
            'username' => $username,
            'year' => $year
        ]);
    }

    public function winloseday($username, $year, $month)
    {
        $data = winlossDay::where('username', $username)->where('year', $year)->where('month', $month)->get();
        return view('memberlistds.winlose_day', [
            'title' => 'Win Lose Informasi',
            'totalnote' => 0,
            'username' => $username,
            'data' => $data,
            'year' => $year,
            'month' => $month
        ]);
    }

    public function historybank($username)
    {
        $data = DepoWd::where('username', $username)->where('status', '>', 0)->get();
        return view('memberlistds.history_bank', [
            'title' => 'History Bank',
            'totalnote' => 0,
            'data' => $data,
            'username' => $username
        ]);
    }
    public function filterAndPaginate($data, $page) // ini versi yang lengkap
    {
        $query = collect($data);
        $parameter = [
            'username',
            'norek',
            'namarek',
            'bank',
            'nohp',
            'referral',
            'status',
        ]; 

        foreach ($parameter as $isiSearch) {
            if (request($isiSearch)) {
                $query = $query->filter(function ($item) use ($isiSearch) {
                    return stripos($item[$isiSearch], request($isiSearch)) !== false;
                });
            }
        }
        // Tambahan Filter Tanggal, comment aja klau tidak terpakai :D
        if (request('gabungdari') && request('gabunghingga')) {
            $gabungdari = request('gabungdari') . " 00:00:00";
            $gabunghingga = request('gabunghingga') . " 23:59:59";
            $query = $query->whereBetween('created_at', [$gabungdari, $gabunghingga]);
        }
        // Filter untuk strict username
        if (request('checkusername')) {
            $inputUsername = request('username');
            $query = $query->filter(function ($item) use ($inputUsername) {
                return $item['username'] === $inputUsername;
            });
        }

        $parameter = array_merge($parameter, [
            'gabungdari', 
            'gabunghingga', 
            'checkusername'
        ]);

        $currentPage = Paginator::resolveCurrentPage();
        $perPage = $page;
        $currentPageItems = $query->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedItems = new LengthAwarePaginator(
            $currentPageItems,
            $query->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );
        foreach ($parameter as $isiSearch) {
            if (request($isiSearch)) {
                $paginatedItems->appends($isiSearch, request($isiSearch));
            }
        }
        return $paginatedItems;
    }
}
