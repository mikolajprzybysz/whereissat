<?php

ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp;

$client = new GuzzleHttp\Client();

$locationRequest = new GuzzleHttp\Psr7\Request('GET', 'https://api.wheretheiss.at/v1/satellites/25544');

$locationResponse = $client->send($locationRequest);
$contents = $locationResponse->getBody()->getContents();
$location = json_decode($contents);

$latitude = (float) $location->latitude;
$longitude = (float) $location->longitude;

$apikey = filter_var($_ENV['GOOGLE_MAPS_API_KEY'], FILTER_SANITIZE_STRING);

$url = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude=&key=$apikey";
$placeRequest = new GuzzleHttp\Psr7\Request('GET', $url);
$placeResponse = $client->send($placeRequest);
$contents = $placeResponse->getBody()->getContents();
$place = json_decode($contents, true);
//$address = $place['results'][0]['formatted_address'];
//echo "Currently ISS is over $address";
header('Content-type: text/javascript');
var_dump($latitude, $longitude);
echo json_encode($place, JSON_PRETTY_PRINT);
