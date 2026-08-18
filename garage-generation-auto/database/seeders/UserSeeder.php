<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ═══════════════════════════════════════════
        // 1. ADMINISTRATEUR
        // ═══════════════════════════════════════════
        User::create([
            'nom' => 'ADMIN',
            'prenom' => 'Super',
            'email' => 'admin@garage.sn',
            'telephone' => '77 000 00 01',
            'password' => Hash::make('password'),
            'role' => 'administrateur',
            'matricule' => 'ADM-001',
            'niveau_acces' => 'total',
            'email_verified_at' => now(),
        ]);

        // ═══════════════════════════════════════════
        // 2. RÉCEPTIONNISTE
        // ═══════════════════════════════════════════
        User::create([
            'nom' => 'DIALLO',
            'prenom' => 'Fatou',
            'email' => 'receptionniste@garage.sn',
            'telephone' => '77 000 00 02',
            'password' => Hash::make('password'),
            'role' => 'receptionniste',
            'matricule' => 'REC-001',
            'email_verified_at' => now(),
        ]);

        // ═══════════════════════════════════════════
        // 3. CHEF DE DÉPARTEMENT (Mécanique)
        // ═══════════════════════════════════════════
        User::create([
            'nom' => 'NDIAYE',
            'prenom' => 'Moussa',
            'email' => 'chef.mecanique@garage.sn',
            'telephone' => '77 000 00 03',
            'password' => Hash::make('password'),
            'role' => 'chef_departement',
            'matricule' => 'CHF-001',
            'departement' => 'Mécanique',
            'email_verified_at' => now(),
        ]);

        // ═══════════════════════════════════════════
        // 4. CHEF DE DÉPARTEMENT (Électricité)
        // ═══════════════════════════════════════════
        User::create([
            'nom' => 'SOW',
            'prenom' => 'Ibrahima',
            'email' => 'chef.electricite@garage.sn',
            'telephone' => '77 000 00 04',
            'password' => Hash::make('password'),
            'role' => 'chef_departement',
            'matricule' => 'CHF-002',
            'departement' => 'Électricité',
            'email_verified_at' => now(),
        ]);

        // ═══════════════════════════════════════════
        // 5. DIRECTEUR TECHNIQUE
        // ═══════════════════════════════════════════
        User::create([
            'nom' => 'FALL',
            'prenom' => 'Cheikh',
            'email' => 'directeur@garage.sn',
            'telephone' => '77 000 00 05',
            'password' => Hash::make('password'),
            'role' => 'directeur_technique',
            'matricule' => 'DIR-001',
            'grade' => 'Directeur Général Technique',
            'email_verified_at' => now(),
        ]);

        // ═══════════════════════════════════════════
        // 6. CLIENT
        // ═══════════════════════════════════════════
        User::create([
            'nom' => 'BA',
            'prenom' => 'Aminata',
            'email' => 'client@garage.sn',
            'telephone' => '77 000 00 06',
            'password' => Hash::make('password'),
            'role' => 'client',
            'email_verified_at' => now(),
        ]);

        // ═══════════════════════════════════════════
        // 7. AUTRE CLIENT
        // ═══════════════════════════════════════════
        User::create([
            'nom' => 'SARR',
            'prenom' => 'Ousmane',
            'email' => 'client2@garage.sn',
            'telephone' => '77 000 00 07',
            'password' => Hash::make('password'),
            'role' => 'client',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ 7 utilisateurs créés avec succès !');
        $this->command->info('');
        $this->command->info('📧 Emails de connexion :');
        $this->command->info('   → admin@garage.sn (Administrateur)');
        $this->command->info('   → receptionniste@garage.sn (Réceptionniste)');
        $this->command->info('   → chef.mecanique@garage.sn (Chef Mécanique)');
        $this->command->info('   → chef.electricite@garage.sn (Chef Électricité)');
        $this->command->info('   → directeur@garage.sn (Directeur Technique)');
        $this->command->info('   → client@garage.sn (Client)');
        $this->command->info('   → client2@garage.sn (Client)');
        $this->command->info('');
        $this->command->info('🔑 Mot de passe pour tous : password');
    }
}