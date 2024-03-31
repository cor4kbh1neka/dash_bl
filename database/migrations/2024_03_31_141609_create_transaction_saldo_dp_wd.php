<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        Schema::create('transaction_saldo_dpwd', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('depowdid');
            $table->string('txnid');
            $table->string('jenis');
            $table->string('amount');
            $table->integer('urutan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_saldo_dpwd');
    }
};
