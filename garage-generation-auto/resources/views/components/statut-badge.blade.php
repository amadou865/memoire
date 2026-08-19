@props(['statut'])

@php
    $config = match($statut) {
        // Statuts Rendez-vous
        'en_attente' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'En attente'],
        'confirme'   => ['bg' => 'bg-blue-100',   'text' => 'text-blue-800',   'label' => 'Confirmé'],
        'annule'     => ['bg' => 'bg-red-100',    'text' => 'text-red-800',    'label' => 'Annulé'],

        // Statuts Intervention
        'planifiee'  => ['bg' => 'bg-gray-100',   'text' => 'text-gray-800',   'label' => 'Planifiée'],
        'en_cours'   => ['bg' => 'bg-blue-100',   'text' => 'text-blue-800',   'label' => 'En cours'],
        'terminee'   => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800', 'label' => 'Terminée'],
        'annulee'    => ['bg' => 'bg-red-100',    'text' => 'text-red-800',    'label' => 'Annulée'],

        // Statuts Devis
        'brouillon'  => ['bg' => 'bg-gray-100',   'text' => 'text-gray-700',   'label' => 'Brouillon'],
        'valide'     => ['bg' => 'bg-green-100',  'text' => 'text-green-800',  'label' => 'Validé'],
        'facture'    => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'label' => 'Facturé'],

        // Statuts Facture
        'paye'       => ['bg' => 'bg-green-500',  'text' => 'text-white',      'label' => '✓ Payé'],

        // Statuts Qualité
        'validee'    => ['bg' => 'bg-green-100',  'text' => 'text-green-800',  'label' => 'Validée'],
        'non_conforme' => ['bg' => 'bg-red-100',  'text' => 'text-red-800',    'label' => 'Non conforme'],

        default      => ['bg' => 'bg-gray-100',   'text' => 'text-gray-600',   'label' => ucfirst(str_replace('_', ' ', $statut))],
    };
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }}">
    {{ $config['label'] }}
</span>