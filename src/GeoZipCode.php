<?php
namespace Redbox\Distance;

/**
 *
 * @package   CalculateDistance
 * @author    Johnny Mast <mastjohnny@gmail.com>
 * @license   https://github.com/johnnymast/CalculateDistance/blob/master/LICENSE.txt MIT
 * @link      https://github.com/johnnymast/CalculateDistance
 */
class GeoZipCode {
    protected $_zipcode;

    /**
     * @param string $zipcode
     */
    public function __construct($zipcode="") {
        $this->_zipcode  = $zipcode;
    }

    /**
     * This function returns the postal code as string
     * @return string
     */
    public function __toString() {
        return $this->_zipcode;
    }
}