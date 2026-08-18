<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'devis_id',
        'numero',
        'date_emission',
        'montant_total',
        'statut',
        'mode_payement',
    ];

    protected $casts = [
        'date_emission' => 'date',
        'montant_total' => 'decimal:2',
    ];

    public function devis()
    {
        return $this->belongsTo(Devis::class);
    }
}