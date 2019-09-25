<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of faq
 *
 * @author SMFarhan
 */
class faq extends CI_Controller {

    //put your code here


    public function __construct() {
        parent::__construct();
//        //check the login for user
        $this->load->library("common/com"); $this->com->is_affiliate();
        $this->load->model("affiliate/m_faq");
//        $this->load->model("admin/random_string_gen", "hashCode");
        //end
    }

    public function index() {
        $data = array();

//        $data['token'] = $this->m_api->getToken(UID);
//        $data['tokenInfo'] = $this->m_api->getTokenInfo(UID);
//        echo '<pre>';
//        print_r($data);
        $filter = array();
        $filter['faq_status'] = 1;
        $data['faqs'] = $this->m_faq->get_all_faqs($filter);
        $data['PageContent'] = $this->load->view("affiliate/faq/faq", $data, TRUE);
        $this->load->view("affiliate/template", $data);
    }

}
