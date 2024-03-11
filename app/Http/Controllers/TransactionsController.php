<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Support\Facades\DB;


class TransactionsController extends Controller
{
    public function index()
    {
        $query = "SELECT A.id, A.username, A.usergroup, B.username as useragent, B.companykey, B.serverid 
        FROM user_players A
        INNER JOIN user_agents B ON A.agentid = B.id";

        $results = DB::select($query);

        return view('transactions.index', [
            'title' => 'Transactions',
            'data' => $results
        ]);
    }
}
