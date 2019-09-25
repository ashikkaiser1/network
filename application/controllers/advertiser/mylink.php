<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mylink
 *
 * @author NexGen
 */
class mylink extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com"); $this->com->is_advertiser();
        $this->load->model("advertiser/m_category");
        $this->load->model("advertiser/m_domain");
        $this->load->model("account/m_account");
        //end
    }

    public function index() {
        $data = array();

        $data['category'] = $this->m_category->getCategory();
        $data['domain'] = $this->m_domain->getDomain();
        $data['PageContent'] = $this->load->view("advertiser/mylink/v-mylink", $data, TRUE);
        $this->load->view("advertiser/template", $data);
    }

    public function show_my_offer() {
        $this->load->helper("form");
        $data = array();

        $data['category'] = $this->m_category->getCategory();
        $data['domain'] = $this->m_domain->getDomain();
        $data['country'] = $this->m_account->getCountry();
        $data['PageContent'] = $this->load->view("advertiser/mylink/v-mylink_design", $data, TRUE);
        $this->load->view("advertiser/template", $data);
    }

}
