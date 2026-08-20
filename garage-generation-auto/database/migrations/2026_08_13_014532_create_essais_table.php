<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('essais', function (Blueprint $table) {
            $table->id();

            // Une intervention peut avoir au maximum un essai
            $table->foreignId('intervention_id')->unique()->constrained('interventions')->cascadeOnDelete();

            $table->dateTime('date');

            $table->enum('resultat', [
                'conforme',
                'non_conforme',
            ])->default('conforme');

            $table->text('observations')->nullable();

            // Obligatoire seulement en cas de non-conformité
            $table->text('motif_non_conformite')->nullable();

            // Date/heure de validation du contrôle
            $table->timestamp('heure_validation')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('essais');
    }
};