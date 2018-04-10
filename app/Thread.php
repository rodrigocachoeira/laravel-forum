<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Thread
 * @package App
 */
class Thread extends Model
{

  use RecordsActivity;

    /**
     * @var array
     */
  protected $guarded = [];

    /**
     * @var array
     */
  protected $with = ['creator', 'channel'];

    /**
     *
     */
  protected static function boot ()
  {
    parent::boot();

    static::addGlobalScope('replyCount', function ($builder) {
       $builder->withCount('replies');
    });

    static::deleting(function ($thread) {
       $thread->replies->each->delete();
    });
  }

    /**
     * @return string
     */
  public function path ()
  { 
    return "/threads/{$this->channel->slug}/{$this->id}";
  }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
  public function replies ()
  {
  	return $this->hasMany(Reply::class);
  }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
  public function creator ()
  {
  	return $this->belongsTo(User::class, 'user_id');
  }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
  public function channel ()
  {
    return $this->belongsTo(Channel::class);
  }

    /**
     * @param $reply
     */
  public function addReply ($reply)
  {
    $this->replies()->create($reply);
  }

    /**
     * @param $query
     * @param $filters
     * @return mixed
     */
  public function scopeFilter ($query, $filters)
  {
      return $filters->apply($query);
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
