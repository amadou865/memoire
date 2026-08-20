<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ParametreController extends Controller
{
    public function index()
    {
        $garageInfo = [
            'nom' => 'Génération Automobile',
            'adresse' => 'Cambérène, Dakar, Sénégal',
            'telephone' => '+221 77 123 45 67',
            'email' => 'contact@generation-auto.sn',
            'horaires' => 'Lun - Ven : 8h - 18h | Samedi : 8h - 13h',
            'departements' => ['Mécanique', 'Électricité', 'Froid et climatisation', 'Tôlerie', 'Peinture'],
        ];

        return view('admin.parametres.index', compact('garageInfo'));
    }
}