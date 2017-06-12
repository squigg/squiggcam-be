<?php

namespace App\Services;

use App\Settings;
use GuzzleHttp\Client;

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
     * @return array
     */
    protected function makeRequest($method, $uri, $data = [])
    {
        $response = $this->client->request($method, $uri, ['json' => $data]);
        $response->getBody()->getContents();
        return json_decode($response->getBody(), true);
    }

}
