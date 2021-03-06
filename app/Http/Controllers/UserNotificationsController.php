<?php

namespace App\Http\Controllers;
use App\User;

/**
 * Class UserNotificationsController
 *
 * @package App\Http\Controllers
 */
class UserNotificationsController extends Controller
{

    /**
     * UserNotificationsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function index(User $user)
    {
        return auth()->user()->unreadNotifications;
    }

    /**
     * @param User $user
     * @param $notificationId
     */
    public function destroy(User $user, $notificationId)
    {
        auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
    }

}
