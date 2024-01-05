<?php

namespace App\Notifications;

use App\Models\Like;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class LikeSent extends Notification
{
    use Queueable;

    public function __construct(public Like $like)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['broadcast', 'database'];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => auth()->user()->firstName() . " has reacted to your post.",
            'post_id' => $this->like->post_id,
            'created_at' => $this->like->created_at->toFormattedDayDateString(),
        ];
    }
}
