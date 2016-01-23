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
     * Set the ApiUrl
     *
     * @param string $api_url
     * @return $this
     */
    public function setApiUrl($api_url)
    {
        $this->api_url = $api_url;
        return $this;
    }

    /**
     * This is not required as the documentation states but if it becomes required
     * you can set it with this function.
     *
     * @param $googleAPIkey
     * @return $this
     */
    public function setGoogleAPIkey($googleAPIkey)
    {
        $this->googleAPIkey = $googleAPIkey;
        return $this;
    }

    /**
     * Should we use SSL Verifier (Curl) yes or no.
     *
     * @param $disable_ssl_verifier
     * @return $this
     */
    public function setUseSslVerifier($disable_ssl_verifier)
    {
        $this->disable_ssl_verifier = $disable_ssl_verifier;
        return $this;
    }

    /**
     * Set the destination.
     *
     * @param string $destination
     * @return $this
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
        return $this;
    }

    /**
     * Set the source.
     *
     * @param $source
     * @return $this
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Return the destination.
     *
     * @return string
     */
    private function getDestination()
    {
        return $this->destination;
    }

    /**
     * Get the API Url.
     *
     * @return string
     */
    public function getApiUrl()
    {
        return $this->api_url;
    }

    /**
     * Are we using SSL verifier?
     *
     * @return bool
     */
    private function useSslVerifier()
    {
        return $this->disable_ssl_verifier;
    }

    /**
     * Return the source.
     *
     * @return string
     */
    private function getSource()
    {
        return $this->source;
    }

    /**
     * Return the url options.
     *
     * @return array
     */
    private function getUrlOptions()
    {
        return $this->urlOptions;
    }

    /**
     * Execute the request to Google Services.
     *
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
     * Query the distance from Google Services.
     *
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
            $request_string .= (($cnt > 0) ? '&' : ''). $key.'='.$val;
            $cnt++;
        }

        $url = $this->getApiUrl().'?' . $request_string;
        $response = $this->requestData($url);

        $response = utf8_encode($response);
        $route = json_decode($response);

        if ($route && ($rows = current($route->rows))) {
            $elements = current($rows->elements);
            return $elements;
        }
        return NULL;
    }

    /**
     * Return the distance calculated to Kilometers.
     *
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
     * Return the distance calculated to Miles.
     *
     * @return float|int
     */
    public function getDistanceInMiles()
    {
        return $this->convertResult(self::KM_TO_MILES_CONVERTER);
    }

    /**
     * Return the distance calculated to Yards.
     *
     * @return float|int
     */
    public function getDistanceInYards()
    {
        return $this->convertResult(self::KM_TO_YARD_CONVERTER);
    }

    /**
     * This function will do the sum and calculate the distance correctly.
     *
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