<?php
require 'autoload.php';
use Redbox\Distance;

/**
 * In this example we will calculate the distance between Amsterdam and Rotterdam (the Netherlands)
 * as Miles and display them to the user of the script.
 */
$p1 = new Distance\GeoPoint(52.364533, 4.820374); /* Amsterdam */
$p2 = new Distance\GeoPoint(51.925538, 4.471867); /* Rotterdam */

$tool = new Distance\CalculateDistance();
$distance = $tool->setSource($p1)
                 ->setDestination($p2)
                 ->setUseSslVerifier(false)
                 ->getDistanceInMiles();

echo "<h2>Distance in Kilometer</h2>";
echo '<a href="index.php">Back to index</a><br><br />';
echo 'The calculated distance is: '.$distance.' Miles<br>';

