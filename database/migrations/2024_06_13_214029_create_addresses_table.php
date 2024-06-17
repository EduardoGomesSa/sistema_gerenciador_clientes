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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('cep', 9)->nullable(false);
            $table->string('state', 2)->nullable(false);
            $table->string('city', 30)->nullable(false);
            $table->string('neighborhood', 20)->nullable(false);
            $table->string('street', 20)->nullable(false);
            $table->string('number', 5)->nullable(false);
            $table->string('complement', 30)->nullable();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
