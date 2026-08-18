@props(['statut'])

@php
    // Configuration des couleurs et libellés selon le statut
    $config = match($statut) {
        // Statuts Rendez-vous
        'en_attente' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'En attente'],
        'confirme'   => ['bg' => 'bg-blue-100',   'text' => 'text-blue-800',   'label' => 'Confirmé'],
        'annule'     => ['bg' => 'bg-red-100',    'text' => 'text-red-800',    'label' => 'Annulé'],

        // Statuts Intervention
        'planifiee'  => ['bg' => 'bg-gray-100',   'text' => 'text-gray-800',   'label' => 'Planifiée'],
        'en_cours'   => ['bg' => 'bg-blue-100',   'text' => 'text-blue-800',   'label' => 'En cours'],
        'terminee'   => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800', 'label' => 'Terminée'],
        
        // Statuts Qualité / Facturation
        'validee'    => ['bg' => 'bg-green-100',  'text' => 'text-green-800',  'label' => 'Validée'],
        'non_conforme' => ['bg' => 'bg-red-100',  'text' => 'text-red-800',    'label' => 'Non conforme'],
        'paye'       => ['bg' => 'bg-green-600 text-white', 'text' => '',      'label' => 'Payé'],

        default      => ['bg' => 'bg-gray-100',   'text' => 'text-gray-600',   'label' => ucfirst($statut)],
    };
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $config['bg'] }} {{ $config['text'] }}">
    {{ $config['label'] }}
</span>