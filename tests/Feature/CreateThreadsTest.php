<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadsTest extends TestCase
{

	use DatabaseMigrations;

	/** @test */
	public function guest_may_not_create_threads ()
	{
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
	}

    
    /** @test */
    public function an_authenticated_user_can_create_new_threads()
    {
    	// Cria um usuário logado
    	$this->signIn();

    	// Clicar no botão de criação de uma nova thread
    	$thread = create('App\Thread');
    	$this->post('/threads', $thread->toArray());

    	//Listagem da Thread
    	//Deve ser renderizada a nova thread
    	$this->get($thread->path())
			->assertSee($thread->title)
    		->assertSee($thread->body);
    }
}
