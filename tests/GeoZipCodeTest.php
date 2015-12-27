<?php
namespace Redbox\Distance\Tests;
use Redbox\Distance;

/**
 * @package Redbox\Distance\Tests
 * @coversDefaultClass  \Redbox\Distance\GeoZipCode
 */
class GeoZipCode extends \PHPUnit_Framework_TestCase
{
    /**
     * This test will make sure that getLat() on the GeoPoint
     * returns the constructed latitude.
     */
    public function test_tostring_returns_the_constructed_zipcode() {
        $GeoZip = new Distance\GeoZipCode('CA 94105');
        $this->assertEquals($Gels
        oZip, 'CA 94105');
    }
}