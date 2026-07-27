<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risk_assessments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('weather_risk')->default(0);
            $table->unsignedTinyInteger('economic_risk')->default(0);
            $table->unsignedTinyInteger('currency_risk')->default(0);
            $table->unsignedTinyInteger('political_risk')->default(0);
            $table->unsignedTinyInteger('port_risk')->default(0);

            $table->decimal('risk_score', 5, 2)->default(0);

            $table->string('risk_level')->default('Low');

            $table->timestamps();

            $table->unique('country_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risk_assessments');
    }
};