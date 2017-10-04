<?php

namespace App\Http\Controllers;

use App\Services\CameraService;

class CameraController extends Controller
{

    /**
     * @var CameraService
     */
    protected $cameraService;

    /**
     * CameraController constructor.
     * @param CameraService $cameraService
     */
    public function __construct(CameraService $cameraService)
    {
        $this->cameraService = $cameraService;
    }

    public function status()
    {
        return $this->cameraService->getStatus();
    }

    public function enableMotion()
    {
        $this->cameraService->setMotionDetection(false);
        return ['message' => 'Motion sensing enabled'];
    }

    public function disableMotion()
    {
        $this->cameraService->setMotionDetection(true);
        return ['message' => 'Motion sensing disabled'];
    }

}
