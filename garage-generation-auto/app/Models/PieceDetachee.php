<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PieceDetachee extends Model
{
    use HasFactory;

    protected $table = 'pieces_detachees';

    protected $fillable = [
        'reference',
        'designation',
        'quantite_stock',
        'seuil_alerte',
        'prix_unitaire',
    ];

    protected $casts = [
        'quantite_stock' => 'integer',
        'seuil_alerte' => 'integer',
        'prix_unitaire' => 'decimal:2',
    ];

    public function lignesPieces()
    {
        return $this->hasMany(LignePiece::class, 'piece_id');
    }

    /**
     * Vérifie si le stock est inférieur ou égal au seuil d'alerte.
     */
    public function stockFaible(): bool
    {
        return $this->quantite_stock <= $this->seuil_alerte;
    }
}