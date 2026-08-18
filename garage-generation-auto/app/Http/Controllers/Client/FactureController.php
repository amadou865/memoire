<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Facture;

class FactureController extends Controller
{
    public function index()
    {
        $vehiculeIds = auth()->user()->vehicules()->pluck('id');

        $factures = Facture::whereHas('devis.intervention', function ($q) use ($vehiculeIds) {
            $q->whereIn('vehicule_id', $vehiculeIds);
        })
        ->with('devis.intervention.vehicule')
        ->latest()
        ->paginate(10);

        return view('client.factures.index', compact('factures'));
    }
}