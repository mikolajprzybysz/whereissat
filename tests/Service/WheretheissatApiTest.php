<?php

namespace Whereissat\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\StreamInterface;
use Whereissat\Coordinate;

class WheretheissatApiTest extends \PHPUnit_Framework_TestCase
{

    public function testGetCoordinates()
    {
        $latitude = '1.123';
        $longitude = '2.321';

        $coordinate = ['latitude' => $latitude, 'longitude' => $longitude];

        $expected = new Coordinate([
            'latitude' => $latitude,
            'longitude' => $longitude
        ]);

        $url = "https://api.wheretheiss.at/v1/satellites/25544";
        $request = new Request('GET', $url);

        $body = $this->getMockBuilder(StreamInterface::class)->disableOriginalConstructor()->getMock();
        $body->expects($this->at(0))->method('getContents')
            ->will($this->returnValue(json_encode($coordinate)));

        $response = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $response->expects($this->at(0))->method('getBody')
            ->will($this->returnValue($body));

        $http = $this->getMockBuilder(Client::class)->disableOriginalConstructor()->getMock();
        $http->expects($this->at(0))->method('send')
            ->with($request)
            ->will($this->returnValue($response));

        /** @var \GuzzleHttp\Client $http */
        $api = new WheretheissatApi($http);
        $result = $api->getCoordinates();

        $this->assertEquals($expected, $result);
    }

    /**
     * Check if in case of unexpected response from the service exception is thrown
     *
     * @expectedException \Exception
     */
    public function testGetCoordinatesFail()
    {
        $expected = null;

        $url = "https://api.wheretheiss.at/v1/satellites/25544";
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
        $api = new WheretheissatApi($http);
        $api->getCoordinates();
    }
}