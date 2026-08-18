<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('intervention_id')
                ->unique()
                ->constrained('interventions')
                ->cascadeOnDelete();

            $table->string('numero')->unique();

            $table->date('date_creation');

            $table->decimal('montant_mo', 10, 2)->default(0);
            $table->decimal('montant_pieces', 10, 2)->default(0);
            $table->decimal('montant_valise', 10, 2)->default(0);

            $table->enum('statut', [
                'en attente',
                'validé',
                'refuse',
            ])->default('en attente');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
};