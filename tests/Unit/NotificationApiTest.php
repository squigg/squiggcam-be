<?php

namespace Tests\Unit;

use App\Services\CameraService;
use Tests\TestCase;

class CameraServiceTest extends TestCase
{

    /**
     * @var CameraService
     */
    protected $cameraService;

    public function setUp()
    {
        parent::setUp();
        $this->cameraService = $this->app->make(CameraService::class);
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(CameraService::class, $this->cameraService);
    }

    /** @test */
    public function it_can_get_all_status_data()
    {
        $data = $this->cameraService->getStatus();
        $this->assertArrayHasKey('video_connections', $data);
        $this->assertArrayHasKey('audio_connections', $data);
        $this->assertArrayHasKey('video_status', $data);
        $this->assertArrayHasKey('curvals', $data);
    }

    /** @test */
    public function it_can_set_motion_sensitivity()
    {
        $this->cameraService->setMotionSensitivity(100);
        $this->assertEquals(100, $this->cameraService->getStatus()['curvals']['motion_limit']);
        $this->cameraService->setMotionSensitivity(250);
    }

    /** @test */
    public function it_can_set_motion_enabled()
    {
        $this->cameraService->setMotionDetection(false);
        $this->assertEquals('off', $this->cameraService->getStatus()['curvals']['motion_detect']);
        $this->cameraService->setMotionDetection(true);
        $this->assertEquals('on', $this->cameraService->getStatus()['curvals']['motion_detect']);
    }
}
