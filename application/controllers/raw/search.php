<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of search
 *
 * @author kuldeep
 */
class search extends CI_Controller {

    public $page="search";

    public function index() {



//         $this->benchmark->mark('code_start');

        $data = array();
        $data['top'] = $this->load_controller('common/c_top');
        $data['left'] = $this->load_controller('common/c_left');
        $data['right'] = $this->load_controller('common/c_right');
        $data['center'] = $this->load_controller('common/c_center');
        $data['bottom'] = $this->load_controller('common/c_bottom');

        //print_r($data);
        $this->load->view("template", $data);
    }

}