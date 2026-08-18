<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'immatriculation',
        'marque',
        'modele',
        'annee',
        'kilometrage',
    ];

    protected $casts = [
        'annee' => 'integer',
        'kilometrage' => 'integer',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }
}