<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Services\JsonService;

class NotificationController extends Controller
{
    /**
     * Get all unread notifications of authentificated user
     * 
     * @return type
     */
    public function index()
    {
        $user = User::findOrFail(auth()->id());
        $unreadNotifications = $user->unreadNotifications;
        if (is_null($unreadNotifications) || $unreadNotifications->isEmpty()) {
            return JsonService::jsonError('There are no new notifications!', 404);
        }

        return JsonService::jsonSuccess(
            'Returning unread notifications!',
            $unreadNotifications
        );
    }
}
