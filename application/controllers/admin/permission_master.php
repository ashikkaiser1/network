<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of permission_master
 *
 * @author kuldeep
 */
class permission_master extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();

        //check the login for user
        $this->load->library("common/com");
        $this->com->is_admin();
        //end
    }

    public function index() {

        $data = array();
        $data['title'] = "Permission Master";
        $data['PageContent'] = $this->load->view("admin/permission_master/per_index", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function get_permission_list() {
        
    }

}
