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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',255);
            $table->bigInteger('price')->unsigned();
            $table->bigInteger('inventory')->unsigned();
            $table->text('description')->collation('utf8mb4_general_ci');
            $table->timestamp('created_at')->useCurrent();
            $table->softDeletes();
            $table->enum('status',['enable', 'disable'])->default('enable');
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
