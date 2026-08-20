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

            $table->foreignId('intervention_id')
                ->constrained('interventions')
                ->cascadeOnDelete();

            $table->enum('type', ['visuel', 'valise'])->default('visuel');

            $table->text('description');
            $table->string('codes_defauts')->nullable();
            $table->text('observations')->nullable();
            $table->decimal('cout_valise', 10, 2)->default(0);
            $table->dateTime('date');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnostics');
    }
};