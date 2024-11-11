<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index($gymId)
    {
        $gym = Gym::find($gymId);

        if (!$gym) {
            return response()->json(['message' => 'Gym not found'], 404);
        }

        $notifications = $gym->notifications;

        return response()->json([
            'message' => 'Your Notifications:',
            'data' => $notifications
        ], 200);
    }

    public function markAsRead($gymId, $id)
    {
        $gym = Gym::find($gymId);
        $notification = $gym->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['message' => 'Notification marked as read'], 200);
        }

        return response()->json(['message' => 'Notification not found'], 404);
    }
}
