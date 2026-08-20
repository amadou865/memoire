<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();

            $table->foreignId('devis_id')
                ->constrained('devis')
                ->cascadeOnDelete();

            $table->string('numero')->unique();
            $table->date('date_emission');
            $table->decimal('montant_total', 10, 2)->default(0);

            // ✅ ENUM avec les bonnes valeurs ('en_attente', 'paye', 'annule')
            $table->enum('statut', [
                'en_attente',
                'paye',
                'annule',
            ])->default('en_attente');

            // ✅ string pour autoriser tous les modes avec caractères spéciaux (espèces, chèque, etc.)
            $table->string('mode_payement')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};