<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\DatabaseChannel;
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
     * @var boolean
     */
    protected $shouldReport;

    /**
     * Create a new notification instance.
     *
     * @param $filename
     * @param $timestamp
     * @param bool $shouldReport
     */
    public function __construct($filename, $timestamp, $shouldReport = true)
    {
        $this->timestamp = $timestamp;
        $this->filename = $filename;
        $this->url = 'https://squigg.servegame.com/squiggcam/' . $filename;
        $this->shouldReport = $shouldReport;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = [DatabaseChannel::class];
        if ($this->shouldReport) {
            array_push($channels, PushoverChannel::class);
        }
        return $channels;
    }

    /**
     * @param $notifiable
     * @return mixed
     */
    public function toPushover($notifiable)
    {
        \Log::debug('Sending Pushover notification with URL ' . $this->url);
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
