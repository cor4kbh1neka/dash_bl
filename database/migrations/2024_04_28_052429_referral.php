<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referral', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 50)->required();
            $table->string('downline', 50)->required();
            $table->string('refno', 50)->required();
            $table->decimal('amount', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referral');
    }
};
