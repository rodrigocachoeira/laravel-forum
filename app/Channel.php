<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function threads()
    {
        return $this->hasMany('App\Thread');
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
