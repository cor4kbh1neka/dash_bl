<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('xtransmonth', function (Blueprint $table) {
            $table->id();
            $table->string('month')->nullable();
            $table->string('username');
            $table->integer('count_dp')->default(0);
            $table->integer('count_wd')->default(0);
            $table->decimal('sum_dp', 10, 2)->default(0);
            $table->decimal('sum_wd', 10, 2)->default(0);
            $table->decimal('sum_winloss', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('xtransmonth');
    }
};
