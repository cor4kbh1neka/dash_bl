<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\Companys;
use App\Models\Currencys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AgentdsController extends Controller
{
    public function index()
    {
        $data = [
            [
                'id' => '1',
                'nama' => 'Waantos',
                'alamat' => 'Pekanbaru',
                'notelp' => '0778007711',
                'tgllhir' => '12-09-1996',
                'tempatlahir' => 'sukajadi'
            ]
        ];
        return view('agentds.index', [
            'title' => 'Agent',
            'data' => $data,
            'totalnote' => 0,
        ]);
    }

    public function create()
    {

        return view('agentds.create', [
            'title' => 'Add New Agent',
            'totalnote' => 0,
        ]);
    }

    public function agentupdate()
    {

        return view('agentds.agent_update', [
            'title' => 'Update Agent',
            'totalnote' => 0,
        ]);
    }

    public function agentinfo()
    {

        return view('agentds.agent_info', [
            'title' => 'Informasi Agent',
            'totalnote' => 0,
        ]);
    }

    public function access()
    {

        return view('agentds.access', [
            'title' => 'Access Agent',
            'totalnote' => 0,
        ]);
    }

    public function accessupdate()
    {

        return view('agentds.access_update', [
            'title' => 'Access Agent Update',
            'totalnote' => 0,
        ]);
    }

    public function accessadd()
    {

        return view('agentds.access_add', [
            'title' => 'Add Access Agent',
            'totalnote' => 0,
        ]);
    }
}
