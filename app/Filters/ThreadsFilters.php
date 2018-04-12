<?php

namespace App\Filters;

use App\User;

/**
 * Class ThreadsFilters
 *
 * @package App
 */
class ThreadsFilters extends Filters
{

    /**
     * @var array
     */
    protected $filters = ['by', 'popular', 'unanswered'];

    /**
     * Filter the query by a given username
     *
     * @param string $username
     * @return mixed
     */
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query according to most
     * popular threads
     *
     * @return mixed
     */
    protected function popular ()
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count', 'desc');
    }

    /**
     * Filter the query according to most
     * popular threads
     *
     * @return mixed
     */
    protected function unanswered ()
    {
        return $this->builder->where('replies_count', 0);
    }

}