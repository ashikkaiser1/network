<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of device_test
 *
 * @author kuldeep
 */
class device_test extends CI_Controller {
    //put your code here
    
    public function __construct() {
        parent::__construct();
        $this->load->library("device_detector/DeviceDetector");
    }
    public function index() {
        
    }
            
}
