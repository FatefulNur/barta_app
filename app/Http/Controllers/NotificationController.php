<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'is_unread' => is_null($notification->read_at),
                ...$notification->data,
            ];
        })->all();

        return inertia()->render('Notifications/Index', [
            'notifications' => $notifications,
        ]);
    }

    public function latest()
    {
        return auth()->user()->unreadNotifications
            ->take(2)
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    ...$notification->data,
                ];
            })->all();
    }

    public function show(string $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);

        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return to_route('posts.show', $notification->data['post_id']);
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'Marked all as read');
    }

    public function clear()
    {
        auth()->user()->notifications()->delete();

        return back()->with('success', 'Cleared all notifications');
    }
}
