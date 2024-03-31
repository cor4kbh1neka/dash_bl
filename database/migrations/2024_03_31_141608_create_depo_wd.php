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
        Schema::create('depo_wd', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username');
            $table->decimal('balance', 10, 2);
            $table->string('keterangan')->nullable();
            $table->string('jenis');
            $table->string('bank')->nullable();
            $table->string('mbank')->nullable();
            $table->string('mnamarek')->nullable();
            $table->string('mnorek')->nullable();
            $table->boolean('isapprove');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depo_wd');
    }
};
