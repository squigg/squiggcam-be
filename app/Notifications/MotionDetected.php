<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Pushover\PushoverChannel;
use NotificationChannels\Pushover\PushoverMessage;

class MotionDetected extends Notification
{

    use Queueable;
    /**
     * @var Carbon
     */
    protected $timestamp;
    /**
     * @var string
     */
    protected $url;
    /**
     * @var string
     */
    protected $filename;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($filename, $timestamp)
    {
        $this->timestamp = $timestamp;
        $this->filename = $filename;
        $this->url = 'https://squigg.servegame.com/squiggcam/' . $filename;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [PushoverChannel::class];
    }

    /**
     * @param $notifiable
     * @return mixed
     */
    public function toPushover($notifiable)
    {
        return PushoverMessage::create('New motion detected')->title('Motion Detected')->url($this->url, 'View video');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'timestamp' => $this->timestamp->toFormattedDateString(),
            'url'       => $this->url,
            'filename'  => $this->filename,
        ];
    }
}
