<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ligne_pieces', function (Blueprint $table) {
            $table->id();

            $table->foreignId('intervention_id')->constrained('interventions')->cascadeOnDelete();

            $table->foreignId('piece_id')->constrained('pieces_detachees')->restrictOnDelete();

            $table->unsignedInteger('quantite_utilisee');

            $table->decimal('prix_unitaire_applique', 10, 2);

            $table->dateTime('date_utilisation');

            $table->text('observations')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ligne_pieces');
    }
};