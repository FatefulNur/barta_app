<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Tests\CustomTestCase;
use App\Notifications\CommentSent;
use Illuminate\Support\Facades\Notification;

class CommentTest extends CustomTestCase
{
    public Post $post;

    public function setUp(): void
    {
        parent::setUp();

        $this->post = Post::factory()->create([
            'user_id' => $this->user->id,
        ]);
    }

    public function test_user_can_create_comment()
    {
        $this
            ->actingAs($this->user)
            ->fromRoute('posts.show', $this->post->id)
            ->post(route('posts.comments.store', $this->post->id), [
                'body' => 'A new comment',
            ])
            ->assertStatus(302)
            ->assertRedirectToRoute('posts.show', $this->post->id)
            ->assertSessionDoesntHaveErrors()
            ->assertSessionHasAll(['success']);

        $this->assertAuthenticated();
        $this->assertDatabaseCount('comments', 1);
        $this->assertDatabaseHas('comments', [
            'body' => 'A new comment',
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);
    }

    public function test_user_cannot_create_comment_if_unauthenticated()
    {
        $this
            ->post(route('posts.comments.store', $this->post->id), [
                'body' => 'A new comment',
            ])
            ->assertStatus(302)
            ->assertRedirectToRoute('login');

        $this->assertGuest();
    }

    public function test_user_cannot_create_comment_with_invalid_input()
    {
        $this
            ->actingAs($this->user)
            ->fromRoute('posts.show', $this->post->id)
            ->post(route('posts.comments.store', $this->post->id), [
                'body' => null,
            ])
            ->assertSessionHasErrors(['body']);
    }

    public function test_notification_sent_to_post_user_when_comment_created()
    {
        Notification::fake();

        $post = Post::factory()->create();
        $user = User::find($post->user_id);

        $this
            ->actingAs($this->user)
            ->post(route('posts.comments.store', $post->id), [
                'body' => 'A new comment',
            ]);

        Notification::assertCount(1);
        Notification::assertSentTo($user, CommentSent::class);
    }

    public function test_notification_cannot_be_sent_if_i_comment_my_post()
    {
        Notification::fake();

        $this
            ->actingAs($this->user)
            ->post(route('posts.comments.store', $this->post->id), [
                'body' => 'A new comment',
            ]);

        Notification::assertCount(0);
        Notification::assertNothingSent();
    }

    public function test_user_can_update_his_comment()
    {
        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);

        $this
            ->actingAs($this->user)
            ->fromRoute('posts.show', $this->post->id)
            ->put(route('posts.comments.update', [
                'post' => $this->post->id,
                'comment' => $comment->id,
            ]), [
                'body' => 'Updated comment',
            ])
            ->assertStatus(302)
            ->assertRedirectToRoute('posts.show', $this->post->id)
            ->assertSessionDoesntHaveErrors()
            ->assertSessionHasAll(['success']);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('comments', [
            'body' => 'Updated comment',
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);
    }

    public function test_user_cannot_update_comment_with_invalid_input()
    {
        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);

        $this
            ->actingAs($this->user)
            ->put(route('posts.comments.update', [
                'post' => $this->post->id,
                'comment' => $comment->id,
            ]), [
                'body' => null,
            ])
            ->assertSessionHasErrors(['body']);
    }

    public function test_user_cannot_update_any_other_users_comment()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $post->user_id,
            'post_id' => $post->id,
        ]);

        $this
            ->actingAs($this->user)
            ->put(route('posts.comments.update', [
                'post' => $post->id,
                'comment' => $comment->id,
            ]), [
                'body' => 'Updated comment',
            ])
            ->assertForbidden();

        $this->assertAuthenticated();
    }

    public function test_user_can_delete_his_comment()
    {
        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);

        $this
            ->actingAs($this->user)
            ->fromRoute('posts.show', $this->post->id)
            ->delete(route('posts.comments.destroy', [
                'post' => $this->post->id,
                'comment' => $comment->id,
            ]), [
                'body' => 'Updated comment',
            ])
            ->assertStatus(302)
            ->assertRedirectToRoute('posts.show', $this->post->id)
            ->assertSessionDoesntHaveErrors()
            ->assertSessionHasAll(['success']);

        $this->assertAuthenticated();
        $this->assertDatabaseEmpty('comments');
    }

    public function test_user_cannot_delete_any_other_users_comment()
    {
        $post = Post::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $post->user_id,
            'post_id' => $post->id,
        ]);

        $this
            ->actingAs($this->user)
            ->delete(route('posts.comments.destroy', [
                'post' => $post->id,
                'comment' => $comment->id,
            ]), [
                'body' => 'Updated comment',
            ])
            ->assertForbidden();

        $this->assertAuthenticated();
    }
}
