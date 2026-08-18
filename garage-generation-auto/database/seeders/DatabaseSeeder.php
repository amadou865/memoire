<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicule;
use App\Models\RendezVous;
use App\Models\Intervention;
use App\Models\PieceDetachee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ═══════════════════════════════════════════
        // 1. ADMINISTRATEUR
        // ═══════════════════════════════════════════
        User::create([
            'nom' => 'DIOP',
            'prenom' => 'Amadou',
            'email' => 'admin@garage.sn',
            'telephone' => '+221 77 111 22 33',
            'password' => Hash::make('password'),
            'role' => 'administrateur',
            'matricule' => 'ADM-001',
            'niveau_acces' => 'super_admin',
        ]);

        // ═══════════════════════════════════════════
        // 2. DIRECTEUR TECHNIQUE
        // ═══════════════════════════════════════════
        User::create([
            'nom' => 'NDIAYE',
            'prenom' => 'Moussa',
            'email' => 'directeur@garage.sn',
            'telephone' => '+221 77 222 33 44',
            'password' => Hash::make('password'),
            'role' => 'directeur_technique',
            'matricule' => 'DIR-001',
            'grade' => 'Ingénieur Senior',
        ]);

        // ═══════════════════════════════════════════
        // 3. RÉCEPTIONNISTES
        // ═══════════════════════════════════════════
        $receptionniste1 = User::create([
            'nom' => 'FALL',
            'prenom' => 'Awa',
            'email' => 'receptionniste@garage.sn',
            'telephone' => '+221 77 333 44 55',
            'password' => Hash::make('password'),
            'role' => 'receptionniste',
            'matricule' => 'REC-001',
        ]);

        User::create([
            'nom' => 'SARR',
            'prenom' => 'Fatou',
            'email' => 'receptionniste2@garage.sn',
            'telephone' => '+221 77 333 44 56',
            'password' => Hash::make('password'),
            'role' => 'receptionniste',
            'matricule' => 'REC-002',
        ]);

        // ═══════════════════════════════════════════
        // 4. CHEFS DE DÉPARTEMENT
        // ═══════════════════════════════════════════
        $departements = [
            ['nom' => 'BA', 'prenom' => 'Ibrahima', 'dept' => 'Mécanique', 'mat' => 'CHF-001'],
            ['nom' => 'SOW', 'prenom' => 'Ousmane', 'dept' => 'Électricité', 'mat' => 'CHF-002'],
            ['nom' => 'DIALLO', 'prenom' => 'Mamadou', 'dept' => 'Tôlerie', 'mat' => 'CHF-003'],
            ['nom' => 'GUEYE', 'prenom' => 'Cheikh', 'dept' => 'Peinture', 'mat' => 'CHF-004'],
            ['nom' => 'THIAM', 'prenom' => 'Aliou', 'dept' => 'Climatisation', 'mat' => 'CHF-005'],
        ];

        foreach ($departements as $index => $chef) {
            User::create([
                'nom' => $chef['nom'],
                'prenom' => $chef['prenom'],
                'email' => 'chef.' . strtolower($chef['dept']) . '@garage.sn',
                'telephone' => '+221 77 444 55 ' . str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                'password' => Hash::make('password'),
                'role' => 'chef_departement',
                'matricule' => $chef['mat'],
                'departement' => $chef['dept'],
            ]);
        }

        // ═══════════════════════════════════════════
        // 5. CLIENTS + VÉHICULES
        // ═══════════════════════════════════════════
        $clients = [
            [
                'nom' => 'CISSE', 'prenom' => 'Abdoulaye', 'email' => 'client@garage.sn',
                'tel' => '+221 77 555 11 11',
                'vehicules' => [
                    ['marque' => 'Toyota', 'modele' => 'Corolla', 'imm' => 'DK-1234-AB', 'annee' => 2018, 'km' => 85000],
                    ['marque' => 'Hyundai', 'modele' => 'Tucson', 'imm' => 'DK-5678-CD', 'annee' => 2021, 'km' => 45000],
                ],
            ],
            [
                'nom' => 'MBAYE', 'prenom' => 'Aïssatou', 'email' => 'aissatou@gmail.com',
                'tel' => '+221 77 555 22 22',
                'vehicules' => [
                    ['marque' => 'Kia', 'modele' => 'Picanto', 'imm' => 'DK-9012-EF', 'annee' => 2020, 'km' => 55000],
                ],
            ],
            [
                'nom' => 'SECK', 'prenom' => 'Modou', 'email' => 'modou@gmail.com',
                'tel' => '+221 77 555 33 33',
                'vehicules' => [
                    ['marque' => 'Renault', 'modele' => 'Duster', 'imm' => 'DK-3456-GH', 'annee' => 2019, 'km' => 72000],
                ],
            ],
            [
                'nom' => 'NDOYE', 'prenom' => 'Mariama', 'email' => 'mariama@gmail.com',
                'tel' => '+221 77 555 44 44',
                'vehicules' => [
                    ['marque' => 'Peugeot', 'modele' => '208', 'imm' => 'DK-7890-IJ', 'annee' => 2022, 'km' => 25000],
                ],
            ],
            [
                'nom' => 'KANE', 'prenom' => 'Ousseynou', 'email' => 'ousseynou@gmail.com',
                'tel' => '+221 77 555 55 55',
                'vehicules' => [
                    ['marque' => 'Ford', 'modele' => 'Ranger', 'imm' => 'DK-1122-KL', 'annee' => 2017, 'km' => 120000],
                ],
            ],
        ];

        $createdClients = [];
        $createdVehicules = [];

        foreach ($clients as $c) {
            $client = User::create([
                'nom' => $c['nom'],
                'prenom' => $c['prenom'],
                'email' => $c['email'],
                'telephone' => $c['tel'],
                'password' => Hash::make('password'),
                'role' => 'client',
            ]);
            $createdClients[] = $client;

            foreach ($c['vehicules'] as $v) {
                $vehicule = Vehicule::create([
                    'client_id' => $client->id,
                    'immatriculation' => $v['imm'],
                    'marque' => $v['marque'],
                    'modele' => $v['modele'],
                    'annee' => $v['annee'],
                    'kilometrage' => $v['km'],
                ]);
                $createdVehicules[] = $vehicule;
            }
        }

        // ═══════════════════════════════════════════
        // 6. PIÈCES DÉTACHÉES
        // ═══════════════════════════════════════════
        $pieces = [
            ['ref' => 'FRE-001', 'des' => 'Plaquettes de frein avant', 'stock' => 25, 'seuil' => 5, 'prix' => 15000],
            ['ref' => 'FRE-002', 'des' => 'Plaquettes de frein arrière', 'stock' => 20, 'seuil' => 5, 'prix' => 12000],
            ['ref' => 'FIL-001', 'des' => 'Filtre à huile', 'stock' => 50, 'seuil' => 10, 'prix' => 3500],
            ['ref' => 'FIL-002', 'des' => 'Filtre à air', 'stock' => 40, 'seuil' => 10, 'prix' => 5000],
            ['ref' => 'FIL-003', 'des' => 'Filtre à carburant', 'stock' => 30, 'seuil' => 8, 'prix' => 7500],
            ['ref' => 'HUI-001', 'des' => 'Huile moteur 5W30 (5L)', 'stock' => 60, 'seuil' => 15, 'prix' => 25000],
            ['ref' => 'BAT-001', 'des' => 'Batterie 60Ah', 'stock' => 8, 'seuil' => 3, 'prix' => 45000],
            ['ref' => 'AMP-001', 'des' => 'Ampoule H4', 'stock' => 100, 'seuil' => 20, 'prix' => 2500],
            ['ref' => 'PNE-001', 'des' => 'Pneu 195/65 R15', 'stock' => 12, 'seuil' => 4, 'prix' => 55000],
            ['ref' => 'CLI-001', 'des' => 'Gaz réfrigérant R134a', 'stock' => 15, 'seuil' => 5, 'prix' => 18000],
            ['ref' => 'BOU-001', 'des' => 'Bougie d\'allumage', 'stock' => 4, 'seuil' => 10, 'prix' => 3000], // Stock faible
            ['ref' => 'COU-001', 'des' => 'Courroie de distribution', 'stock' => 2, 'seuil' => 3, 'prix' => 35000], // Stock faible
        ];

        foreach ($pieces as $p) {
            PieceDetachee::create([
                'reference' => $p['ref'],
                'designation' => $p['des'],
                'quantite_stock' => $p['stock'],
                'seuil_alerte' => $p['seuil'],
                'prix_unitaire' => $p['prix'],
            ]);
        }

        // ═══════════════════════════════════════════
        // 7. RENDEZ-VOUS
        // ═══════════════════════════════════════════
        $typesRdv = ['Vidange', 'Révision', 'Diagnostic', 'Réparation freinage', 'Climatisation'];
        $statutsRdv = ['en_attente', 'confirme', 'annule'];

        foreach ($createdClients as $index => $client) {
            // Chaque client a 1 à 2 RDV
            $nbRdv = rand(1, 2);
            for ($i = 0; $i < $nbRdv; $i++) {
                RendezVous::create([
                    'client_id' => $client->id,
                    'receptionniste_id' => $receptionniste1->id,
                    'date' => Carbon::now()->addDays(rand(1, 15)),
                    'heure' => sprintf('%02d:00:00', rand(8, 17)),
                    'type_intervention' => $typesRdv[array_rand($typesRdv)],
                    'description' => 'Rendez-vous pour ' . strtolower($typesRdv[array_rand($typesRdv)]),
                    'statut' => $statutsRdv[array_rand($statutsRdv)],
                ]);
            }
        }

        // ═══════════════════════════════════════════
        // 8. INTERVENTIONS (quelques exemples)
        // ═══════════════════════════════════════════
        $natures = ['Vidange complète', 'Changement plaquettes', 'Diagnostic électronique', 'Recharge clim', 'Réparation carrosserie'];
        $depts = ['Mécanique', 'Électricité', 'Tôlerie', 'Peinture', 'Climatisation'];
        $prios = ['faible', 'normale', 'haute', 'urgente'];
        $statuts = ['planifiee', 'en_cours', 'terminee'];

        foreach (array_slice($createdVehicules, 0, 4) as $vehicule) {
            Intervention::create([
                'vehicule_id' => $vehicule->id,
                'rendez_vous_id' => null,
                'date_creation' => Carbon::now()->subDays(rand(1, 10)),
                'date_debut' => Carbon::now()->subDays(rand(1, 5)),
                'date_fin' => null,
                'statut' => $statuts[array_rand($statuts)],
                'nature' => $natures[array_rand($natures)],
                'priorite' => $prios[array_rand($prios)],
                'departement' => $depts[array_rand($depts)],
            ]);
        }

        $this->command->info('✅ Seeding terminé avec succès !');
        $this->command->info('');
        $this->command->info('╔════════════════════════════════════════════╗');
        $this->command->info('║  COMPTES DE TEST (mot de passe : password) ║');
        $this->command->info('╠════════════════════════════════════════════╣');
        $this->command->info('║  Admin       : admin@garage.sn             ║');
        $this->command->info('║  Directeur   : directeur@garage.sn         ║');
        $this->command->info('║  Réception   : receptionniste@garage.sn    ║');
        $this->command->info('║  Chef Méca   : chef.mécanique@garage.sn    ║');
        $this->command->info('║  Client      : client@garage.sn            ║');
        $this->command->info('╚════════════════════════════════════════════╝');
    }
}