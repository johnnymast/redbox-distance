[![Build Status](https://travis-ci.org/johnnymast/redbox-distance.svg?branch=master)](https://travis-ci.org/johnnymast/redbox-distance) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/johnnymast/redbox-distance/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/johnnymast/redbox-distance/?branch=master) 
[![Code Coverage](https://scrutinizer-ci.com/g/johnnymast/redbox-distance/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/johnnymast/redbox-distance/?branch=master)
[![GitHub stars](https://img.shields.io/badge/HHVM-Ready-green.svg)](http://hhvm.com/)
[![Twitter URL](https://img.shields.io/twitter/url/http/shields.io.svg?style=social&label=Contact%20author)](https://twitter.com/intent/tweet?text=@mastjohnny)

# Redbox-distance

This set of classes allow you to calculate the distance between Geo Locations or zipcodes. The information comes from the Google Maps API.

## Features

* Calculate the distance in
    * Kilometers
    * Miles
    * Yards
* Enable/Disable SSL Verifier
* Set Google MAPS API key (Optional, its not required at this date May 25th of 2015)

### Installing via Composer

Use [composer](http://getcomposer.org) to install this package. Run the Composer command to install the latest stable version of Redbox-distance:

```bash
composer require redbox/distance
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```


### System Requirements

This package only requires the following:

* Curl
* PHP >= 5.40

Dit will also require **PHPUnit** 4.6 but that will be installed upon installing the package using composer. 


### Examples

Lets calculate the distance between Amsterdam and Rotterdam (Netherlands) using GeoLocations:

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

Calculate the distance between Den Helder and Haarlem (Netherlands) using posalcodes:

    use Redbox\Distance;
    
    $p1 = new Distance\GeoZipCode('1781 GC'); /* Den Helder */
    $p2 = new Distance\GeoZipCode("2011 SR"); /* Haarlem */


    $tool = new Distance\CalculateDistance();
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

    $p1 = new GeoZipCode('1781 GC Netherlands'); /* Den Helder */


## Author

Redbox-distance is created and maintained by [Johnny Mast](mailto:mastjohnny@gmail.com). For feature requests and suggestions
you could consider sending me an e-mail.

## License

The MIT License

Copyright (c) 2017 Johnny Mast (mastjohnny@gmail.com)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
