<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;

class FavoritesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Reply $reply
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store (Reply $reply)
    {
       $reply->favorite();

       return back();
    }

    /**
     * @param Reply $reply
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function destroy (Reply $reply)
    {
        $reply->unfavorite();
    }


}
