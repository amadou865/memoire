<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    public function index()
    {
        $vehicules = auth()->user()->vehicules()->latest()->get();
        return view('client.vehicules.index', compact('vehicules'));
    }

    public function create()
    {
        return view('client.vehicules.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'immatriculation' => 'required|string|max:20|unique:vehicules,immatriculation',
            'marque' => 'required|string|max:50',
            'modele' => 'required|string|max:50',
            'annee' => 'required|integer|min:1980|max:' . date('Y'),
            'kilometrage' => 'required|integer|min:0',
        ]);

        $data['client_id'] = auth()->id();
        Vehicule::create($data);

        return redirect()->route('client.vehicules.index')
            ->with('success', 'Véhicule ajouté avec succès !');
    }

    public function edit(Vehicule $vehicule)
    {
        $this->authorize('update', $vehicule);
        return view('client.vehicules.edit', compact('vehicule'));
    }

    public function update(Request $request, Vehicule $vehicule)
    {
        abort_if($vehicule->client_id !== auth()->id(), 403);

        $data = $request->validate([
            'immatriculation' => 'required|string|max:20|unique:vehicules,immatriculation,' . $vehicule->id,
            'marque' => 'required|string|max:50',
            'modele' => 'required|string|max:50',
            'annee' => 'required|integer|min:1980|max:' . date('Y'),
            'kilometrage' => 'required|integer|min:0',
        ]);

        $vehicule->update($data);

        return redirect()->route('client.vehicules.index')
            ->with('success', 'Véhicule modifié avec succès !');
    }

    public function destroy(Vehicule $vehicule)
    {
        abort_if($vehicule->client_id !== auth()->id(), 403);
        $vehicule->delete();

        return redirect()->route('client.vehicules.index')
            ->with('success', 'Véhicule supprimé.');
    }
}