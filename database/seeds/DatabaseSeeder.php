<?php

use App\Settings;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::set('phone.ip', '192.168.1.121');
        Settings::set('phone.port', '8080');
        Settings::set('notification.enabled', 1);
        Settings::set('notification.paused', 0);
        Settings::set('notification.paused_duration', 60);
        Settings::set('notification.unpause_at', null);
    }
}
