<?php

namespace App\Http\Controllers;

use App\Events\MotionDetected;
use App\Services\CameraService;
use Illuminate\Http\Request;

class EventController extends Controller
{

    protected $cameraService;

    /**
     * EventController constructor.
     * @param $cameraService
     */
    public function __construct(CameraService $cameraService)
    {
        $this->cameraService = $cameraService;
    }

    public function motion(Request $request)
    {
        \Log::debug('Motion POST request received');
        $filename = $this->cameraService->getCurrentMotionFilename();
        str_replace('/modet/', '', $filename);
        \Log::debug('Motion Filename is ' . $filename);
        event(new MotionDetected($filename));
    }
}
