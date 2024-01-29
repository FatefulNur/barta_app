<?php

namespace Tests\Feature;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Notifications\LikeSent;
use Tests\CustomTestCase;
use Illuminate\Support\Facades\Notification;

class LikeTest extends CustomTestCase
{
    public Post $post;

    public function setUp(): void
    {
        parent::setUp();

        $this->post = Post::factory()->create([
            'user_id' => $this->user->id,
        ]);
    }

    public function test_user_can_like_a_post()
    {
        $this->actingAs($this->user)
            ->post(route('likes.store', [
                'post_id' => $this->post->id,
            ]))
            ->assertStatus(201);

        $this->assertAuthenticated();
        $this->assertDatabaseCount('likes', 1);
        $this->assertDatabaseHas('likes', [
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);
    }

    public function test_user_cannot_like_post_if_unauthenticated()
    {
        $this
            ->post(route('likes.store', [
                'post_id' => $this->post->id,
            ]))
            ->assertStatus(302)
            ->assertRedirectToRoute('login');

        $this->assertGuest();
    }

    public function test_notification_sent_to_post_user_when_post_liked()
    {
        Notification::fake();

        $post = Post::factory()->create();
        $user = User::find($post->user_id);

        $this
            ->actingAs($this->user)
            ->post(route('likes.store', [
                'post_id' => $post->id,
            ]));

        Notification::assertCount(1);
        Notification::assertSentTo($user, LikeSent::class);
    }

    public function test_notification_cannot_be_sent_if_i_like_my_post()
    {
        Notification::fake();

        $this
            ->actingAs($this->user)
            ->post(route('posts.comments.store', $this->post->id), [
                'post_id' => $this->post->id,
            ]);

        Notification::assertCount(0);
        Notification::assertNothingSent();
    }

    public function test_user_can_unlike_a_post()
    {
        $like = Like::create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);

        $this->actingAs($this->user)
            ->delete(route('likes.destroy', $like->id))
            ->assertOk();

        $this->assertAuthenticated();
        $this->assertDatabaseEmpty('likes');
    }
}
