<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of offer_postback
 *
 * @author NexGen
 */
class offer_postback extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();

        //check the login for user
        $this->load->library("common/com"); $this->com->is_affiliate();
        $this->load->model("affiliate/m_category");
        $this->load->model("affiliate/m_domain");
        $this->load->model("affiliate/m_post");
         $this->load->model("admin/m_macros");
        $this->load->model("admin/random_string_gen", "hashCode");
        $this->load->helper("form");
        //end
    }

    public function index() {

        $data = array();
        $data['category'] = $this->m_category->getCategory();
        $data['domain'] = $this->m_domain->getDomain();
         $data['macros'] = $this->m_macros->getMacros();
        $filter = array();
        $filter['type'] =OFFER;
        $data['offers'] = $this->m_post->getOffers($filter);

        $data['PageContent'] = $this->load->view("affiliate/offer/v-offer_postback", $data, TRUE);
        $this->load->view("affiliate/template", $data);
    }
    
     public function show_offer_postbacks() {

        $this->load->model("admin/m_pixel_manager");

        $data = array();
        $request = $this->input->post();
        
        if ($request) {
            $data['pixels'] = $this->m_pixel_manager->getPixels($request);
            echo json_encode($data['pixels']);
            return;
        }
      
    }

}
