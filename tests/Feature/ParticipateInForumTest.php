<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{

	use DatabaseMigrations;

	/** @test */
	public function unauthenticated_users_may_not_add_replies ()
	{
		$this->withExceptionHandling()
		     ->post('/threads/some-channel/1/replies', [])
		     ->assertRedirect('/login'); 
	}

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {        
    	//Cria um usuário e realiza o login na aplicação
        $this->be($user = create('App\User')); 

        //Gera uma nova thread e um novo reply
		$thread = create('App\Thread');
		$reply = make('App\Reply');

		//quando um usuário adiciona um reply a uma thread
		$this->post($thread->path().'/replies', $reply->toArray());        

		//o reply cadastrado deve ser visível na página
		$this->get($thread->path())
			->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_requires_a_body ()
    {
    	$this->withExceptionHandling()->signIn();

    	$thread = create('App\Thread');
    	$reply = make('App\Reply', ['body' => null]);

    	$this->post($thread->path() . '/replies', $reply->toArray())
    		->assertSessionHasErrors('body');
    }
}
