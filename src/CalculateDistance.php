<?php
namespace Redbox\Distance;

class CalculateDistance
{

    const MAPS_DISTANCE_MATRIX_API_URL = 'https://maps.googleapis.com/maps/api/distancematrix/json';
    const KM_TO_MILES_CONVERTER       = 0.62137;
    const KM_TO_YARD_CONVERTER        = 1093.6133;
    const CURRENT_VERSION             = '1.0';
    const USER_AGENT                  = 'Calculate Distance V';

    protected $source                 = '';
    protected $destination            = '';
    protected $googleAPIkey           = '';
    protected $urlOptions             = [];
    protected $disable_ssl_verifier   = true;
    protected $api_url                = '';

    /**
     * CalculateDistance constructor.
     */
    public function __construct() {
        $this->urlOptions = array(
            'origins'       => '',
            'destinations'  => '',
            'mode'          => 'driving',
            'language'      => 'en-EN',
            'sensor'        => 'false',
            'key'           => '',
        );
        $this->setApiUrl(self::MAPS_DISTANCE_MATRIX_API_URL);
    }

    /**
     * @param string $api_url
     * @return $this
     */
    public function setApiUrl($api_url)
    {
        $this->api_url = $api_url;
        return $this;
    }

    /**
     * @param $googleAPIkey
     * @return $this
     */
    public function setGoogleAPIkey($googleAPIkey)
    {
        $this->googleAPIkey = $googleAPIkey;
        return $this;
    }

    /**
     * @param $disable_ssl_verifier
     * @return $this
     */
    public function setUseSslVerifier($disable_ssl_verifier)
    {
        $this->disable_ssl_verifier = $disable_ssl_verifier;
        return $this;
    }

    /**
     * @param string $destination
     * @return $this
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * @param $source
     * @return $this
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * @return string
     */
    private function getDestination()
    {
        return $this->destination;
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return $this->api_url;
    }

    /**
     * @return bool
     */
    private function useSslVerifier()
    {
        return $this->disable_ssl_verifier;
    }

    /**
     * @return string
     */
    private function getSource()
    {
        return $this->source;
    }

    /**
     * @return array
     */
    private function getUrlOptions()
    {
        return $this->urlOptions;
    }

    /**
     * @param string $url
     * @return mixed
     */
    private function requestData($url="")
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => self::USER_AGENT.self::CURRENT_VERSION,
        ));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $this->useSslVerifier());
        $resp = curl_exec($curl);
        return $resp;
    }

    /**
     * @return mixed|null
     */
    private function calculateDistance()
    {

        $data                 = $this->getUrlOptions();
        $data['origins']      = urlencode($this->getSource());
        $data['destinations'] = urlencode($this->getDestination());
        $data['key']          = $this->googleAPIkey;

        $request_string = '';
        $cnt = 0;
        foreach($data as $key => $val) {
            if ($cnt > 0) {
                $request_string .= '&';
            }
            $request_string .= $key.'='.$val;
            $cnt++;
        }

        $url = $this->getApiUrl().'?' . $request_string;
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
     * @return float|int
     */
    public function getDistanceInKM()
    {
        $route = $this->calculateDistance();
        if( is_null($route) === FALSE) {
            if(isset($route->distance->value)){
                return round($route->distance->value/1000);
            }
        }
        return -1;
    }

    /**
     * @return float|int
     */
    public function getDistanceInMiles()
    {
        return $this->convertResult(self::KM_TO_MILES_CONVERTER);
    }

    /**
     * @return float|int
     */
    public function getDistanceInYards()
    {
        return $this->convertResult(self::KM_TO_YARD_CONVERTER);
    }

    /**
     * @param $type
     * @return float|int
     */
    private function convertResult($type)
    {
        $result = $this->getDistanceInKM();
        if ($result > -1) {
            return ($result * $type);
        }
        return $result;
    }
}