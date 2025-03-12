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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('wallets')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('wallets')->onDelete('cascade');
            $table->float('amount');
            $table->string('description')->nullable();
            $table->timestamp('date')->useCurrent();
            $table->timestamps();
        });    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');

    }
};
