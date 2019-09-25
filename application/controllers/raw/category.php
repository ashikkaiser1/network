<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of category
 *
 * @author kuldeep
 */
class category extends CI_Controller {

    public $page="category";

    public function index($categoryName='') {



//         $this->benchmark->mark('code_start');
//        global $extra_data;
//        $extra_data['fun_args'] = func_get_args();
        $data = array();
        $data['metaSEO'] = $this->load_controller('modules/search_engine/seo');
        $data['top'] = $this->load_controller('common/c_top');
        $data['left'] = $this->load_controller('common/c_left');
        $data['right'] = $this->load_controller('common/c_right');
        $data['center'] = $this->load_controller('common/c_center');
        $data['bottom'] = $this->load_controller('common/c_bottom');

        //print_r($data);
        $this->load->view("template", $data);
    }
    
//    public function filter_products() {
//        $this->load_controller('modules/module_category','filter_products');
//    }
   

}
