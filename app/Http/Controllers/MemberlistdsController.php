<?php

namespace App\Http\Controllers;

use App\Models\Member;
use GuzzleHttp\Psr7\Request;
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
            'username' => 'required',
            'password' => 'required',
            'usergroup' => 'required',
            'agentid' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        } else {
            try {
                $dataAgent = Agents::where('id', $request->agentid)->first();
                $dataRegisterPlayer = [
                    "Username" => $request->username,
                    "UserGroup" => $request->usergroup,
                    "Agent" => $dataAgent->username,
                    "CompanyKey" => $dataAgent->companykey,
                    "ServerId" => $dataAgent->serverid
                ];
                $reqRegisterPlayer = $this->reqRegisterPlayer($dataRegisterPlayer);

                if ($reqRegisterPlayer["error"]["id"] === 0) {
                    $data = $request->all();
                    $data['id'] = Str::uuid()->toString();
                    $data['password'] = bcrypt($data['password']);

                    Players::create($data);

                    return response()->json(['message' => 'Player baru berhasil dibuat.',]);
                }

                return response()->json(['errors' => [$reqRegisterPlayer["error"]["msg"]]], 400);
            } catch (\Exception $e) {
                dd($e->getMessage());
                return response()->json(['errors' => ['Terjadi kesalahan saat menyimpan data.']]);
            }
        }

        return response()->json([
            'message' => 'Data berhasil disimpan.',
        ]);
    }
}
