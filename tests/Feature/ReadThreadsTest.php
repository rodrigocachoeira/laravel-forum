<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReadThreadsTest extends TestCase
{

   use DatabaseMigrations;

   public function setUp ()
   {
     parent::setUp();
     $this->thread = create('App\Thread');
   }

   /**
   * @test
   */
    public function a_user_can_view_all_threads()
    {
      $this->get('/threads')
        ->assertStatus(200)
        ->assertSee($this->thread->title);
    }

    /**
    * @test
    */
    public function a_user_can_read_a_single_thread()
    {
      $this->get($this->thread->path())
          ->assertSee($this->thread->title);
    }

    /**
    * @test
    */
    public function a_user_can_filter_threads_according_to_a_tag()
    {
        $channel = create('App\Channel');
        $threadIdChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/'. $channel->slug)
            ->assertSee($threadIdChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /**
    * @test
    */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'JohnDoe']) );

        $threadByJhon = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Thread');

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJhon->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    /**
    * @test
    */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

        $response = $this->getJson('threads?popular=1')->json();
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }

    /**
     * @test
     */
    public function a_user_can_filter_threads_by_those_that_are_unaswered()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson('threads?unanswered=1')->json();
        $this->assertCount(1, $response);
    }


}
