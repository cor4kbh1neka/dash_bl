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
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            // tambahkan validasi lainnya sesuai kebutuhan
        ]);

        // Simpan data baru
        Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }
}
