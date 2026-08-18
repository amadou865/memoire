<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rendez_vouses', function (Blueprint $table) {
            $table->id();

            // Client qui prend le rendez-vous
            $table->foreignId('client_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Réceptionniste qui traite le rendez-vous
            $table->foreignId('receptionniste_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->date('date');
            $table->time('heure');

            $table->string('type_intervention');
            $table->text('description')->nullable();

            $table->enum('statut', [
                'en_attente',
                'confirme',
                'annule',
            ])->default('en_attente');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rendez_vouses');
    }
};