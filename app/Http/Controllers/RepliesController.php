<?php

namespace App\Http\Controllers;

use App\Reply;
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
     * @param  $thread
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

		return back()->with('flash', 'Your reply has been left.');
	}

    /**
     * @param Reply $reply
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
	public function destroy (Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();
        return back()->with('flash', 'Your reply has been deleted.');
    }

}
