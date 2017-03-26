<?php

namespace Whereissat\Service;

use GuzzleHttp;
use Whereissat\Coordinate;

final class WheretheissatApi
{
    /** @var \GuzzleHttp\Client */
    private $http;

    /**
     * WheretheissatApi constructor.
     *
     * @param \GuzzleHttp\Client $http
     */
    public function __construct(GuzzleHttp\Client $http)
    {
        $this->http = $http;
    }

    /**
     * Return current coordinates of the Internation Space Station
     *
     * @return Coordinate
     *
     * @throws \Exception
     */
    public function getCoordinates()
    {
        $locationRequest = new GuzzleHttp\Psr7\Request('GET', 'https://api.wheretheiss.at/v1/satellites/25544');
        $locationResponse = $this->http->send($locationRequest);
        $contents = $locationResponse->getBody()->getContents();
        $location = json_decode($contents);

        if (!isset($location->latitude) || !isset($location->longitude)) {
            throw new \Exception('Cannot get ISS localtion');
        }

        $coordinates = new Coordinate([
            'latitude' => $location->latitude,
            'longitude' => $location->longitude
        ]);

        return $coordinates;
    }
}