<?php

namespace Tests\Feature;

use Tests\CustomTestCase;

class NotificationTest extends CustomTestCase
{
    public function test_user_can_see_his_notifications()
    {
        $this
            ->actingAs($this->user)
            ->get(route('notifications.index'))
            ->assertOk();

        $this->assertAuthenticated();
    }

    public function test_user_cannot_see_his_notifications_if_unauthenticated()
    {
        $this
            ->get(route('notifications.index'))
            ->assertStatus(302)
            ->assertRedirectToRoute('login');

        $this->assertGuest();
    }

    public function test_user_can_see_latest_notifications()
    {
        $this
            ->actingAs($this->user)
            ->get(route('notifications.latest'))
            ->assertOk();

        $this->assertAuthenticated();
    }

    public function test_user_cannot_see_latest_notifications_if_unauthenticated()
    {
        $this
            ->get(route('notifications.latest'))
            ->assertStatus(302)
            ->assertRedirectToRoute('login');

        $this->assertGuest();
    }

    public function test_user_can_visit_notification_link()
    {
        $notification = $this->user->notifications()->create([
            'id' => '8f9dj898j',
            'type' => 'App\\Notifications\\CommentSent',
            'data' => [
                'post_id' => '84349hf39j',
            ],
            'read_at' => null,
        ]);

        $this->actingAs($this->user)
            ->get(route('notifications.show', $notification->id))
            ->assertStatus(302)
            ->assertRedirectToRoute('posts.show', '84349hf39j');

        $this->assertAuthenticated();
        $this->assertDatabaseHas('notifications', [
            'read_at' => now(),
        ]);
        $this->assertDatabaseMissing('notifications', [
            'read_at' => null,
        ]);
    }

    public function test_user_can_mark_all_notifications_as_read()
    {
        $this
            ->actingAs($this->user)
            ->fromRoute('notifications.index')
            ->patch(route('notifications.mark_all_as_read'))
            ->assertStatus(302)
            ->assertRedirectToRoute('notifications.index');

        $this->assertAuthenticated();
    }

    public function test_user_can_clear_notifications()
    {
        $this
            ->actingAs($this->user)
            ->fromRoute('notifications.index')
            ->delete(route('notifications.clear'))
            ->assertStatus(302)
            ->assertSessionHasAll(['success'])
            ->assertRedirectToRoute('notifications.index');

        $this->assertAuthenticated();
    }
}
