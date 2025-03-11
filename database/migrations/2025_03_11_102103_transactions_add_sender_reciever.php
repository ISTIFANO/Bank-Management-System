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
        Schema::table('transactions', function (Blueprint $table) {
          
            $table->foreignId('sender_id')->constrained('wallets')->onDelete('cascade')->default(1);
            $table->foreignId('receiver_id')->constrained('wallets')->onDelete('cascade')->default(1);
        });    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('receiver_id');
            $table->dropColumn('sender_id');

        });    }
};
