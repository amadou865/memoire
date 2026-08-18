<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;

    protected $table = 'rendez_vouses';

    protected $fillable = [
        'client_id',
        'receptionniste_id',
        'date',
        'heure',
        'type_intervention',
        'description',
        'statut',
    ];

    protected $casts = [
        'date' => 'date',
        'heure' => 'datetime:H:i',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function receptionniste()
    {
        return $this->belongsTo(User::class, 'receptionniste_id');
    }

    public function intervention()
    {
        return $this->hasOne(Intervention::class);
    }
}