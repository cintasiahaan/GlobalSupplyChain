<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weathers', function (Blueprint $table) {

            $table->id();

            $table->string('country');

            $table->string('city')->nullable();

            $table->decimal('temperature', 5, 2)->nullable();

            $table->unsignedTinyInteger('humidity')->nullable();

            $table->decimal('wind_speed', 6, 2)->nullable();

            $table->decimal('precipitation', 6, 2)->nullable();

            $table->string('condition')->nullable();

            $table->timestamp('recorded_at')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weathers');
    }
};