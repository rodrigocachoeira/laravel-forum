<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{

	public function __construct ()
	{
		$this->middleware('auth');
	}
    
	/**
     * Store a newly created resource in storage.
     *
     * @param $channelId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function store ($channelId, Thread $thread)
	{
		$this->validate(request(), [
			'body'	=> 'required',
		]);
		$thread->addReply([
			'body' 		=> request('body'),
			'user_id'	=> auth()->id()
		]);

		return back(); 
	}

}
