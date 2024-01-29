<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\CustomTestCase;
use App\Models\User;

class ProfileTest extends CustomTestCase
{
    public function test_user_can_see_profile_page()
    {
        $this
            ->actingAs($this->user)
            ->get(route('profile.index', $this->user->id))
            ->assertOk();

        $this->assertAuthenticated();
    }

    public function test_user_cannot_see_profile_page_if_unauthenticated()
    {
        $this
            ->get(route('profile.index', $this->user->id))
            ->assertStatus(302)
            ->assertRedirectToRoute('login');

        $this->assertGuest();
    }

    public function test_user_can_see_edit_profile_page()
    {
        $this
            ->actingAs($this->user)
            ->get(route('profile.edit', $this->user->id))
            ->assertOk();

        $this->assertAuthenticated();
    }

    public function test_user_cannot_see_edit_profile_page_if_not_owner()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get(route('profile.edit', $this->user->id))
            ->assertForbidden();

        $this->assertAuthenticated();
    }

    public function test_user_can_update_his_profile()
    {
        $this
            ->actingAs($this->user)
            ->fromRoute('profile.edit', $this->user->id)
            ->put(route('profile.update'), [
                'name' => 'Bob Martin',
                'username' => 'bob_martin',
                'email' => 'martin@test.io',
                'bio' => 'I prefer to write unit test.',
            ])
            ->assertStatus(302)
            ->assertRedirectToRoute('profile.edit', $this->user->id)
            ->assertSessionDoesntHaveErrors()
            ->assertSessionHasAll(['success']);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'name' => 'Bob Martin',
            'username' => 'bob_martin',
            'email' => 'martin@test.io',
            'bio' => 'I prefer to write unit test.',
        ]);
    }

    public function test_user_can_upload_profile_photo()
    {
        Storage::fake('avatar');
        $photo = UploadedFile::fake()->image('avatar.png');

        $this
            ->actingAs($this->user)
            ->put(route('profile.update'), [
                'avatar' => $photo,
                'name' => 'Bob Martin',
                'username' => 'bob_martin',
                'email' => 'martin@test.io',
            ])
            ->assertSessionDoesntHaveErrors();

        Storage::disk('avatar')->assertExists($photo->path());
        $this->assertAuthenticated();
        $this->assertDatabaseCount('media', 1);
        $this->assertDatabaseHas('media', [
            'name' => 'avatar',
            'file_name' => 'avatar.png',
        ]);
    }

    public function test_user_cannot_upload_multiple_profile_photo()
    {
        Storage::fake('avatar');
        $photo = UploadedFile::fake()->image('avatar.png');
        $photo2 = UploadedFile::fake()->image('avatar2.png');

        $this->user->addMedia($photo);

        $this
            ->actingAs($this->user)
            ->put(route('profile.update'), [
                'avatar' => $photo2,
                'name' => 'Bob Martin',
                'username' => 'bob_martin',
                'email' => 'martin@test.io',
            ])
            ->assertSessionDoesntHaveErrors();

        Storage::disk('avatar')->assertExists($photo2->path());
        Storage::disk('avatar')->assertMissing($photo->path());
        $this->assertAuthenticated();
        $this->assertDatabaseCount('media', 1);
        $this->assertDatabaseHas('media', [
            'name' => 'avatar2',
            'file_name' => 'avatar2.png',
        ]);
    }

    public function test_user_has_default_profile_photo()
    {
        $this->assertFileExists(public_path($this->user::DEFAULT_IMAGE_PATH));
    }

    #[DataProvider('provideInvalidInputData')]
    public function test_user_cannot_update_profile_with_invalid_input($name, $username, $email)
    {
        Storage::fake('avatar');
        $file = UploadedFile::fake()->create('avatar.pdf');

        $this
            ->actingAs($this->user)
            ->fromRoute('profile.edit', $this->user->id)
            ->put(route('profile.update'), [
                'avatar' => $file,
                'name' => $name,
                'username' => $username,
                'email' => $email,
            ])
            ->assertSessionHasErrors(['avatar', 'name', 'username', 'email']);

        Storage::disk('avatar')->assertMissing($file->path());
    }
    public static function provideInvalidInputData()
    {
        $data = [];

        // first input
        $data['null_input'] = [
            'name' => null,
            'username' => null,
            'email' => null,
        ];

        // second input
        $data['invalid_input'] = [
            'name' => 'Bob',
            'username' => '@bob',
            'email' => 'bobtest.io',
        ];

        return $data;
    }
}
