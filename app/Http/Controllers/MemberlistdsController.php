<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class MemberlistdsController extends Controller
{
    public function index(Request $request)
    {
        $username = $request->input('username');
        $norek = $request->input('norek');
        $namerek = $request->input('namerek');
        $bank = $request->input('bank');
        $nope = $request->input('nope');
        $referral = $request->input('referral');
        $gabungdari = $request->input('gabungdari') == '' ? date('Y-m-d') : $request->input('gabungdari');
        $gabunghingga = $request->input('gabunghingga') == '' ? date('Y-m-d') : $request->input('gabunghingga');
        $status = $request->input('status');

        $query = Member::query();
        if ($username) {
            $query->where('username', 'like', '%' . $username . '%');
        }
        if ($norek) {
            $query->where('norek', 'like', '%' . $norek . '%');
        }
        if ($namerek) {
            $query->where('namerek', 'like', '%' . $namerek . '%');
        }
        if ($bank) {
            $query->where('bank', 'like', '%' . $bank . '%');
        }
        if ($nope) {
            $query->where('nohp', 'like', '%' . $nope . '%');
        }
        if ($referral) {
            $query->where('referral', 'like', '%' . $referral . '%');
        }
        if ($gabungdari && $gabunghingga) {
            $query->whereBetween('created_at', [$gabungdari . " 00:00:00", $gabunghingga . " 23:59:59"]);
        }
        if ($status) {
            $query->where('status', $status);
        }

        $members = $query->orderBy('created_at', 'DESC')->paginate(10);
        // ->map(function ($member) {
        //     $member->status = $member->status == 0 ? 'New Member' : 'Default';
        //     return $member;
        // });

        return view('memberlistds.index', [
            'title' => 'Member List',
            'data' => $members,
            'totalnote' => 0,
            'username' => $username,
            'norek' => $norek,
            'namerek' => $namerek,
            'bank' => $bank,
            'nope' => $nope,
            'referral' => $referral,
            'gabungdari' => $gabungdari,
            'gabunghingga' => $gabunghingga,
            'status' => $status
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

    public function updateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'xybanknamexyy' => 'required',
            'xybankuserxy' => 'required',
            'group' => 'required',
            'groupwd' => 'required',
            'xxybanknumberxy' => 'required'
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
                    Member::where('username', $request->xyusernamexxy)->update([
                        'bank' => $request->xybanknamexyy,
                        'namarek' => $request->xybankuserxy,
                        'norek' => $request->xxybanknumberxy
                    ]);

                    return redirect()->route('memberlistds')->with('success', 'Update data member berhasil.');
                }

                return redirect()->back()->with('error', $updateUser["status"]);
            } catch (\Exception $e) {
                dd($e->getMessage());
                return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
            }
        }
    }

    public function updatePassowrd(Request $request)
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
                    return redirect()->route('memberlistds')->with('success', 'Update password berhasil.');
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

                return redirect()->route('memberlistds')->with('success', 'Update informasi member berhasil.');
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
}
