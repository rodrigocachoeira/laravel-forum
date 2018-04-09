<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

/**
 * Class ProfilesController
 *
 * @package App\Http\Controllers
 */
class ProfilesController extends Controller
{

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        $activities = $this->getActivity($user);

        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => $activities
        ]);
    }

    /**
     * @param $user
     */
    private function getActivity ($user)
    {
        return $user->activity()->with('subject')->take(50)->get()->groupBy(function ($activity) {
            return $activity->created_at->format('Y-m-d');
        });
    }
    
}
