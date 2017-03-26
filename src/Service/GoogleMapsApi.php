<?php

namespace Whereissat\Service;

use GuzzleHttp;
use Whereissat\Coordinate;

/**
 * Class GoogleMapsApi
 *
 *
 */
final class GoogleMapsApi
{
    /** @var \GuzzleHttp\Client  */
    private $http;

    /** @var string */
    private $key;

    /**
     * GoogleMapsApi constructor.
     *
     * @param \GuzzleHttp\Client $http
     * @param string $key
     */
    public function __construct(GuzzleHttp\Client $http, $key)
    {
        $this->http = $http;
        $this->key = $key;
    }

    /**
     * Reverse latitude and longitude into a readable address
     * More about results here:
     * https://developers.google.com/maps/documentation/geocoding/intro
     *
     * @param Coordinate $coordinate
     *
     * @return array
     */
    public function reverseLatLng(Coordinate $coordinate)
    {
        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$coordinate->getLatitude()},{$coordinate->getLongitude()}&key={$this->key}";
        $placeRequest = new GuzzleHttp\Psr7\Request('GET', $url);
        $placeResponse = $this->http->send($placeRequest);
        $contents = $placeResponse->getBody()->getContents();
        $result = json_decode($contents, true);

        return $result;
    }
}