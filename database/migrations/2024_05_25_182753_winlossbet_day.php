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
        Schema::create('winlossbet_day', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('portfolio');
            $table->integer('count')->default(0);
            $table->string('day');
            $table->string('month');
            $table->string('year');
            $table->decimal('stake', 15, 2)->default(0);
            $table->decimal('winloss', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('winlossbet_day');
    }
};
