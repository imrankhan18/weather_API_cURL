<?php
require '../vendor/autoload.php';

use Phalcon\Mvc\Controller;
use GuzzleHttp\Psr7\Request;
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
            $url = "http://api.weatherapi.com/v1/search.json?key=$key&q=$loc";
            // echo $url;
            // die;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_POST, 1);
            $curlexec = curl_exec($ch);
            $location = json_decode($curlexec, true);
            $this->view->message = $location;
        }
    }
    public function detailsAction()
    {
        /**
         * details of cities weather, forecast etc
         */
        if ($this->request->get('alt')) {
            $aqi = 'yes';
            $alert = 'yes';
            $action = $this->request->get('action') ?? 'current';
            $alt = $this->request->get('alt');
            if ($action == 'forecast') {
                $date = 7;
            } elseif ($action == 'history') {
                $date = '2010-01-01';
            } elseif ($action == 'wl') {
                $aqi = 'yes';
                $alert = 'yes';
            } elseif ($action == 'aqi') {
                $action = 'forecast';
                $st = '&aqi=yes';
            } else {
                $date = '';
            }

            $key = '0bab7dd1bacc418689b143833220304';
            $url = "http://api.weatherapi.com/v1/" . $action . ".json?key=" . $key . $st . "&q=" . $alt . "&days=" . $date . "&dt=" . $date . "&days=1&aqi=yes&alerts=yes";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            $curlexec = curl_exec($ch);
            $val = json_decode($curlexec, true);
            $this->view->data = $val;
            echo "<pre>";
            print_r($val);
            echo "</pre>";
            // die;
        }
    }  
}
