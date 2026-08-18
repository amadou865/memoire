<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RendezVousController extends Controller
{
    public function index()
    {
        $rendezVous = auth()->user()->rendezVousClient()
            ->orderBy('date', 'desc')
            ->get();

        return view('client.rendez-vous.index', compact('rendezVous'));
    }

    public function create(Request $request)
    {
        // Récupération du mois (par défaut : mois courant)
        $mois = $request->get('mois', now()->format('Y-m'));
        $dateReference = Carbon::createFromFormat('Y-m', $mois)->startOfMonth();

        // Créneaux horaires disponibles chaque jour
        $creneauxHoraires = ['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '16:00', '17:00'];
        $nbCreneauxParJour = count($creneauxHoraires);

        // Compter les RDV existants (non annulés) pour chaque jour du mois
        $debut = $dateReference->copy()->startOfMonth();
        $fin = $dateReference->copy()->endOfMonth();

        $rdvParJour = RendezVous::whereBetween('date', [$debut, $fin])
            ->where('statut', '!=', 'annule')
            ->get()
            ->groupBy(function ($rdv) {
                return Carbon::parse($rdv->date)->format('Y-m-d');
            });

        // Construction du calendrier
        $calendrier = [];
        $jourCourant = $debut->copy()->startOfWeek(Carbon::MONDAY);
        $finCalendrier = $fin->copy()->endOfWeek(Carbon::SUNDAY);

        while ($jourCourant <= $finCalendrier) {
            $dateStr = $jourCourant->format('Y-m-d');
            $rdvDuJour = $rdvParJour->get($dateStr, collect());
            $nbRdv = $rdvDuJour->count();

            // Créneaux occupés (heures déjà prises)
            $heuresOccupees = $rdvDuJour->map(function ($rdv) {
                return Carbon::parse($rdv->heure)->format('H:i');
            })->toArray();

            // Statut du jour
            $isPasse = $jourCourant->isPast() && !$jourCourant->isToday();
            $isDimanche = $jourCourant->isSunday();
            $isMoisCourant = $jourCourant->month === $dateReference->month;

            if ($isPasse || $isDimanche) {
                $statut = 'indisponible';
            } elseif ($nbRdv >= $nbCreneauxParJour) {
                $statut = 'complet';
            } elseif ($nbRdv >= ($nbCreneauxParJour * 0.7)) {
                $statut = 'charge';
            } else {
                $statut = 'disponible';
            }

            $calendrier[] = [
                'date' => $dateStr,
                'jour' => $jourCourant->day,
                'is_mois_courant' => $isMoisCourant,
                'is_aujourdhui' => $jourCourant->isToday(),
                'statut' => $statut,
                'nb_rdv' => $nbRdv,
                'heures_occupees' => $heuresOccupees,
                'heures_disponibles' => array_values(array_diff($creneauxHoraires, $heuresOccupees)),
            ];

            $jourCourant->addDay();
        }

        // Navigation mois précédent / suivant
        $moisPrecedent = $dateReference->copy()->subMonth()->format('Y-m');
        $moisSuivant = $dateReference->copy()->addMonth()->format('Y-m');

        return view('client.rendez-vous.create', compact(
            'calendrier',
            'dateReference',
            'creneauxHoraires',
            'moisPrecedent',
            'moisSuivant'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'heure' => 'required',
            'type_intervention' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
        ]);

        // Vérifier que le créneau est encore libre
        $exists = RendezVous::where('date', $data['date'])
            ->where('heure', $data['heure'])
            ->where('statut', '!=', 'annule')
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'Ce créneau vient d\'être réservé. Merci d\'en choisir un autre.');
        }

        $data['client_id'] = auth()->id();
        $data['statut'] = 'en_attente';

        RendezVous::create($data);

        return redirect()->route('client.rendez-vous.index')
            ->with('success', 'Rendez-vous demandé ! Il sera confirmé par un réceptionniste.');
    }

    public function destroy(RendezVous $rendezVou)
    {
        abort_if($rendezVou->client_id !== auth()->id(), 403);
        $rendezVou->update(['statut' => 'annule']);

        return redirect()->route('client.rendez-vous.index')
            ->with('success', 'Rendez-vous annulé.');
    }
}