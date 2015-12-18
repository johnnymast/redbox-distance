[![Build Status](https://travis-ci.org/johnnymast/redbox-distance.svg?branch=master)](https://travis-ci.org/johnnymast/redbox-distance) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/johnnymast/redbox-distance/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/johnnymast/redbox-distance/?branch=master)

# Redbox-distance

This set of classes allow you to calculate the distance between 2 Geo Locations or zipcodes. This information comes from the Google Maps API.

## Features

* Calculate the distance in
    * Kilometers
    * Miles
    * Yards
* Enable/Disable SSL Verifier
* Set Google MAPS API key (Optional, its not required at this date May 25th of 2015)

### Installing via Composer

Use the following command to install this package with composer
[Composer](http://getcomposer.org).

Run the Composer command to install the latest stable version of CalculateDistance:

```bash
composer.phar require johnnymast/calculate-distance
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```


### System Requirements

You need the curl extention to communicate with the Google Maps API Servers.


### Examples

Lets calculate the distance between Amsterdam and Rotterdam (Netherlands) using GeoLocations:

    $p1 = new DistanceTools\GeoPoint(52.364533, 4.820374); /* Amsterdam */
    $p2 = new DistanceTools\GeoPoint(51.925538, 4.471867); /* Rotterdam */


    $tool = new CalculateDistance();
    $distance = $tool->setSource($p1)
                     ->setDestination($p2)
                     ->setUseSslVerifier(false)
                     ->getDistanceInKM();

    echo "<h2>Example 1</h2><br>";
    echo 'The calculated distance is: '.$distance.' KM<br>';

Calculate the distance between Den Helder and Haarlem (Netherlands) using posalcodes:

    $p1 = new DistanceTools\GeoZipCode('1781 GC'); /* Den Helder */
    $p2 = new DistanceTools\GeoZipCode("2011 SR"); /* Haarlem */


    $tool = new CalculateDistance();
    $distance = $tool->setSource($p1)
                     ->setDestination($p2)
                     ->setUseSslVerifier(false)
                     ->getDistanceInKM();

    echo "<h2>Example 2</h2><br>";
    echo 'The calculated distance is: '.$distance.' KM';

Other available calculations are:

    $distance->getDistanceInMiles();

and

    $distance->getDistanceInYards();




## Troubleshooting

If you get an error regarding SSL connectivity you might want to disable verify peer (CURLOPT_SSL_VERIFYPEER). The calculateDistance class offers
a method to disable this. Consider using the setUseSslVerifier() method if needed like so.

    $distance = $tool->setSource($p1)
                     ...
                     ->setUseSslVerifier(false)
                     ...


Sometimes the postalcode feature could return wrong results. To battle this also add the country to the postalcode like so.

    $p1 = new DistanceTools\GeoZipCode('1781 GC Netherlands'); /* Den Helder */


## Author

Redbox-distance is created and maintained by [Johnny Mast](mastjohnny@gmail.com). For feature requests and suggestions
you could consider sending me an e-mail.

## License

Redbox-distance is released under the MIT public license.

<https://github.com/johnnymast/redbox-distance/blob/master/LICENSE>