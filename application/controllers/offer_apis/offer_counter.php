<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of offer_counter
 *
 * @author kuldeep
 */
class offer_counter extends CI_Controller{
    //put your code here
    
    public static $counter = array();
    public function __construct() {
        parent::__construct();
         $this->load->library("common/com");
    }
     
    public function index() {
       $result= offer_counter::$counter;
       echo json_encode($result);
    }
}
