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
        Schema::create('bonus', function (Blueprint $table) {
            $table->id();
            $table->string('portfolio');
            $table->decimal('min_turnover', 15, 2)->default(0);
            $table->decimal('min_lose', 15, 2)->default(0);
            $table->decimal('persentase_rolingan')->default(0);
            $table->decimal('persentase_cashback')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonus');
    }
};
