<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ports', function (Blueprint $table) {

            $table->id();

            $table->string('port_name');

            $table->string('country');

            $table->string('city')->nullable();

            $table->enum('status', [
                'Operational',
                'Delayed',
                'Closed',
            ])->default('Operational');

            $table->enum('congestion_level', [
                'Low',
                'Medium',
                'High',
            ])->default('Low');

            $table->decimal('delay_hours', 8, 2)
                ->default(0);

            $table->decimal('throughput', 15, 2)
                ->nullable();

            $table->enum('risk_level', [
                'Low',
                'Medium',
                'High',
            ])->default('Low');

            $table->text('description')
                ->nullable();

            $table->timestamp('recorded_at')
                ->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ports');
    }
};