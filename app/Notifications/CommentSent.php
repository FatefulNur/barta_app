<?php

namespace App\Notifications;

use App\Mail\CommentSentMail;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CommentSent extends Notification
{
    use Queueable;

    public function __construct(public Comment $comment)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'broadcast', 'database'];
    }

    public function toMail(object $notifiable): Mailable
    {
        return (new CommentSentMail($notifiable, $this->comment))->to($notifiable->email);
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'user_profile' => auth()->user()->getProfileImage(),
            'message' => auth()->user()->firstName() . " says: " . $this->comment->body,
            'post_id' => $this->comment->post_id,
            'created_at' => $this->comment->created_at->toFormattedDayDateString(),
        ];
    }
}
