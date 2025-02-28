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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('link_id')
                ->constrained('links')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->enum('game_type', ['LuckyNumber', 'FutureGame'])->default('LuckyNumber');
            $table->integer('result_number');
            $table->enum('result', ['Win', 'Lose']);
            $table->integer('win_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
