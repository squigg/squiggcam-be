<?php

namespace App\Console\Commands;

use App\Settings;
use Illuminate\Console\Command;

class ChangeSetting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'squiggcam:setting {setting} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set a setting to a value';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Settings::set($this->argument('setting'), $this->argument('value'));
    }
}
