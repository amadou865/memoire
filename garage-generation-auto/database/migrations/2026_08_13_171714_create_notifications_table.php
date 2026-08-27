<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('notifications');

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // L'utilisateur qui reçoit la notification
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('titre');
            $table->text('message');
            $table->string('type_notif'); // ex: devis, rdv, facture
            $table->string('lien')->nullable(); // Lien où la personne est redirigée en cliquant

            // Optionnel : lié à un essai s'il s'agit d'un contrôle qualité
            $table->foreignId('essai_id')->nullable()->constrained('essais')->nullOnDelete();

            $table->dateTime('date_envoi');
            $table->boolean('lu')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};