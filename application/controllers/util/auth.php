<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of auth
 *
 * @author kuldeep
 */
//require_once APPPATH . '/libraries/device-detector'.'/DeviceDetector.php';
//include_once APPPATH . '/libraries/device-detector'.'/Yaml/Spyc.php';
include_once APPPATH . 'libraries/' . 'spyc/spyc.php';
include_once APPPATH . 'libraries/device-detector' . '/autoload.php';

use DeviceDetector\DeviceDetector;

class auth extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $this->load->library('user_agent');
        $data = array();
        $data['pageLink'] = $this->agent->referrer();

        $this->load->view("util/auth_fail");
    }

    public function updateing_mode() {
        $this->load->view("util/maintenance_mode");
    }

    public function get_device_info() {

//        require_once APPPATH . '/libraries/detector'. '/DeviceDetector.php';
        $userAgent = $_SERVER['HTTP_USER_AGENT']; // change this to the useragent you want to parse
        try {
            $dd = new DeviceDetector($userAgent);
            $dd->parse();
//            echo 'paring';
//            print_r($userAgent);

            if ($dd->isBot()) {
                // handle bots,spiders,crawlers,...
                $botInfo = $dd->getBot();
                print_r($botInfo);
            } else {
                $clientInfo = $dd->getClient(); // holds information about browser, feed reader, media player, ...
                echo 'Client Info<br>'
                . '<pre>';
                echo '<br>';
                print_r($clientInfo);

                echo 'OS Info<br>';

                $osInfo = $dd->getOs();
                print_r($osInfo);
                echo '<br>';
                echo 'Device Name<br>';
                echo $dd->getDeviceName();
//                 echo $dd->;
                echo '<br>';
                echo 'Get Device<br>';
                $device = $dd->getDevice();
                print_r($device);
                echo '<br>';
                echo 'Brand Name<br>';
                $brand = $dd->getBrandName();
                print_r($brand);
                echo '<br>';
                echo 'Get Model<br>';
                $model = $dd->getModel();
                print_r($model);
            }
        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }

    public function getgeo() {

        $res = json_decode(file_get_contents("http://ip-api.com/json/106.202.88.239"));
        echo '<pre>';
        print_r($res);
    }

    public function premission_denied() {
        $this->load->library("common/com");
        
        
        
        $data = array();
        $data['PageContent'] = $this->load->view("util/permission_denied", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

}
