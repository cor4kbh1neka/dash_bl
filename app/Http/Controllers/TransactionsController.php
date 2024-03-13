<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Support\Facades\DB;


class TransactionsController extends Controller
{
    public function index()
    {
        $data = Transactions::get();
        return view('transactions.index', [
            'title' => 'Transactions',
            'data' => $data
        ]);
    }
}
