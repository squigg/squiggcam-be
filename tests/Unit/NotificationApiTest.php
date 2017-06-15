<?php

namespace Tests\Unit;

use App\Notifications\MotionDetected;
use App\Settings;
use App\User;
use Carbon\Carbon;
use Tests\DatabaseTestCase;

class NotificationApiTest extends DatabaseTestCase
{


    /** @test */
    public function it_can_get_notification_status()
    {
        $response = $this->json('get', '/api/notification/status');
        $response->assertStatus(200)->assertJson([
            'enabled'         => true,
            'paused'          => false,
            'paused_duration' => 60,
            'unpause_at'      => null,
        ]);
    }

    /** @test */
    public function it_can_get_notification_status_with_date()
    {
        $now = Carbon::now();
        Settings::set('notification.unpause_at', $now);

        $response = $this->json('get', '/api/notification/status');
        $response->assertStatus(200)->assertJson([
            'unpause_at' => $now->toIso8601String(),
        ]);
    }

    /** @test */
    public function it_can_disable_notifications()
    {
        $this->assertTrue(Settings::get('notification.enabled'));

        $response = $this->json('post', '/api/notification/disable');
        $response->assertStatus(200);

        $this->assertFalse(Settings::get('notification.enabled'));
    }

    /** @test */
    public function it_can_enable_notifications()
    {
        Settings::set('notification.enabled', false);
        $this->assertFalse(Settings::get('notification.enabled'));

        $response = $this->json('post', '/api/notification/enable');
        $response->assertStatus(200);

        $this->assertTrue(Settings::get('notification.enabled'));
    }

    /** @test */
    public function it_can_pause_notifications()
    {
        $this->assertTrue(Settings::get('notification.enabled'));

        $now = Carbon::now();
        $response = $this->json('post', '/api/notification/pause/30');
        $response->assertStatus(200);

        $this->assertFalse(Settings::get('notification.enabled'));
        $this->assertTrue(Settings::get('notification.paused'));
        $this->assertEquals(30, Settings::get('notification.paused_duration'));

        $unpause = Carbon::parse(Settings::get('notification.unpause_at'));
        $this->assertLessThanOrEqual(3, $now->addMinutes(30)->diffInSeconds($unpause));

    }

    /**
     * @param int $count
     * @return Carbon
     */
    protected function createNotifications($count = 1)
    {

        $user = User::first();
        $now = Carbon::now();

        for ($i = 1; $i <= $count; $i++) {
            $notification = new MotionDetected('test' . $i . '.mkv', $now->subMinutes(30 * $i), false);
            $user->notify($notification);
        }
        $this->assertCount($count, $user->notifications);

        return $now->addMinutes(30 * $i);
    }

    /** @test */
    public function it_can_get_list_of_notifications()
    {
        $now = $this->createNotifications(2);

        $response = $this->json('get', '/api/notification/list');
        $response->assertStatus(200);

        $notifications = $response->json();
        $this->assertCount(2, $notifications);

        $response->assertJsonFragment(['filename'  => 'test1.mkv',
                                       'timestamp' => $now->subMinutes(30)->toIso8601String()
        ]);
        $response->assertJsonFragment(['filename'  => 'test2.mkv',
                                       'timestamp' => $now->subMinutes(60)->toIso8601String()
        ]);

    }


    /** @test */
    public function it_can_get_list_of_only_unread_notifications()
    {
        $this->createNotifications(3);
        $notification = User::first()->notifications->first();
        $notification->markAsRead();

        $response = $this->json('get', '/api/notification/list/unread');
        $response->assertStatus(200);

        $notifications = $response->json();
        $this->assertCount(2, $notifications);

    }

    /** @test */
    public function it_can_get_unread_count_for_notifications()
    {
        $this->createNotifications(2);

        $response = $this->json('get', '/api/notification/unread');
        $response->assertStatus(200);

        $this->assertEquals(2, $response->json());
    }

    /** @test */
    public function it_can_mark_notification_as_read()
    {
        $this->createNotifications(2);
        $notification = User::first()->notifications->first();
        $id = $notification->id;

        $response = $this->json('get', '/api/notification/' . $id . '/read');
        $response->assertStatus(200);

        $this->assertCount(2, $response->json());
        $readNotification = array_first(array_where($response->json(), function ($value) use ($id) {
            return $value['id'] == $id;
        }));
        $unreadNotification = array_first(array_where($response->json(), function ($value) use ($id) {
            return $value['id'] != $id;
        }));

        $this->assertNotNull($readNotification['read_at']);
        $this->assertNull($unreadNotification['read_at']);
    }

    /** @test */
    public function it_can_mark_all_notifications_as_read()
    {
        $this->createNotifications(2);

        $response = $this->json('get', '/api/notification/read');
        $response->assertStatus(200);

        $response->assertJsonMissing(['read_at' => null]);
    }
}
