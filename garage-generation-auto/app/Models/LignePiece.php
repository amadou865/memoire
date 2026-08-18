<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class LignePiece extends Model
{
    use HasFactory;

    protected $fillable = [
        'intervention_id',
        'piece_id',
        'quantite_utilisee',
        'prix_unitaire_applique',
        'date_utilisation',
        'observations',
    ];

    protected $casts = [
        'quantite_utilisee' => 'integer',
        'prix_unitaire_applique' => 'decimal:2',
        'date_utilisation' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (LignePiece $ligne) {
            DB::transaction(function () use ($ligne) {

                $piece = PieceDetachee::whereKey($ligne->piece_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($ligne->quantite_utilisee <= 0) {
                    throw new InvalidArgumentException(
                        'La quantité utilisée doit être supérieure à zéro.'
                    );
                }

                if ($piece->quantite_stock < $ligne->quantite_utilisee) {
                    throw new InvalidArgumentException(
                        'Stock insuffisant pour la pièce : ' . $piece->designation
                    );
                }

                // Si aucun prix n'est fourni, utiliser le prix actuel de la pièce.
                if ($ligne->prix_unitaire_applique === null) {
                    $ligne->prix_unitaire_applique = $piece->prix_unitaire;
                }

                // Diminution du stock
                $piece->decrement(
                    'quantite_stock',
                    $ligne->quantite_utilisee
                );
            });
        });
    }

    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }

    public function piece()
    {
        return $this->belongsTo(PieceDetachee::class, 'piece_id');
    }
}