<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificationService
{
    public function createNotification(array $data, ?User $user = null): Notification
    {
        return Notification::create(array_merge($data, [
            'user_id' => $user?->id,
        ]));
    }

    public function getUserNotifications(User $user): Collection
    {
        return Notification::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('is_public', true);
        })
        ->active()
        ->latest()
        ->get();
    }

    public function getUnreadCount(User $user): int
    {
        return Notification::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('is_public', true);
        })
        ->unread()
        ->active()
        ->count();
    }

    public function markAsRead(Notification $notification): void
    {
        $notification->markAsRead();
    }

    public function markAllAsRead(User $user): void
    {
        Notification::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('is_public', true);
        })
        ->unread()
        ->update(['read_at' => now()]);
    }

    public function deleteExpired(): int
    {
        return Notification::where('expires_at', '<=', now())->delete();
    }
} 