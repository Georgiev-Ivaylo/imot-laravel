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
        Schema::create('estates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->unsignedBigInteger('price');
            $table->string('currency_code');
            $table->string('type');
            $table->string('construction_type')->nullable();
            $table->timestamp('construction_date')->nullable();
            $table->unsignedTinyInteger('rooms')->nullable();
            $table->unsignedTinyInteger('bathrooms')->nullable();
            $table->unsignedTinyInteger('floors')->nullable();
            $table->unsignedTinyInteger('floor_number')->nullable();
            $table->unsignedSmallInteger('land_size')->nullable();
            $table->unsignedSmallInteger('building_size')->nullable();
            $table->string('region');
            $table->string('city')->nullable();
            $table->string('village')->nullable();
            $table->string('district')->nullable();
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estates');
    }
};
