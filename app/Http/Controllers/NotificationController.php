<?php

namespace App\Http\Controllers;

use App\Settings;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function status()
    {
        $settings = Settings::getGroup('notification');
        return $settings;
    }
}
