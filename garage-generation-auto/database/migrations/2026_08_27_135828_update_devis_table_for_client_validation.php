<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modification de la colonne statut pour inclure 'envoye' et 'refuse'
        DB::statement("ALTER TABLE devis MODIFY COLUMN statut ENUM('brouillon', 'envoye', 'valide', 'refuse', 'facture', 'annule') DEFAULT 'brouillon'");

        Schema::table('devis', function (Blueprint $table) {
            $table->text('motif_refus')->nullable()->after('statut');
            $table->timestamp('date_validation')->nullable()->after('motif_refus');
        });
    }

    public function down(): void
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->dropColumn(['motif_refus', 'date_validation']);
        });
    }
};