<?php
namespace Redbox\Distance;

/**
 *
 * @package   CalculateDistance
 * @author    Johnny Mast <mastjohnny@gmail.com>
 * @license   https://github.com/johnnymast/CalculateDistance/blob/master/LICENSE.txt MIT
 * @link      https://github.com/johnnymast/CalculateDistance
 */
class GeoPoint {
    protected $_lat;
    protected $_long;

    /**
     * Return the latitued
     * @return mixed
     */
    public function getLat()
    {
        return $this->_lat;
    }

    /**
     * Return the longtitude
     * @return mixed
     */
    public function getLong()
    {
        return $this->_long;
    }

    /**
     * Constuctor of the class taking the lat and long
     * @param string $lat
     * @param string $long
     */
    public function __construct($lat="", $long="") {
        $this->_lat  = $lat;
        $this->_long = $long;
    }

    /**
     * Return the GeoPoint as string
     * @return string
     */
    public function __toString() {
        return $this->_lat.','.$this->_long;
    }
}