<?php
require '../vendor/autoload.php';
use Redbox\Distance;

$p1 = new Distance\GeoPoint(52.364533, 4.820374); /* Amsterdam */
$p2 = new Distance\GeoPoint(51.925538, 4.471867); /* Rotterdam */

$tool = new Distance\CalculateDistance();
$distance = $tool->setSource($p1)
                 ->setDestination($p2)
                 ->setUseSslVerifier(false)
                 ->getDistanceInKM();

echo "<h2>Example 1</h2><br>";
echo 'The calculated distance is: '.$distance.' KM<br>';

$p1 = new Distance\GeoZipCode('1781 GC'); /* Den Helder */
$p2 = new Distance\GeoZipCode("2011 SR"); /* Haarlem */


$tool = new Distance\CalculateDistance();
$distance = $tool->setSource($p1)
                 ->setDestination($p2)
                 ->setUseSslVerifier(false)
                 ->getDistanceInKM();

echo "<h2>Example 2</h2><br>";
echo 'The calculated distance is: '.$distance.' KM';
