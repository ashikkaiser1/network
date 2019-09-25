<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author kuldeep
 */
//require_once(FCPATH . APPPATH . 'controllers/loader.php');

class profile extends CI_Controller {

    public $page="profile";
    //put your code here
    public function __construct() {
        parent::__construct();
       // $this->load->helper('load_controller');
    }

    public function index() {
//
//$this->load->driver('cache', array('memcached' => 'apc', 'backup' => 'file'));
//if ($this->cache->memcached->is_supported())
//{
//    echo 'hello';
//}

       // $this->benchmark->mark('code_start');

        $data = array();
        $data['top'] = $this->load_controller('common/c_top');
        $data['left'] = $this->load_controller('common/c_left');
        $data['right'] = $this->load_controller('common/c_right');
        $data['center'] = $this->load_controller('common/c_center');
        $data['bottom'] = $this->load_controller('common/c_bottom');
        
        //print_r($data);
        $this->load->view("template", $data);

//        $this->benchmark->mark('code_end');
//
//        echo $this->benchmark->elapsed_time('code_start', 'code_end');
        
        
    }
    
    

}
