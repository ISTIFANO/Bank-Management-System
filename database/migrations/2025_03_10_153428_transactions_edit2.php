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
            $table->dropColumn('receiver_id');
            $table->dropColumn('sender_id');

        });
            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
          
            $table->string('receiver_id');
            $table->string('sender_id');;
        });
    }
};
