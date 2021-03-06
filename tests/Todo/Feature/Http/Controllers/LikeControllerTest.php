<?php

namespace Tests\Todo\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LikeController
 */
class LikeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $like = factory(\App\Models\Like::class)->create();
        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->delete(route('dislike', ['postId' => $like->postId]));

        $response->assertRedirect(withErrors('You have already liked/disliked this post!'));
        $this->assertDeleted($dislike);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $like = factory(\App\Models\Like::class)->create();
        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->delete(route('like', ['postId' => $like->postId]));

        $response->assertRedirect(withErrors('You have already liked/disliked this post!'));

        // TODO: perform additional assertions
    }

    // test cases...
}
