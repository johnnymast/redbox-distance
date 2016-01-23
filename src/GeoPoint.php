<?php
namespace Redbox\Distance;

class GeoPoint
{
    /**
     * @var string
     */
    protected $lat;

    /**
     * @var string
     */
    protected $long;

    /**
     * Return the latitude
     *
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Return the longitude
     *
     * @return mixed
     */
    public function getLong()
    {
        return $this->long;
    }

    /**
     * Constructor of the class taking the lat and long
     *
     * @param string $lat
     * @param string $long
     */
    public function __construct($lat = "", $long = "")
    {
        $this->lat  = $lat;
        $this->long = $long;
    }

    /**
     * Return the GeoPoint as string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->lat.','.$this->long;
    }
}