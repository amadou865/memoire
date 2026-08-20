<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PieceDetachee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $stockFaible = $request->boolean('stock_faible');

        $pieces = PieceDetachee::query()
            ->when($search, function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%");
            })
            ->when($stockFaible, fn($q) => $q->whereColumn('quantite_stock', '<=', 'seuil_alerte'))
            ->orderBy('designation')
            ->paginate(15)
            ->withQueryString();

        return view('admin.stock.index', compact('pieces', 'search', 'stockFaible'));
    }

    public function create()
    {
        return view('admin.stock.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reference' => 'required|string|max:50|unique:pieces_detachees,reference',
            'designation' => 'required|string|max:100',
            'quantite_stock' => 'required|integer|min:0',
            'seuil_alerte' => 'required|integer|min:0',
            'prix_unitaire' => 'required|numeric|min:0',
        ]);

        PieceDetachee::create($data);

        return redirect()->route('admin.stock.index')
            ->with('success', 'Pièce ajoutée au catalogue !');
    }

    public function edit(PieceDetachee $stock)
    {
        return view('admin.stock.edit', ['piece' => $stock]);
    }

    public function update(Request $request, PieceDetachee $stock)
    {
        $data = $request->validate([
            'reference' => ['required', 'string', 'max:50', Rule::unique('pieces_detachees')->ignore($stock->id)],
            'designation' => 'required|string|max:100',
            'quantite_stock' => 'required|integer|min:0',
            'seuil_alerte' => 'required|integer|min:0',
            'prix_unitaire' => 'required|numeric|min:0',
        ]);

        $stock->update($data);

        return redirect()->route('admin.stock.index')
            ->with('success', 'Pièce mise à jour !');
    }

    public function destroy(PieceDetachee $stock)
    {
        $stock->delete();

        return redirect()->route('admin.stock.index')
            ->with('success', 'Pièce supprimée.');
    }
}