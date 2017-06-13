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
        Settings::create(['key' => 'phone.ip', 'value' => 'squigg.servegame.com']);
        Settings::create(['key' => 'phone.port', 'value' => '17067', 'type' => 'int']);
        Settings::create(['key' => 'notification.enabled', 'value' => '1', 'type' => 'bool']);
        Settings::create(['key' => 'notification.paused', 'value' => '0', 'type' => 'bool']);
        Settings::create(['key' => 'notification.paused_duration', 'value' => '60', 'type' => 'int']);
        Settings::create(['key' => 'notification.unpause_at', 'value' => null, 'type' => 'date']);
    }
}
