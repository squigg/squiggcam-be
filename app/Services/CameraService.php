<?php

namespace App\Services;

use App\Settings;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

/**
 * Created by PhpStorm.
 * User: squigg
 * Date: 12/06/17
 * Time: 20:48
 */
class CameraService
{

    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * CameraService constructor.
     */
    public function __construct()
    {
        $baseUrl = 'https://' . Settings::get('phone.ip') . ':' . Settings::get('phone.port') . '/';
        $username = env('SQUIGGCAM_USERNAME');
        $password = env('SQUIGGCAM_PASSWORD');
        $config = ['base_uri' => $baseUrl, 'auth' => [$username, $password]];
        $this->client = new Client($config);
    }

    /**
     *  Get the filename of the video currently being recorded
     * @return string|null
     */
    public function getCurrentMotionFilename()
    {
        $data = $this->makeRequest('get', 'videostatus');
        $filename = $data['fname'] ?? null;
        return $filename;
    }

    /**
     * @param $method
     * @param $uri
     * @param array $data
     * @param bool $asJson
     * @return array|StreamInterface|string
     */
    protected function makeRequest($method, $uri, $data = [], $asJson = true)
    {
        try {
            $response = $this->client->request($method, $uri, ['json' => $data]);
            $response->getBody()->getContents();
            return ($asJson) ? json_decode($response->getBody(), true) : $response->getBody();
        } catch (GuzzleException $e) {
            throw new ServiceUnavailableHttpException(null, $e->getMessage(), $e);
        }
    }

    public function getStatus()
    {
        $data = $this->makeRequest('get', 'status.json');
        return $data;
    }

    public function setMotionSensitivity(int $limit = 250)
    {
        $data = $this->makeRequest('get', 'settings/motion_limit?set=' . $limit, [], false);
        return $data;
    }

    public function setMotionDetection(bool $enabled = true)
    {
        $param = $enabled ? 'on' : 'off';
        $data = $this->makeRequest('get', 'settings/motion_detect?set=' . $param, [], false);
        return $data;
    }

}
