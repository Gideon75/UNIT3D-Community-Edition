<?php

namespace Tests\Todo\Feature\Http\Controllers\Staff;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Staff\TagController
 */
class TagControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->get(route('staff.tags.create'));

        $response->assertOk();
        $response->assertViewIs('Staff.tag.create');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $tag = factory(\App\Models\Tag::class)->create();
        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->get(route('staff.tags.edit', ['id' => $tag->id]));

        $response->assertOk();
        $response->assertViewIs('Staff.tag.edit');
        $response->assertViewHas('tag');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->get(route('staff.tags.index'));

        $response->assertOk();
        $response->assertViewIs('Staff.tag.index');
        $response->assertViewHas('tags');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->post(route('staff.tags.store'), [
            // TODO: send request data
        ]);

        $response->assertRedirect(withErrors($v->errors()));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete('This test case was generated by Shift. When you are ready, remove this line and complete this test case.');

        $tag = factory(\App\Models\Tag::class)->create();
        $user = factory(\App\Models\User::class)->create();

        $response = $this->actingAs($user)->post(route('staff.tags.update', ['id' => $tag->id]), [
            // TODO: send request data
        ]);

        $response->assertRedirect(withErrors($v->errors()));

        // TODO: perform additional assertions
    }

    // test cases...
}
