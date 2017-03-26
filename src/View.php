<?php

namespace Whereissat;

final class View
{
    /**
     * Present view in case result is ok
     *
     * @param $address
     *
     * @return void
     */
    public function ok($address)
    {
        echo "Currently ISS is over $address";
    }

    /**
     * Present view in case result is zero_result
     *
     * @param $maps_url
     *
     * @return void
     */
    public function zero_result($maps_url)
    {
        echo "Service cannot resolve the place, but you can look it up on the map through <a href=\"$maps_url\">this link</a>";
    }

    /**
     * Present view in case other results
     *
     * @return void
     */
    public function defaultView()
    {
        echo 'Service encountered an error, please try again in a second.';
    }
}