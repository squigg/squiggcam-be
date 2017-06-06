<?php

namespace App\Http\Controllers;

use App\Events\MotionDetected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{

    public function motion(Request $request)
    {
        Log::debug('Motion POST request received');

        //$filename = $this->cameraService->getMotionFilename();
        event(new MotionDetected(''));
    }
}
