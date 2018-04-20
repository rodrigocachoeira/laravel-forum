<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
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
     * @var array
     */
  protected $appends = ['isSubscribedTo'];

    /**
     *
     */
  protected static function boot ()
  {
    parent::boot();

//    static::addGlobalScope('replyCount', function ($builder) {
//       $builder->withCount('replies');
//    });

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
    $reply = $this->replies()->create($reply);

    $this->subscriptions->filter(function ($sub) use ($reply) {
       return $sub->user_id != $reply->user_id;
    })->each->notify($reply);

    return $reply;
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

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    /**
     * @param int $userId
     */
    public function unsubscribe($userId = 1)
    {
        $this->subscriptions()->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    /**
     * @return bool
     */
    public function getIsSubscribedToAttribute ()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }
}
