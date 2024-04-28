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
            $table->string('name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->double('cc')->unique();
            $table->string('gender');
            $table->double('phone');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('city_id');
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     * php artisan make:migration create_departments_table --create=departments
     * php artisan make:migration create_cities_table --create=cities
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
