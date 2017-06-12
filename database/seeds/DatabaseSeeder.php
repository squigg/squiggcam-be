<?php

use App\Settings;
use App\User;
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
        User::firstOrCreate(['name'     => 'Default',
                             'email'    => 'squiggcam@squigg.co.uk',
                             'password' => bcrypt('39847hb2n9028cy')
        ]);
        Settings::set('phone.ip', 'squigg.servegame.com');
        Settings::set('phone.port', '17067');
        Settings::set('notification.enabled', 1);
        Settings::set('notification.paused', 0);
        Settings::set('notification.paused_duration', 60);
        Settings::set('notification.unpause_at', null);
    }
}
