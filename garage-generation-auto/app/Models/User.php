<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // 👈 1. Import de l'interface
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail // 👈 2. Activation ici !
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

    /**
     * Génère automatiquement un matricule unique uniquement pour le personnel (hors clients).
     */
    public static function genererMatricule(string $role): ?string
    {
        if ($role === 'client') {
            return null;
        }

        $prefix = match ($role) {
            'administrateur'      => 'ADM',
            'directeur_technique' => 'DIR',
            'chef_departement'    => 'CHF',
            'receptionniste'      => 'REC',
            default               => 'EMP',
        };

        $annee = date('Y');
        $count = self::where('matricule', 'like', "{$prefix}-{$annee}-%")->count() + 1;

        return sprintf('%s-%s-%04d', $prefix, $annee, $count);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class)->latest('date_envoi');
    }

    public function notificationsNonLues()
    {
        return $this->hasMany(Notification::class)->where('lu', false)->latest('date_envoi');
    }
}