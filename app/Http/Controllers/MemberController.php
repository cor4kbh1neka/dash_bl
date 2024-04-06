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
}
