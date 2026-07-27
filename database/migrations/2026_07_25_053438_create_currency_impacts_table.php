<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('currency_impacts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnDelete();

            $table->string('currency_code', 10);

            $table->decimal('exchange_rate', 15, 6)
                ->nullable();

            $table->decimal('previous_rate', 15, 6)
                ->nullable();

            $table->decimal('change_percent', 10, 4)
                ->nullable();

            $table->enum('risk_level', [
                'LOW',
                'MEDIUM',
                'HIGH',
                'UNKNOWN',
            ])->default('UNKNOWN');

            $table->text('impact')
                ->nullable();

            $table->text('recommendation')
                ->nullable();

            $table->timestamp('recorded_at')
                ->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currency_impacts');
    }
};