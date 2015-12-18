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
    protected $source                = '';
    protected $destination           = '';
    protected $googleAPIkey          = '';
    protected $urlOptions            = [];
    protected $disable_ssl_verifier  = true;

    public function __construct() {
        $this->urlOptions = array(
            'origins'       => '',
            'destinations'  => '',
            'mode'          => 'driving',
            'language'      => 'en-EN',
            'sensor'        => 'false',
            'key'           => '',
        );
    }

    public function setGoogleAPIkey($googleAPIkey)
    {
        $this->googleAPIkey = $googleAPIkey;
        return $this;
    }

    public function setUseSslVerifier($disable_ssl_verifier)
    {
        $this->disable_ssl_verifier = $disable_ssl_verifier;
        return $this;
    }

    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    public function setDestination($destination)
    {
        $this->destination = $destination;
        return $this;
    }

    public function getDestination()
    {
        return $this->destination;
    }

    private function getGoogleAPIkey()
    {
        return $this->googleAPIkey;
    }

    private function useSslVerifier()
    {
        return $this->disable_ssl_verifier;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getUrlOptions()
    {
        return $this->urlOptions;
    }

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


    public function getDistanceInMiles() {
        return $this->convertResult(self::KM_TO_MILES_CONVERTER);
    }


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