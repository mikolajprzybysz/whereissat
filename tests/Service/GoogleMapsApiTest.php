<?php

namespace Whereissat\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\StreamInterface;
use Whereissat\Coordinate;

class GoogleMapsApiTest extends \PHPUnit_Framework_TestCase
{

    public function testReverseLatLng()
    {
        $expected = ['sample' => 'value'];

        $key = 'sample api key';
        $coordinate = new Coordinate([
            'latitude' => 1.321,
            'longitude' => 2.12
        ]);

        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$coordinate->getLatitude()},{$coordinate->getLongitude()}&key=$key";
        $request = new Request('GET', $url);

        $body = $this->getMockBuilder(StreamInterface::class)->disableOriginalConstructor()->getMock();
        $body->expects($this->at(0))->method('getContents')
            ->will($this->returnValue(json_encode($expected)));

        $response = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $response->expects($this->at(0))->method('getBody')
            ->will($this->returnValue($body));

        $http = $this->getMockBuilder(Client::class)->disableOriginalConstructor()->getMock();
        $http->expects($this->at(0))->method('send')
            ->with($request)
            ->will($this->returnValue($response));

        /** @var \GuzzleHttp\Client $http */
        $api = new GoogleMapsApi($http, $key);
        $result = $api->reverseLatLng($coordinate);

        $this->assertEquals($expected, $result);
    }

    public function testReverseLatLng404()
    {
        $expected = null;

        $key = 'sample api key';
        $coordinate = new Coordinate([
            'latitude' => 1.321,
            'longitude' => 2.12
        ]);

        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$coordinate->getLatitude()},{$coordinate->getLongitude()}&key=$key";
        $request = new Request('GET', $url);

        $body = $this->getMockBuilder(StreamInterface::class)->disableOriginalConstructor()->getMock();
        $body->expects($this->at(0))->method('getContents')
            ->will($this->returnValue($expected));

        $response = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $response->expects($this->at(0))->method('getBody')
            ->will($this->returnValue($body));

        $http = $this->getMockBuilder(Client::class)->disableOriginalConstructor()->getMock();
        $http->expects($this->at(0))->method('send')
            ->with($request)
            ->will($this->returnValue($response));

        /** @var \GuzzleHttp\Client $http */
        $api = new GoogleMapsApi($http, $key);
        $result = $api->reverseLatLng($coordinate);

        $this->assertEquals($expected, $result);
    }
}