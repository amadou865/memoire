<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;

class NotificationService
{
    /**
     * Envoyer une notification à 1 utilisateur spécifique (ex: un Client)
     */
    public static function envoyer(User|int $user, string $titre, string $message, string $type, ?string $lien = null)
    {
        $userId = $user instanceof User ? $user->id : $user;

        return Notification::create([
            'user_id'    => $userId,
            'titre'      => $titre,
            'message'    => $message,
            'type_notif' => $type,
            'lien'       => $lien,
            'date_envoi' => Carbon::now(),
            'lu'         => false,
        ]);
    }

    /**
     * Envoyer une notification à TOUS les utilisateurs ayant un rôle (ex: tous les Réceptionnistes)
     */
    public static function envoyerAuRole(string $role, string $titre, string $message, string $type, ?string $lien = null)
    {
        User::where('role', $role)->get()->each(function ($user) use ($titre, $message, $type, $lien) {
            self::envoyer($user, $titre, $message, $type, $lien);
        });
    }
}