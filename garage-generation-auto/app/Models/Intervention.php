<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicule_id',
        'rendez_vous_id',
        'date_creation',
        'date_debut',
        'date_fin',
        'statut',
        'nature',
        'priorite',
        'departement',
    ];

    protected $casts = [
        'date_creation' => 'datetime',
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function rendezVous()
    {
        return $this->belongsTo(RendezVous::class);
    }

    public function diagnostics()
    {
        return $this->hasMany(Diagnostic::class);
    }

    public function essai()
    {
        return $this->hasOne(Essai::class);
    }

    public function lignesPieces()
    {
        return $this->hasMany(LignePiece::class);
    }

    public function devis()
    {
        return $this->hasOne(Devis::class);
    }
}