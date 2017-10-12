<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{

    use DatabaseMigrations;

    /**
    * @test
    */
    public function guests_can_not_favorite_anything()
    {
        $this->withExceptionHandling();

        $this->post('/replies/1/favorites')
            ->assertRedirect('/login');
    }

    /**
    * @test
    */
    public function and_authenticated_user_can_favorite_any_reply()
    {
        $this->withExceptionHandling()->signIn();
        $reply = create('App\Reply');

        $this->post('replies/'.$reply->id.'/favorites');
        $this->assertCount(1, $reply->favorites);
    }

    /**
     * @test
     */
    public function and_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->withExceptionHandling()->signIn();
        $reply = create('App\Reply');

        $this->post('replies/'.$reply->id.'/favorites');
        $this->post('replies/'.$reply->id.'/favorites');

        $this->assertCount(1, $reply->favorites);
    }
}