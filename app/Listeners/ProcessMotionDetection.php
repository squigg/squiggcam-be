<?php

namespace App\Listeners;

use App\Events\MotionDetected;
use App\Notifications\MotionDetected as MotionDetectedNotification;
use App\User;
use Carbon\Carbon;

class ProcessMotionDetection
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MotionDetected $event
     * @return void
     */
    public function handle(MotionDetected $event)
    {
        /** @var User $user */
        $user = User::first();
        $user->notify(new MotionDetectedNotification($event->filename, Carbon::now()));
    }
}
