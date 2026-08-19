<?php

namespace App\Http\Controllers\Chef;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use App\Models\LignePiece;
use App\Models\PieceDetachee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PieceController extends Controller
{
    /**
     * Liste du stock (consultation seule)
     */
    public function stock(Request $request)
    {
        $search = $request->get('search');
        $stockFaible = $request->boolean('stock_faible');

        $pieces = PieceDetachee::query()
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('reference', 'like', "%{$search}%")
                        ->orWhere('designation', 'like', "%{$search}%");
                });
            })
            ->when($stockFaible, fn($q) => $q->whereColumn('quantite_stock', '<=', 'seuil_alerte'))
            ->orderBy('designation')
            ->paginate(20)
            ->withQueryString();

        return view('chef.pieces.stock', compact('pieces', 'search', 'stockFaible'));
    }

    /**
     * Ajouter une pièce consommée sur une intervention
     */
    public function ajouterPiece(Intervention $intervention)
    {
        abort_if($intervention->departement !== auth()->user()->departement, 403);

        $pieces = PieceDetachee::where('quantite_stock', '>', 0)
            ->orderBy('designation')
            ->get();

        return view('chef.pieces.ajouter', compact('intervention', 'pieces'));
    }

    public function storePiece(Request $request, Intervention $intervention)
    {
        abort_if($intervention->departement !== auth()->user()->departement, 403);

        $data = $request->validate([
            'piece_id' => 'required|exists:pieces_detachees,id',
            'quantite_utilisee' => 'required|integer|min:1',
            'observations' => 'nullable|string|max:500',
        ]);

        try {
            DB::transaction(function () use ($data, $intervention) {
                LignePiece::create([
                    'intervention_id' => $intervention->id,
                    'piece_id' => $data['piece_id'],
                    'quantite_utilisee' => $data['quantite_utilisee'],
                    'date_utilisation' => now(),
                    'observations' => $data['observations'] ?? null,
                ]);
            });

            return redirect()->route('chef.interventions.show', $intervention)
                ->with('success', 'Pièce ajoutée et stock mis à jour !');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function supprimerPiece(LignePiece $lignePiece)
    {
        abort_if($lignePiece->intervention->departement !== auth()->user()->departement, 403);

        DB::transaction(function () use ($lignePiece) {
            // Remettre le stock
            $lignePiece->piece->increment('quantite_stock', $lignePiece->quantite_utilisee);
            $lignePiece->delete();
        });

        return back()->with('success', 'Pièce retirée et stock restauré.');
    }
}