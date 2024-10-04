<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id(); // Primary key
        $table->string('nama'); // User name
        $table->string('email')->unique(); // User email
        $table->string('npp'); // User NPP (employee number)
        $table->string('npp_supervisor'); // Supervisor's NPP
        $table->string('password'); // User password
        $table->timestamps(); // Created at and updated at timestamps
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
