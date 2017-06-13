<?php

namespace App\Http\Controllers;

use App\Settings;
use Carbon\Carbon;

class NotificationController extends Controller
{

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
        return $this->status();
    }

    public function disable()
    {
        Settings::set('notification.enabled', false);
        Settings::set('notification.paused', false);
        Settings::set('notification.unpause_at', null);
        return $this->status();
    }

    public function pause($duration = 60)
    {
        Settings::set('notification.enabled', false);
        Settings::set('notification.paused', true);
        Settings::set('notification.paused_duration', $duration);
        Settings::set('notification.unpause_at', Carbon::now()->addMinutes($duration));
        \Log::debug('Pausing for ' . $duration . ' minutes, resuming at ' . Carbon::now()->addMinutes($duration)->toIso8601String());
        return $this->status();
    }
}
