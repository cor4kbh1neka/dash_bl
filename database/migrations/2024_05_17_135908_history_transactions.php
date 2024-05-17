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
        Schema::create('history_tansactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username')->nullable();
            $table->string('invoice')->nullable();
            $table->string('transfercode')->nullable();
            $table->string('refno')->nullable();
            $table->string('keterangan')->nullable();
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('kredit', 15, 2)->default(0);
            $table->decimal('balance', 15, 2)->default(0);
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_tansactions');
    }
};
