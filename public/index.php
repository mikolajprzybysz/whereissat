<?php

ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

use Whereissat\Service;

$client = new GuzzleHttp\Client();
$iss = new Service\WheretheissatApi($client);

$apikey = filter_var(getenv('GOOGLE_MAPS_API_KEY'), FILTER_SANITIZE_STRING);
$maps = new Service\GoogleMapsApi($client, $apikey);

# I have implemented caching, however for portability between servers lets just run null adapter
$cache = new \Symfony\Component\Cache\Adapter\NullAdapter();
$view = new \Whereissat\View();

$whereiss = new \Whereissat\Whereissat($iss, $maps, $cache, $view);
$whereiss->run();
