<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of offer_utility
 *
 * @author kuldeep
 */
class offer_utility extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model("admin/m_offer_utility");
        $this->load->library("common/com");
        $this->load->library('user_agent');
    }

    public function getOffersSearch() {
        //
        $data['items'] = array();

        $data['total_count'] = 0;
        $data['incomplete_results'] = FALSE;
        $request = $this->input->post();
        if ($request) {
            $filter = array();

            if (UID == ADVERTISER) {
                $request['advertiser_id'] = UID;
            }
            $filter['campaign_name'] = isset($request['q']) ? $request['q'] : '';
            $data['items'] = $this->m_offer_utility->getCampaign($filter);

            $data['total_count'] = count($data['items']);
        }

        echo json_encode($data);
    }

    public function getPostOffersSearch() {
        //
        $data['items'] = array();

        $data['total_count'] = 0;
        $data['incomplete_results'] = FALSE;
        $request = $this->input->post();
        if ($request) {
            $filter = array();
            if (UID == ADVERTISER) {
                $request['advertiser_id'] = UID;
            }
            $filter['campaign_name'] = isset($request['q']) ? $request['q'] : '';
            $data['items'] = $this->m_offer_utility->getPost($filter);

            $data['total_count'] = count($data['items']);
        }

        echo json_encode($data);
    }

}
