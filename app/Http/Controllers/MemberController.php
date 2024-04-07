<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;


class MemberController extends Controller
{
    public function index()
    {
        $member = Member::latest()->get();
        return view('member.index', [
            'title' => 'Member',
            'data' => $member,
            'totalnote' => 0,
        ]);
    }

    public function create()
    {
        return view('member.create', [
            'title' => 'Member',
            'totalnote' => 0,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'xyusernamexxy' => 'required',
            'password' => 'required',
            'xybanknamexyy' => 'required',
            'xybankuserxy' => 'required',
            'xxybanknumberxy' => 'required',
            'xyx11xuser_mailxxyy' => 'required',
            'xynumbphonexyyy' => 'required'
        ]);

        $resultReqApi = $this->reqApiRegisterMember($request->all());

        if (!is_array($resultReqApi)) {
            $resultReqApi = str_replace("Error: 400 - ", "", $resultReqApi);
            $resultReqApi = json_decode($resultReqApi, true);
        }

        if ($resultReqApi["status"] === "success") {
            $dataSeamless = [
                'Username' => $resultReqApi["data"]["addedUser"]["username"],
                'UserGroup' => 'c',
                "Agent" => env('AGENTID'),
                'CompanyKey' => env('COMPANY_KEY'),
                'ServerId' => env('SERVERID'),
            ];
            $resultReqApiSeamless = $this->reqApiRegisterMemberSeamless($dataSeamless);

            if ($resultReqApiSeamless["error"]["id"] === 0) {
                $member = new Member();
                $member->username = $request->xyusernamexxy;
                $member->balance = 0;
                $member->status = 0;
                $member->save();

                $dataMember = Member::latest()->get();
                if ($member->save()) {
                    return redirect('/member')->with([
                        'status' => "success",
                        'message' => 'User berhasil dibuat',
                        'data' => $dataMember,
                        'totalnote' => 0,
                    ]);
                } else {
                    return redirect('/member')->with([
                        'status' => "fail",
                        'message' => 'Gagal membuat user',
                        'data' => $dataMember,
                        'totalnote' => 0,
                    ]);
                }
            }

            $dataMember = Member::latest()->get();
            return redirect('/member')->with([
                'status' => "fail",
                'message' => $resultReqApi["message"],
                'data' => $dataMember,
                'totalnote' => 0,
            ]);
        }

        $dataMember = Member::latest()->get();
        return redirect('/member')->with([
            'status' => "fail",
            'message' => $resultReqApi["message"],
            'data' => $dataMember,
            'totalnote' => 0,
        ]);
    }



    private function reqApiRegisterMember($req)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post('https://back-staging.bosraka.com/users', $req);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }

        return $responseData;
    }

    private function reqApiRegisterMemberSeamless($req)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json; charset=UTF-8',
        ])->post('https://ex-api-demo-yy.568win.com/web-root/restricted/player/register-player.aspx', $req);

        if ($response->successful()) {
            $responseData = $response->json();
        } else {
            $statusCode = $response->status();
            $errorMessage = $response->body();
            $responseData = "Error: $statusCode - $errorMessage";
        }

        return $responseData;
    }
}
