<?php
require 'includes/config.php';
use DistanceTools\CalculateDistance;



$p1 = new DistanceTools\GeoPoint(52.364533, 4.820374); /* Amsterdam */
$p2 = new DistanceTools\GeoPoint(51.925538, 4.471867); /* Rotterdam */


$tool = new CalculateDistance();
$distance = $tool->setSource($p1)
                 ->setDestination($p2)
                 ->setUseSslVerifier(false)
                 ->getDistanceInKM();

echo "<h2>Example 1</h2><br>";
echo 'The calculated distance is: '.$distance.' KM<br>';

$p1 = new DistanceTools\GeoZipCode('1781 GC'); /* Den Helder */
$p2 = new DistanceTools\GeoZipCode("2011 SR"); /* Haarlem */


$tool = new CalculateDistance();
$distance = $tool->setSource($p1)
                 ->setDestination($p2)
                 ->setUseSslVerifier(false)
                 ->getDistanceInKM();

echo "<h2>Example 2</h2><br>";
echo 'The calculated distance is: '.$distance.' KM';

?>
