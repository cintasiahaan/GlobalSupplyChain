<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {

            $table->id();

            $table->string('title');

            $table->text('summary')->nullable();

            $table->string('source')->nullable();

            $table->string('category')->nullable();

            $table->string('country')->nullable();

            $table->enum('impact_level', [
                'Low',
                'Medium',
                'High'
            ])->default('Low');

            $table->string('url')->nullable();

            $table->timestamp('published_at')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};