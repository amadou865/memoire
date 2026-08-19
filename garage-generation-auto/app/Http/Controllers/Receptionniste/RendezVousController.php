<?php

namespace App\Http\Controllers\Receptionniste;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use App\Models\User;
use App\Models\Intervention;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RendezVousController extends Controller
{
    public function index(Request $request)
    {
        $statut = $request->get('statut');
        $date = $request->get('date');

        $rendezVous = RendezVous::with('client', 'intervention')
            ->when($statut, fn($q) => $q->where('statut', $statut))
            ->when($date, fn($q) => $q->whereDate('date', $date))
            ->orderBy('date', 'desc')
            ->orderBy('heure', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Stats
        $stats = [
            'total' => RendezVous::count(),
            'en_attente' => RendezVous::where('statut', 'en_attente')->count(),
            'confirme' => RendezVous::where('statut', 'confirme')->count(),
            'aujourdhui' => RendezVous::whereDate('date', today())->count(),
        ];

        return view('receptionniste.rendez-vous.index', compact('rendezVous', 'statut', 'date', 'stats'));
    }

    public function create()
    {
        $clients = User::where('role', 'client')->orderBy('nom')->get();
        return view('receptionniste.rendez-vous.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today',
            'heure' => 'required',
            'type_intervention' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'statut' => 'required|in:en_attente,confirme',
        ]);

        $data['receptionniste_id'] = auth()->id();

        RendezVous::create($data);

        return redirect()->route('receptionniste.rendez-vous.index')
            ->with('success', 'Rendez-vous créé avec succès !');
    }

    public function show(RendezVous $rendezVou)
    {
        $rendezVou->load('client.vehicules', 'intervention');
        return view('receptionniste.rendez-vous.show', compact('rendezVou'));
    }

    /**
     * Valider un RDV (statut → confirme)
     */
    public function valider(RendezVous $rendezVou)
    {
        $rendezVou->update([
            'statut' => 'confirme',
            'receptionniste_id' => auth()->id(),
        ]);

        return back()->with('success', 'Rendez-vous confirmé !');
    }

    /**
     * Refuser un RDV (statut → annule)
     */
    public function refuser(RendezVous $rendezVou)
    {
        $rendezVou->update([
            'statut' => 'annule',
            'receptionniste_id' => auth()->id(),
        ]);

        return back()->with('success', 'Rendez-vous refusé.');
    }

    public function destroy(RendezVous $rendezVou)
    {
        $rendezVou->delete();
        return redirect()->route('receptionniste.rendez-vous.index')
            ->with('success', 'Rendez-vous supprimé.');
    }
}