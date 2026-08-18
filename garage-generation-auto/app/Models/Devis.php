<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;

    protected $fillable = [
        'intervention_id',
        'numero',
        'date_creation',
        'montant_mo',
        'montant_pieces',
        'montant_valise',
        'statut',
    ];

    protected $casts = [
        'date_creation' => 'date',
        'montant_mo' => 'decimal:2',
        'montant_pieces' => 'decimal:2',
        'montant_valise' => 'decimal:2',
    ];

    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }

    public function facture()
    {
        return $this->hasOne(Facture::class);
    }

    public function getMontantTotalAttribute()
    {
        return $this->montant_mo
            + $this->montant_pieces
            + $this->montant_valise;
    }
}