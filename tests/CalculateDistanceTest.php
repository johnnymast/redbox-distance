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
     * This test will make sure that getDistanceInKM() on CalculateDistance
     * will return the correct values.
     */
    public function test_the_basic_example_distance_in_km() {
        $p1 = new Distance\GeoPoint(52.364533, 4.820374); /* Amsterdam */
        $p2 = new Distance\GeoPoint(51.925538, 4.471867); /* Rotterdam */

        $tool = new Distance\CalculateDistance();
        $distance = $tool->setSource($p1)
            ->setDestination($p2)
            ->setUseSslVerifier(false)
            ->getDistanceInKM();

        $this->assertEquals($distance, 70);
    }

    /**
     * This test will make sure that getDistanceInMiles() on CalculateDistance
     * will return the correct values.
     */
    public function test_the_basic_example_distance_in_miles() {
        $p1 = new Distance\GeoPoint(52.364533, 4.820374); /* Amsterdam */
        $p2 = new Distance\GeoPoint(51.925538, 4.471867); /* Rotterdam */

        $tool = new Distance\CalculateDistance();
        $distance = $tool->setSource($p1)
            ->setDestination($p2)
            ->setUseSslVerifier(false)
            ->getDistanceInMiles();

        $this->assertEquals($distance, 43.4959);
    }

    /**
     * This test will make sure that getDistanceInYards() on CalculateDistance
     * will return the correct values.
     */
    public function test_the_basic_example_distance_in_yards() {
        $p1 = new Distance\GeoPoint(52.364533, 4.820374); /* Amsterdam */
        $p2 = new Distance\GeoPoint(51.925538, 4.471867); /* Rotterdam */

        $tool = new Distance\CalculateDistance();
        $distance = $tool->setSource($p1)
            ->setDestination($p2)
            ->setUseSslVerifier(false)
            ->getDistanceInYards();

        $this->assertEquals($distance, 76552.931);
    }

}