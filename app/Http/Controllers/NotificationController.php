<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function index()
    {
        return auth()->user()->notifications;
    }

    public function latest()
    {
        return auth()->user()->unreadNotifications
            ->take(2)
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    ...$notification->data
                ];
            })->all();
    }

    public function show(string $id)
    {
        $notification = auth()->user()->unreadNotifications->find($id);

        $notification->markAsRead();

        return to_route('posts.show', $notification->data['post_id']);
    }
}
