<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{

	public function __construct ()
	{
		$this->middleware('auth', ['except' => 'index']);
	}

    /**
    * @param $channelId
    * @param Thread $thread
    * @return mixed
    */
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
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
		$reply = $thread->addReply([
			'body' 		=> request('body'),
			'user_id'	=> auth()->id()
		]);

        if (request()->expectsJson())
            return $reply->load('owner');

		return back()->with('flash', 'Your reply has been left.');
	}

    /**
     * @param Reply $reply
     */
	public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update(['body' => request()->get('body')]);
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

        if (request()->expectsJson())
            return response(['status' => 'Reply Deleted']);

        return back()->with('flash', 'Your reply has been deleted.');
    }

}
