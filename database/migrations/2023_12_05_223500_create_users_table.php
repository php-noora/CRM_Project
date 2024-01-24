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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('firstname');
            $table->string('lastname');
            $table->integer('age');
            $table->string('email');
            $table->string('phonenumber');
            $table->string('password');
            $table->string('postal_code');
            $table->string('address');
            $table->string('country');
            $table->string('city');
            $table->string('province');
            $table->enum('gender' , ['female' , 'male']);
            $table->timestamps();


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
