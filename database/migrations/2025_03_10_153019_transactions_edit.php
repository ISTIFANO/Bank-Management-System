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
          
            $table->string('name')->default('Ellamiri');
            $table->string('email')->default('aamirp@gmail.com');
        });        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns("name"); 
        Schema::dropColumns("email"); 
    }
};
