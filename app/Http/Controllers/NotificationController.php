<?php

namespace App\Http\Controllers;

use App\Settings;
use App\User;
use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Collection;

class NotificationController extends Controller
{

    public function list($unread = false)
    {
        $user = User::all()->first();
        $notifications = $unread ? $user->unreadNotifications()->get() : $user->notifications;
        /** @var Collection $notifications */
        $notifications->map(function ($notification) {
            $notification = $notification->toArray();
            return array_except($notification, ['notifiable_id', 'notifiable_type']);
        });
        return $notifications;
    }

    public function unreadCount()
    {
        $user = User::all()->first();
        return $user->unreadNotifications()->count();
    }

    public function markAsRead($id)
    {
        $user = User::all()->first();
        /** @var DatabaseNotification $notification */
        $notification = $user->notifications()->where('id', $id)->firstOrFail();
        $notification->markAsRead();
        return $this->list();
    }

    public function markAllRead()
    {
        /** @var User $user */
        $user = User::all()->first();
        $user->unReadNotifications()->update(['read_at' => Carbon::now()]);
        return $this->list();
    }

    public function status()
    {
        $settings = Settings::getGroup('notification');
        return $settings;
    }

    public function enable()
    {
        Settings::set('notification.enabled', true);
        Settings::set('notification.paused', false);
        Settings::set('notification.unpause_at', null);
        \Log::debug('Enabling notifications');
        return $this->status();
    }

    public function disable()
    {
        Settings::set('notification.enabled', false);
        Settings::set('notification.paused', false);
        Settings::set('notification.unpause_at', null);
        \Log::debug('Disabling notifications');

        return $this->status();
    }

    public function pause($duration = 60)
    {
        Settings::set('notification.enabled', false);
        Settings::set('notification.paused', true);
        Settings::set('notification.paused_duration', $duration);
        Settings::set('notification.unpause_at', Carbon::now()->addMinutes($duration));
        \Log::debug('Pausing for ' . $duration . ' minutes, resuming at ' . Carbon::now()->addMinutes($duration)
                                                                                  ->toIso8601String());
        return $this->status();
    }
}
