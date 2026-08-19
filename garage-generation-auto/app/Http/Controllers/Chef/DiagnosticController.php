<?php

namespace App\Http\Controllers\Chef;

use App\Http\Controllers\Controller;
use App\Models\Intervention;
use App\Models\Diagnostic;
use Illuminate\Http\Request;

class DiagnosticController extends Controller
{
    public function create(Intervention $intervention)
    {
        abort_if($intervention->departement !== auth()->user()->departement, 403);

        return view('chef.diagnostics.create', compact('intervention'));
    }

    public function store(Request $request, Intervention $intervention)
    {
        abort_if($intervention->departement !== auth()->user()->departement, 403);

        $data = $request->validate([
            'type' => 'required|in:visuel,valise',
            'description' => 'required|string|max:1000',
            'codes_defauts' => 'nullable|string|max:500',
            'observations' => 'nullable|string|max:1000',
            'cout_valise' => 'nullable|numeric|min:0',
        ]);

        $data['intervention_id'] = $intervention->id;
        $data['date'] = now();
        $data['cout_valise'] = $data['cout_valise'] ?? 0;

        Diagnostic::create($data);

        return redirect()->route('chef.interventions.show', $intervention)
            ->with('success', 'Diagnostic enregistré avec succès !');
    }

    public function destroy(Diagnostic $diagnostic)
    {
        abort_if($diagnostic->intervention->departement !== auth()->user()->departement, 403);

        $diagnostic->delete();

        return back()->with('success', 'Diagnostic supprimé.');
    }
}