<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Tests\CustomTestCase;
use Illuminate\Support\Facades\Storage;

class PostTest extends CustomTestCase
{
    public function test_user_can_see_single_post_page()
    {
        $this
            ->actingAs($this->user)
            ->get(route('posts.show', $this->user->id))
            ->assertOk();

        $this->assertAuthenticated();
    }

    public function test_user_cannot_see_single_post_page_if_unauthenticated()
    {
        $this
            ->get(route('posts.show', $this->user->id))
            ->assertStatus(302)
            ->assertRedirectToRoute('login');

        $this->assertGuest();
    }

    public function test_user_can_create_post()
    {
        $this
            ->actingAs($this->user)
            ->fromRoute('home')
            ->post(route('posts.store'), [
                'body' => 'A new post',
            ])
            ->assertStatus(302)
            ->assertRedirectToRoute('home')
            ->assertSessionDoesntHaveErrors()
            ->assertSessionHasAll(['success']);

        $this->assertAuthenticated();
        $this->assertDatabaseCount('posts', 1);
        $this->assertDatabaseHas('posts', [
            'body' => 'A new post',
        ]);
    }

    public function test_user_cannot_create_post_with_invalid_input()
    {
        Storage::fake('media');
        $file = UploadedFile::fake()->create('banner.pdf');

        $this
            ->actingAs($this->user)
            ->post(route('posts.store'), [
                'picture' => $file,
                'body' => null,
            ])
            ->assertSessionHasErrors(['picture', 'body']);

        Storage::disk('media')->assertMissing($file->path());
    }

    public function test_user_can_upload_post_image()
    {
        Storage::fake('media');
        $photo = UploadedFile::fake()->image('banner.png');

        $this
            ->actingAs($this->user)
            ->post(route('posts.store'), [
                'picture' => $photo,
                'body' => 'A new post',
            ]);

        Storage::disk('media')->assertExists($photo->path());
        $this->assertAuthenticated();
        $this->assertDatabaseCount('media', 1);
        $this->assertDatabaseHas('media', [
            'name' => 'banner',
            'file_name' => 'banner.png',
        ]);
    }

    public function test_user_can_see_edit_post_page()
    {
        $this
            ->actingAs($this->user)
            ->get(route('posts.edit', $this->user->id))
            ->assertOk();

        $this->assertAuthenticated();
    }

    public function test_user_cannot_see_edit_post_page_if_unauthenticated()
    {
        $this
            ->get(route('posts.edit', $this->user->id))
            ->assertStatus(302)
            ->assertRedirectToRoute('login');

        $this->assertGuest();
    }

    public function test_user_can_update_his_post()
    {
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $this
            ->actingAs($this->user)
            ->fromRoute('home')
            ->put(route('posts.update', $post->id), [
                'body' => 'Updated post body',
            ])
            ->assertStatus(302)
            ->assertRedirectToRoute('posts.show', $post->id)
            ->assertSessionDoesntHaveErrors()
            ->assertSessionHasAll(['success']);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('posts', [
            'body' => 'Updated post body',
        ]);
    }

    public function test_user_can_update_post_image()
    {
        Storage::fake('media');
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $photo = UploadedFile::fake()->image('banner2.png');

        $this
            ->actingAs($this->user)
            ->put(route('posts.update', $post->id), [
                'picture' => $photo,
                'body' => 'Updated post body',
            ])
            ->assertSessionDoesntHaveErrors();

        $this->assertAuthenticated();
        Storage::disk('media')->assertExists($photo->path());
        $this->assertDatabaseHas('media', [
            'name' => 'banner2',
            'file_name' => 'banner2.png',
        ]);
    }

    public function test_user_cannot_update_multiple_post_image()
    {
        Storage::fake('media');
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
        ]);
        $photo = UploadedFile::fake()->image('banner.png');
        $photo2 = UploadedFile::fake()->image('banner2.png');

        $this->user->addMedia($photo);

        $this
            ->actingAs($this->user)
            ->put(route('posts.update', $post->id), [
                'picture' => $photo2,
                'body' => 'Updated post body',
            ])
            ->assertSessionDoesntHaveErrors();

        $this->assertAuthenticated();
        Storage::disk('media')->assertExists($photo2->path());
        Storage::disk('media')->assertMissing($photo->path());
        $this->assertDatabaseCount('media', 1);
        $this->assertDatabaseHas('media', [
            'name' => 'banner2',
            'file_name' => 'banner2.png',
        ]);
    }

    public function test_user_cannot_update_post_with_invalid_input()
    {
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
        ]);

        Storage::fake('media');
        $file = UploadedFile::fake()->create('banner2.pdf');

        $this
            ->actingAs($this->user)
            ->put(route('posts.update', $post->id), [
                'picture' => $file,
                'body' => null,
            ])
            ->assertSessionHasErrors(['picture', 'body']);

        Storage::disk('media')->assertMissing($file->path());
    }

    public function test_user_cannot_update_any_other_users_post()
    {
        $post = Post::factory()->create();

        $this
            ->actingAs($this->user)
            ->put(route('posts.update', $post->id), [
                'body' => 'Updated post body',
            ])
            ->assertForbidden();

        $this->assertAuthenticated();
    }

    public function test_user_can_delete_his_post()
    {
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $this
            ->actingAs($this->user)
            ->delete(route('posts.destroy', $post->id))
            ->assertStatus(302)
            ->assertRedirectToRoute('home')
            ->assertSessionHasAll(['success']);

        $this->assertAuthenticated();
        $this->assertDatabaseEmpty('posts');
    }

    public function test_user_cannot_delete_any_other_users_post()
    {
        $post = Post::factory()->create();

        $this
            ->actingAs($this->user)
            ->delete(route('posts.destroy', $post->id), [
                'body' => 'Updated post body',
            ])
            ->assertForbidden();

        $this->assertAuthenticated();
    }
}
