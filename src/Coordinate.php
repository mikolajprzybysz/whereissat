<?php

namespace Whereissat;

class Coordinate
{
    /** @var string */
    private $latitude;

    /** @var string */
    private $longitude;

    /**
     * Coordinate constructor.
     *
     * @param array $data latitude and longitude must be present in the float format
     */
    public function __construct($data = [])
    {
        if (!isset($data['latitude']) || !isset($data['longitude'])){
            throw new \InvalidArgumentException('Latitude and longitude must be provided!');
        }

        $this->latitude = (string) $data['latitude'];
        $this->longitude = (string) $data['longitude'];
    }

    /**
     * Returns latitude of the coordinates
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Returns longitude of the coordinates
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}