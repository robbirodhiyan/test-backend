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
        Schema::create('epresences', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('id_users')->constrained('users')->onDelete('cascade'); // Foreign key referencing the users table
            $table->enum('type', ['IN', 'OUT']); // Type of presence (IN or OUT)
            $table->boolean('is_approve')->default(false); // Approval status (default is false)
            $table->timestamp('waktu'); // Time of attendance
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epresences');
    }
};
