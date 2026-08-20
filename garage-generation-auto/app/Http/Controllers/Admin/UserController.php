<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->get('role');
        $search = $request->get('search');

        $users = User::query()
            ->when($role, fn($q) => $q->where('role', $role))
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('nom', 'like', "%{$search}%")
                        ->orWhere('prenom', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('matricule', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.utilisateurs.index', compact('users', 'role', 'search'));
    }

        public function create()
    {
        $departements = ['Mécanique', 'Électricité', 'Tôlerie', 'Peinture', 'Climatisation'];

        // Pré-calcul des prochains matricules réels pour chaque rôle
        $nextMatricules = [
            'administrateur'      => User::genererMatricule('administrateur'),
            'directeur_technique' => User::genererMatricule('directeur_technique'),
            'chef_departement'    => User::genererMatricule('chef_departement'),
            'receptionniste'      => User::genererMatricule('receptionniste'),
            'client'              => null,
        ];

        return view('admin.utilisateurs.create', compact('departements', 'nextMatricules'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'prenom' => 'required|string|max:50',
            'nom' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'role' => 'required|in:client,receptionniste,chef_departement,directeur_technique,administrateur',
            'departement' => 'nullable|string|max:50',
            'grade' => 'nullable|string|max:50',
        ]);

        // Génération automatique du matricule (null pour les clients)
        $data['matricule'] = User::genererMatricule($data['role']);
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        $msg = $data['matricule'] 
            ? "Employé créé avec succès ! Matricule attribué : {$data['matricule']}"
            : "Client créé avec succès !";

        return redirect()->route('admin.utilisateurs.index')->with('success', $msg);
    }

    public function edit(User $utilisateur)
    {
        $departements = ['Mécanique', 'Électricité', 'Tôlerie', 'Peinture', 'Climatisation'];
        return view('admin.utilisateurs.edit', compact('utilisateur', 'departements'));
    }

    public function update(Request $request, User $utilisateur)
    {
        $data = $request->validate([
            'prenom' => 'required|string|max:50',
            'nom' => 'required|string|max:50',
            'email' => ['required', 'email', Rule::unique('users')->ignore($utilisateur->id)],
            'telephone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:client,receptionniste,chef_departement,directeur_technique,administrateur',
            'departement' => 'nullable|string|max:50',
            'grade' => 'nullable|string|max:50',
        ]);

        // Si on transforme un client en employé, on lui génère un matricule
        if ($data['role'] !== 'client' && empty($utilisateur->matricule)) {
            $data['matricule'] = User::genererMatricule($data['role']);
        } elseif ($data['role'] === 'client') {
            // Si on passe en client, le matricule devient null
            $data['matricule'] = null;
            $data['departement'] = null;
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $utilisateur->update($data);

        return redirect()->route('admin.utilisateurs.index')
            ->with('success', 'Utilisateur mis à jour !');
    }

    public function destroy(User $utilisateur)
    {
        if ($utilisateur->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $utilisateur->delete();

        return redirect()->route('admin.utilisateurs.index')
            ->with('success', 'Utilisateur supprimé.');
    }
}