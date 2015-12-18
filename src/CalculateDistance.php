<?php
namespace Redbox\Distance;

/**
 *
 * @package   CalculateDistance
 * @author    Johnny Mast <mastjohnny@gmail.com>
 * @license   https://github.com/johnnymast/CalculateDistance/blob/master/LICENSE.txt MIT
 * @link      https://github.com/johnnymast/CalculateDistance
 */
class CalculateDistance {

    const MAPS_DISTANCE_MATRIX_API_URL = 'https://maps.googleapis.com/maps/api/distancematrix/json';
    const KM_TO_MILES_CONVERTER       = 0.62137;
    const KM_TO_YARD_CONVERTER        = 1093.6133;
    const CURRENT_VERSION             = '1.0';
    protected $_source                = '';
    protected $_destination           = '';
    protected $_googleAPIkey          = '';
    protected $_urlOptions            = [];
    protected $_disable_ssl_verifier  = true;

    /**
     * Construct the class and setup the basic options
     */
    public function __construct() {
        $this->_urlOptions = array(
            'origins'       => '',
            'destinations'  => '',
            'mode'          => 'driving',
            'language'      => 'en-EN',
            'sensor'        => 'false',
            'key'           => '',
        );
    }

    /**
     * Set if we are going to use ssl verifier or not
     * @param string $googleAPIkey as the google API key
     * @return self
     */
    public function setGoogleAPIkey($googleAPIkey)
    {
        $this->_googleAPIkey = $googleAPIkey;
        return $this;
    }

    /**
     * Set if we are going to use ssl verifier or not
     * @param boolean $disable_ssl_verifier
     * @return self
     */
    public function setUseSslVerifier($disable_ssl_verifier)
    {
        $this->_disable_ssl_verifier = $disable_ssl_verifier;
        return $this;
    }

    /**
     * Set the source
     * @param mixed GeoZipCode|GeoPoint
     * @return self
     */
    public function setSource($source)
    {
        $this->_source = $source;
        return $this;
    }

    /**
     * Set the destination
     * @param mixed GeoZipCode|GeoPoint
     * @return self
     */
    public function setDestination($destination)
    {
        $this->_destination = $destination;
        return $this;
    }

    /**
     * Get the destination
     * @return mixed GeoZipCode|GeoPoint
     */
    public function getDestination()
    {
        return $this->_destination;
    }

    /**
     * returns the GoogleMaps API key if its set.
     * @return string
     */
    private function getGoogleAPIkey()
    {
        return $this->_googleAPIkey;
    }

    /**
     * Private method so we know if we use the ssl verifier option
     * @return boolean
     */
    private function useSslVerifier()
    {
        return $this->_disable_ssl_verifier;
    }

    /**
     * returns the source GeoPoint|GeoZipCode
     * @return mixed GeoPoint|GeoZipCode
     */
    public function getSource()
    {
        return $this->_source;
    }

    /**
     * Returns the urloptions
     * @return array
     */
    public function getUrlOptions()
    {
        return $this->_urlOptions;
    }

    /**
     * Execute the request
     * @param string $url
     * @return mixed
     */
    private function requestData($url="") {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Calculate Distance V'.self::CURRENT_VERSION,
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $this->useSslVerifier());
        $resp = curl_exec($curl);
        return $resp;
    }

    /**
     * Do the the actual request to Google Maps.
     * @return mixed|null
     */
    private function calculateDistance() {

        $data = $this->getUrlOptions();
        $data['origins']      = urlencode($this->getSource());
        $data['destinations'] = urlencode($this->getDestination());
        $data['key']          = $this->getGoogleAPIkey();

        $request_string = '';
        $cnt = 0;
        foreach($data as $key => $val) {
            if ($cnt > 0)
                $request_string .='&';

            $request_string .= $key.'='.$val;
            $cnt++;
        }

        $url = self::MAPS_DISTANCE_MATRIX_API_URL.'?' . $request_string;
        $response = $this->requestData($url);

        $response = utf8_encode($response);
        $route = json_decode($response);

        if ($route) {
            $rows = current($route->rows);
            if (is_null($rows) === false) {
                $elements = current($rows->elements);
                return $elements;
            }
        }
        return NULL;
    }

    /**
     * Returns the distance in KM
     * @return float|int
     */
    public function getDistanceInKM() {
        $route = $this->calculateDistance();
        if( is_null($route) === FALSE) {
            if(isset($route->distance->value)){
                return round($route->distance->value/1000,2);
            }
            else
            {
                return -1;
            }
        } else {
            return -1;
        }
    }

    /**
     * Returns the distance in Miles
     * @return float|int
     */
    public function getDistanceInMiles() {
        return $this->convertResult(self::KM_TO_MILES_CONVERTER);
    }

    /**
     * Returns the distance in Yards
     * @return float|int
     */
    public function getDistanceInYards() {
        return $this->convertResult(self::KM_TO_YARD_CONVERTER);
    }

    protected function convertResult($type) {
        $result = $this->getDistanceInKM();
        if ($result > -1) {
            return ($result * $type);
        }
        return $result;
    }
}