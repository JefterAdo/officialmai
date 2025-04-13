<?php

namespace App\Livewire;

use App\Services\NotificationService;
use Livewire\Component;

class NotificationBell extends Component
{
    public $unreadCount = 0;
    public $notifications = [];
    public $showDropdown = false;

    protected $listeners = ['refreshNotifications'];

    public function mount(NotificationService $notificationService)
    {
        $this->refreshNotifications($notificationService);
    }

    public function refreshNotifications(NotificationService $notificationService)
    {
        if (auth()->check()) {
            $this->unreadCount = $notificationService->getUnreadCount(auth()->user());
            $this->notifications = $notificationService->getUserNotifications(auth()->user())
                ->take(5)
                ->toArray();
        }
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
    }

    public function markAsRead($notificationId, NotificationService $notificationService)
    {
        $notification = \App\Models\Notification::find($notificationId);
        if ($notification) {
            $notificationService->markAsRead($notification);
            $this->refreshNotifications($notificationService);
        }
    }

    public function markAllAsRead(NotificationService $notificationService)
    {
        if (auth()->check()) {
            $notificationService->markAllAsRead(auth()->user());
            $this->refreshNotifications($notificationService);
        }
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
} 