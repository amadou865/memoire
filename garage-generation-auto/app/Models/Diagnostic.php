<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnostic extends Model
{
    use HasFactory;

    protected $fillable = [
        'intervention_id',
        'type',
        'description',
        'codes_defauts',
        'observations',
        'cout_valise',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime',
        'cout_valise' => 'decimal:2',
    ];

    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }
}