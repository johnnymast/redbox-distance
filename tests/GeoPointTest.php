<?php
namespace Redbox\Distance\Tests;
use Redbox\Distance;

/**
 * @package Redbox\Distance\Tests
 * @coversDefaultClass       \Redbox\Distance\GeoPoint
 */
class GeoPointTest extends \PHPUnit_Framework_TestCase
{
    /**
     * This test will make sure that getLat() on the GeoPoint
     * returns the constructed latitude.
     */
    public function test_getlat_should_return_constructed_latitude_value() {
        $geoPoint = new Distance\GeoPoint(52.364533, 4.820374);
        $this->assertEquals($geoPoint->getLat(), 52.364533);
    }

    /**
     * This test will make sure that getLong() on the GeoPoint
     * returns the constructed longitude.
     */
    public function test_getlat_should_return_constructed_longitude_value() {
        $geoPoint = new Distance\GeoPoint(52.364533, 4.820374);
        $this->assertEquals($geoPoint->getLong(), 4.820374);
    }
}