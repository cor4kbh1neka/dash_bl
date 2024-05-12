<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('history_transaksi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username');
            $table->string('invoice');
            $table->string('keterangan');
            $table->string('status');
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('kredit', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('history_transaksi');
    }
};
