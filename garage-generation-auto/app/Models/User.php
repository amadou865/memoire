<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'password',
        'role',
        'matricule',
        'departement',
        'grade',
        'niveau_acces',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function vehicules()
    {
        return $this->hasMany(Vehicule::class, 'client_id');
    }

    public function rendezVousClient()
    {
        return $this->hasMany(RendezVous::class, 'client_id');
    }

    public function rendezVousReceptionniste()
    {
        return $this->hasMany(RendezVous::class, 'receptionniste_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Rôles
    |--------------------------------------------------------------------------
    */

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isReceptionniste(): bool
    {
        return $this->role === 'receptionniste';
    }

    public function isChefDepartement(): bool
    {
        return $this->role === 'chef_departement';
    }

    public function isDirecteurTechnique(): bool
    {
        return $this->role === 'directeur_technique';
    }

    public function isAdministrateur(): bool
    {
        return $this->role === 'administrateur';
    }
}