<?php
require 'autoload.php';
use Redbox\Distance;

$p1 = new Distance\GeoPoint(52.364533, 4.820374); /* Amsterdam */
$p2 = new Distance\GeoPoint(51.925538, 4.471867); /* Rotterdam */

$tool = new Distance\CalculateDistance();
$distance = $tool->setSource($p1)
                 ->setDestination($p2)
                 ->setUseSslVerifier(false)
                 ->getDistanceInYards();

echo "<h2>Distance in Yards</h2>";
echo '<a href="index.php">Back to index</a><br><br />';
echo 'The calculated distance is: '.$distance.' Yards<br>';

