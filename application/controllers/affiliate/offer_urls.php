<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of offer_urls
 *
 * @author NexGen
 */
class offer_urls extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com"); $this->com->is_affiliate();
        //end
        $this->load->model("affiliate/m_offer_url");
       
    }

   

    public function showOfferUrls() {
        $data = array();
        $request = $this->input->post();
        if ($request) {
            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            $data['offerUrls'] = $this->m_offer_url->getOfferUrl($request);
            if (!empty($data['offerUrls']))
                $data['success'] = TRUE;
            echo json_encode($data);
            return;
        }
    }



}
