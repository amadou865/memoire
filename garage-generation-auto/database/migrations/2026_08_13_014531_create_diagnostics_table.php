<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnostics', function (Blueprint $table) {
            $table->id();

            // Intervention concernée
            $table->foreignId('intervention_id')->constrained('interventions')->cascadeOnDelete();

            // Type de diagnostic
            $table->enum('type', [
                'visuel',
                'valise_electronique',
            ]);

            $table->text('description')->nullable();

            // Codes défauts pour le diagnostic électronique
            $table->text('codes_defauts')->nullable();

            $table->text('observations')->nullable();

            // Coût du diagnostic à la valise
            $table->integer('cout_valise')->nullable();

            $table->dateTime('date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnostics');
    }
};