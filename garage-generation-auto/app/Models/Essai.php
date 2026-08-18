<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Essai extends Model
{
    use HasFactory;

    protected $fillable = [
        'intervention_id',
        'date',
        'resultat',
        'observations',
        'motif_non_conformite',
        'heure_validation',
    ];

    protected $casts = [
        'date' => 'datetime',
        'heure_validation' => 'datetime',
    ];

    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }

    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class, 'essai_id');
    }
}