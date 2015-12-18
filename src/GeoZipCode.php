<?php
namespace Redbox\Distance;

class GeoZipCode {

    /**
     * @var string
     */
    protected $zipcode;

    /**
     * @param string $zipcode
     */
    public function __construct($zipcode = "") {
        $this->zipcode  = $zipcode;
    }

    /**
     * This function returns the postal code as string
     * @return string
     */
    public function __toString() {
        return $this->zipcode;
    }
}

