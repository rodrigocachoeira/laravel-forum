<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use App\Filters\ThreadsFilters;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{

    /**
    * ThreadsControler Constructor
    */
    public function __construct ()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @param ThreadsFilters $threadsFilters
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadsFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson())
            return $threads;

        return view('threads.index', compact('threads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'         => 'required',
            'body'          => 'required',
            'channel_id'    => 'required|exists:channels,id',
        ]);
        $thread = Thread::create([
            'title'   => request('title'),
            'body'    => request('body'),
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
        ]);

        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  $channelId
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId, Thread $thread)
    {
        return view('threads.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(20)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }

    /**
     * @param Channel $channel
     * @param ThreadsFilters $filters
     * @return mixed
     */
    public function getThreads(Channel $channel, ThreadsFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }
        return $threads->get();
    }
}
