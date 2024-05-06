<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('xreferral', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 50)->required();
            $table->integer('count_referral')->default(0);
            $table->decimal('sum_amount', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('xreferral');
    }
};
