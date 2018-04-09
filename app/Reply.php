<?php

namespace App;

use App\Http\Controllers\FavoritesController;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    use Favoritable, RecordsActivity;

    /**
     * @var array
     */
	protected $guarded = [];

    /**
     * @var array
     */
	protected $with = ['owner', 'favorites'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner ()
	{
		return $this->belongsTo(User::class, 'user_id');
	}


}
