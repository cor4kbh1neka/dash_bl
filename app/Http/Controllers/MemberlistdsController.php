<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class MemberlistdsController extends Controller
{
    public function index()
    {
        $members = Member::orderBy('created_at', 'DESC')
            ->get();
        // ->map(function ($member) {
        //     $member->status = $member->status == 0 ? 'New Member' : 'Default';
        //     return $member;
        // });

        return view('memberlistds.index', [
            'title' => 'Member List',
            'data' => $members,
            'totalnote' => 0,
        ]);
    }

    public function update($id)
    {
        $data = Member::where('id', $id)->first();
        $dataUser = $this->getApiUser($data->username);
        if (is_array($dataUser)) {
            $dataUser = $dataUser["data"]["datauser"];
        } else {
            $dataUser = [];
        }

        return view('memberlistds.update', [
            'title' => 'Edit Member',
            'data' => $data,
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

                    return redirect()->back()->with('success', 'Update data member berhasil.');
                }

                return redirect()->back()->with('error', $updateUser["status"]);
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
}
