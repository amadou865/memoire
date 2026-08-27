<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /** Afficher toutes les notifications de l'utilisateur connecté */
    public function index(): View
    {
        $notifications = auth()->user()
            ->notifications()
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    /** Marquer une notification comme lue et rediriger vers son lien */
    public function lire(Notification $notification): RedirectResponse
    {
        abort_unless($notification->user_id === auth()->id(), 403);

        $notification->update(['lu' => true]);

        if ($notification->lien) {
            return redirect($notification->lien);
        }

        return back();
    }

    /** Tout marquer comme lu */
    public function toutLire(): RedirectResponse
    {
        auth()->user()
            ->notificationsNonLues()
            ->update(['lu' => true]);

        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    /** Supprimer une notification */
    public function destroy(Notification $notification): RedirectResponse
    {
        abort_unless($notification->user_id === auth()->id(), 403);

        $notification->delete();

        return back()->with('success', 'Notification supprimée.');
    }
}