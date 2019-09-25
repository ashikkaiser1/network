<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of not_found
 *
 * @author kuldeep
 */
class not_found extends CI_Controller {
    //put your code here
    
    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        
        $this->load->view("util/not_found");
    }
}
