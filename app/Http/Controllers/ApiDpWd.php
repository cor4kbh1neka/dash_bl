<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Transactions;
use App\Models\TransactionStatus;
use App\Models\TransactionSaldo;
use Illuminate\Support\Facades\Http;
use App\Jobs\createWdJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Cache;


class ApiDpWdControllers extends Controller
{
    public function deposit(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'balance' => 'required| ',
            'keterangan' => 'required',
            'bank' => 'required',
            'mbank' => 'required',
            'mnamarek' => 'required',
            'mnorek' => 'required'
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created  .');
    }
}
