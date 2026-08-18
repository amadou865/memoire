<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'essai_id',
        'message',
        'type_notif',
        'date_envoi',
        'lu',
    ];

    protected $casts = [
        'date_envoi' => 'datetime',
        'lu' => 'boolean',
    ];

    public function essai()
    {
        return $this->belongsTo(Essai::class);
    }
}