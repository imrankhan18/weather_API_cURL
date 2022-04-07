<?php
require '../vendor/autoload.php';

use Phalcon\Mvc\Controller;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function indexAction()
    {
    }
    /**
     * cities names by api on searching
     *
     * @return void
     */
    public function apiAction()
    {

        if ($this->request->has('tosearch')) {
            $loc = $this->request->getPost('tosearch');
            $loc = urlencode($loc);
            $key = '0bab7dd1bacc418689b143833220304';
            $client = new Client(['base_uri' => 'http://api.weatherapi.com/v1/']);
            $url = "search.json?key=$key&q=$loc";

            $response = $client->request('GET', $url);
            $r = json_decode($response->getBody(), true);
            $this->view->message = $r;
            // echo "<pre>";
            // print_r($r);
            // echo "<pre>";
            // die;
        }
    }
    public function detailsAction()
    {
        /**
         * details of cities weather, forecast etc
         */
        if ($this->request->get('alt')) {
            $action = $this->request->get('action') ?? 'current';
            $alt = $this->request->get('alt');
            if ($action == 'forecast') {
                $date = 7;
            } elseif ($action == 'history') {
                $date = '2010-01-01';
            } elseif ($action == 'aqi') {
                $action = 'forecast';
                // $st = '&aqi=yes';
            } else {
                $date = '';
            }
            $st = '&aqi=yes';
            $key = '0bab7dd1bacc418689b143833220304';
            $client = new Client(['base_uri' => 'http://api.weatherapi.com/v1/']);
            $url = "". $action . ".json?key=" . $key .$st . "&q=" . $alt . "&days=" . $date . "&dt=" . $date . "&days=1&aqi=yes&alerts=yes";
            $response = $client->request('GET', $url);
            $val = json_decode($response->getBody(), true);
        
            $this->view->data = $val;
           
    }
    }

    public function postAction()
    {

        $ch = curl_init();
        $url = "http://httpbin.org/post";

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            http_build_query(array('postvar1' => '10', 'postvar2' => '20', 'postvar3' => '30'))
        );


        // In real life you should use something like:
        // curl_setopt($ch, CURLOPT_POSTFIELDS, 
        //          http_build_query(array('postvar1' => 'value1')));

        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);
        $s = json_decode($server_output, true);
        echo "<pre>";
        print_r($s);
        echo "</pre>";
        curl_close($ch);
    }
    public function guzzleAction()
    {
       
        
        
    }
}
