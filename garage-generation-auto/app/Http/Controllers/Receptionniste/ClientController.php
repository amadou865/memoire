<?php

namespace App\Http\Controllers\Receptionniste;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $clients = User::where('role', 'client')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('nom', 'like', "%{$search}%")
                        ->orWhere('prenom', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('telephone', 'like', "%{$search}%");
                });
            })
            ->withCount('vehicules')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('receptionniste.clients.index', compact('clients', 'search'));
    }

    public function create()
    {
        return view('receptionniste.clients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $data['role'] = 'client';
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('receptionniste.clients.index')
            ->with('success', 'Client créé avec succès !');
    }

    public function show(User $client)
    {
        abort_unless($client->isClient(), 404);

        $client->load(['vehicules', 'rendezVousClient' => function ($q) {
            $q->latest()->take(5);
        }]);

        // Interventions du client
        $vehiculeIds = $client->vehicules->pluck('id');
        $interventions = \App\Models\Intervention::whereIn('vehicule_id', $vehiculeIds)
            ->with('vehicule')
            ->latest()
            ->take(10)
            ->get();

        return view('receptionniste.clients.show', compact('client', 'interventions'));
    }

    public function edit(User $client)
    {
        abort_unless($client->isClient(), 404);
        return view('receptionniste.clients.edit', compact('client'));
    }

    public function update(Request $request, User $client)
    {
        abort_unless($client->isClient(), 404);

        $data = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $client->id,
            'telephone' => 'required|string|max:20',
        ]);

        $client->update($data);

        return redirect()->route('receptionniste.clients.show', $client)
            ->with('success', 'Informations mises à jour !');
    }

    public function destroy(User $client)
    {
        abort_unless($client->isClient(), 404);
        $client->delete();

        return redirect()->route('receptionniste.clients.index')
            ->with('success', 'Client supprimé.');
    }
}