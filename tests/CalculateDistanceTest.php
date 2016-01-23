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
     * Check if the Google API key will be set correctly.
     */
    public function test_if_get_set_google_api_key_works_correct()
    {
        $apiKey = '<my_google_key>';
        $tool = new Distance\CalculateDistance();
        $tool->setGoogleAPIkey($apiKey);

        $instance = new \ReflectionClass($tool);
        $property = $instance->getProperty('googleAPIkey');
        $property->setAccessible(true);

        $this->assertEquals($apiKey, $property->getValue($tool));
    }

    /**
     * Check if calculate distance will return null on failure.
     */
    public function test_if_calculate_distance_returns_null_on_fail()
    {
        $p1 = new Distance\GeoPoint(52.364533, 4.820374); /* Amsterdam */
        $p2 = new Distance\GeoPoint(51.925538, 4.471867); /* Rotterdam */

        $tool  =  new Distance\CalculateDistance;
        $tool->setApiUrl('http://idontexist/')
            ->setSource($p1)
            ->setDestination($p2);

        $method = new \ReflectionMethod($tool, 'calculateDistance');
        $method->setAccessible(true);

        $result = $method->invoke($tool);
        $this->assertNull($result);
    }

    /**
     * Check if getDistanceInMiles() returns -1 if it fails.
     */
    public function test_if_get_distance_in_miles_fails_correctly()
    {
        $p1 = new Distance\GeoPoint(52.364533, 4.820374); /* Amsterdam */
        $p2 = new Distance\GeoPoint(51.925538, 4.471867); /* Rotterdam */

        $tool   =  new Distance\CalculateDistance;
        $result = $tool->setApiUrl('http://idontexist/')
            ->setSource($p1)
            ->setDestination($p2)
            ->getDistanceInMiles();

        $this->assertEquals(-1, $result);
    }

    /**
     * Check if getDistanceInYards() returns -1 if it fails.
     */
    public function test_if_get_distance_in_yards_fails_correctly()
    {
        $p1 = new Distance\GeoPoint(52.364533, 4.820374); /* Amsterdam */
        $p2 = new Distance\GeoPoint(51.925538, 4.471867); /* Rotterdam */

        $tool   =  new Distance\CalculateDistance;
        $result = $tool->setApiUrl('http://idontexist/')
            ->setSource($p1)
            ->setDestination($p2)
            ->getDistanceInYards();

        $this->assertEquals(-1, $result);
    }

    /**
     * Check if getDistanceInKM() returns -1 if it fails.
     */
    public function test_if_get_distance_in_km_fails_correctly()
    {
        $p1 = new Distance\GeoPoint(52.364533, 4.820374); /* Amsterdam */
        $p2 = new Distance\GeoPoint(51.925538, 4.471867); /* Rotterdam */

        $tool   =  new Distance\CalculateDistance;
        $result = $tool->setApiUrl('http://idontexist/')
            ->setSource($p1)
            ->setDestination($p2)
            ->getDistanceInKM();

        $this->assertEquals(-1, $result);
    }

    /**
     * This test will make sure that getDistanceInKM() on CalculateDistance
     * will return the correct values.
     */
    public function test_the_basic_example_distance_in_km()
    {
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
    public function test_the_basic_example_distance_in_miles()
    {
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
    public function test_the_basic_example_distance_in_yards()
    {
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