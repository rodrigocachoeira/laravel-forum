<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Activity
 *
 * @package App
 */
class Activity extends Model
{

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     *
     */
    public function subject ()
    {
        return $this->morphTo();
    }

    /**
     * @param User
     * @param $take
     *
     * @return static
     */
    public static function feed (User $user, $take = 50)
    {
        return static::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->take($take)
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }

    /**
     * Get the connection of the entity.
     *
     * @return string|null
     */
    public function getQueueableConnection()
    {
        // TODO: Implement getQueueableConnection() method.
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed $value
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value)
    {
        // TODO: Implement resolveRouteBinding() method.
    }
}
