<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();

            // Véhicule concerné par l'intervention
            $table->foreignId('vehicule_id')->constrained('vehicules')->cascadeOnDelete();

            // Rendez-vous à l'origine de l'intervention
            // Un rendez-vous peut éventuellement ne pas avoir
            // encore d'intervention.
            $table->foreignId('rendez_vous_id')->nullable()->unique()->constrained('rendez_vouses')->nullOnDelete();
            
            $table->dateTime('date_creation');
            $table->dateTime('date_debut')->nullable();
            $table->dateTime('date_fin')->nullable();

            $table->enum('statut', [
                'planifiee',
                'en_cours',
                'terminee',
                'annulee',
            ])->default('planifiee');

            $table->string('nature');

            $table->enum('priorite', [
                'faible',
                'normale',
                'haute',
                'urgente',
            ])->default('normale');

            $table->string('departement');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};