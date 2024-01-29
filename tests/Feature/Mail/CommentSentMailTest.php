<?php

namespace Tests\Feature\Mail;

use App\Mail\CommentSentMail;
use App\Models\Comment;
use Tests\CustomTestCase;

class CommentSentMailTest extends CustomTestCase
{
    public function test_mailable_content()
    {
        $notifiable = $this->user;
        $commentedBy = 'Bob Martin';
        $comment = Comment::factory()->create([
            'body' => 'A new comment',
        ]);

        $mailable = (new CommentSentMail($notifiable, $commentedBy, $comment))->to($notifiable->email);

        $mailable->assertTo('robert@test.io');
        $mailable->assertHasSubject('Comment Sent Mail');

        $mailable->assertSeeInText('Robert Bruce');
        $mailable->assertSeeInText('Bob Martin just has commented on your post: ');
        $mailable->assertSeeInText('Bob Martin just has commented on your post: ');
        $mailable->assertSeeInText('A new comment');
        $mailable->assertSeeInOrderInText(['View Post Comments', 'Take Care', 'From Barta']);
    }
}
