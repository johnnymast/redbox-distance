<?php
namespace Redbox\Distance\Tests;
use Redbox\Distance;

/**
 * @package Redbox\Distance\Tests
 * @coversDefaultClass  \Redbox\Distance\CalculateDistance
 */
class CalculateDistanceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * This test will make sure that getSource() on CalculateDistance
     * returns the set value via setSource(). In this test we try the GeoPoint.
     */
    public function test_setsource_returns_set_source_geopoint() {
        $distance = new Distance\CalculateDistance();
        $geopoint = new Distance\GeoPoint(52.364533, 4.820374); /* Amsterdam */

        $distance->setSource($geopoint);
        $this->assertEquals($distance->getSource(), $geopoint);
    }

    /**
     * This test will make sure that getSource() on CalculateDistance
     * returns the set value via setSource(). In this test we try the GeoZipCode.
     */
    public function test_setsource_returns_set_source_geozipcode() {
        $distance = new Distance\CalculateDistance();
        $geozip = new Distance\GeoZipCode('CA 94105'); /* Amsterdam */

        $distance->setSource($geopoint);
        $this->assertEquals($distance->getSource(), $geozip);
    }

}