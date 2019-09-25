<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of api_kit
 *
 * @author SMFarhan
 */
class api_kit extends CI_Controller {

    //put your code here


    public function __construct() {
        parent::__construct();
//        //check the login for user
        $this->load->library("common/com"); $this->com->is_advertiser();
//        $this->load->model("advertiser/m_api");
//        $this->load->model("admin/random_string_gen", "hashCode");
        //end
    }

    public function index() {
        $data = array();

//        $data['token'] = $this->m_api->getToken(UID);
//        $data['tokenInfo'] = $this->m_api->getTokenInfo(UID);
//        echo '<pre>';
//        print_r($data);
        $data['PageContent'] = $this->load->view("advertiser/api_kit/api_kit", '', TRUE);
        $this->load->view("advertiser/template", $data);
    }

}
