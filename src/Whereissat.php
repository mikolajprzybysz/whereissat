<?php

namespace Whereissat;

use Symfony\Component\Cache\Adapter\AdapterInterface;

final class Whereissat
{
    const CACHE_KEY_COORDINATES = 'coordinates';
    const CACHE_KEY_RESULT = 'result';
    const CACHE_TTL = 1;

    /** @var Service\WheretheissatApi */
    private $iss;

    /** @var Service\GoogleMapsApi */
    private $maps;

    /** @var AdapterInterface */
    private $cache;

    /** @var View */
    private $view;

    /**
     * Whereissat constructor.
     *
     * @param Service\WheretheissatApi $iss
     * @param Service\GoogleMapsApi $maps
     * @param AdapterInterface $cache
     * @param View $view
     */
    public function __construct(
        Service\WheretheissatApi $iss,
        Service\GoogleMapsApi $maps,
        AdapterInterface $cache,
        View $view
    )
    {
        $this->maps = $maps;
        $this->iss = $iss;
        $this->cache = $cache;
        $this->view = $view;
    }

    public function run()
    {
        try {

            $cacheItem = $this->cache->getItem(self::CACHE_KEY_COORDINATES);
            if(!$cacheItem->isHit()) {
                $coordinates = $this->iss->getCoordinates();

                $cacheItem->set($coordinates);
                $cacheItem->expiresAfter(self::CACHE_TTL);

                $this->cache->save($cacheItem);
            }
            $coordinates = $cacheItem->get();

            $cacheItem = $this->cache->getItem(self::CACHE_KEY_RESULT);
            if(!$cacheItem->isHit()) {
                $result = $this->maps->reverseLatLng($coordinates);

                $cacheItem->set($result);
                $cacheItem->expiresAfter(self::CACHE_TTL);

                $this->cache->save($cacheItem);
            }
            $result = $cacheItem->get();

        } catch(\Exception $e) {
            error_log($e->getMessage());
            error_log($e->getTraceAsString());

            $result['status'] = 'exception';
        }

        switch($result['status']){
            case 'OK' :
                $address = $result['results'][0]['formatted_address'];
                $this->view->ok($address);
                break;
            case 'ZERO_RESULTS':
                $maps_url = "https://www.google.pl/maps/search/{$coordinates->getLatitude()},{$coordinates->getLongitude()}";
                $this->view->zero_result($maps_url);
                break;
            default:
                $this->view->defaultView();
                break;
        }


    }
}