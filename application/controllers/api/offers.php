<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of offers
 *
 * @author kuldeep
 */
class offers extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com_api");

        $this->load->model("admin/affiliate/m_domain");
        //end
    }

    public function get_offers() {
        //get all post from db that is related to campaign and vice versa
        $this->load->model("api/m_campaign");
//           $this->load->model("affiliate/m_campaign");


        $filter = array();
        $filter['default'] = 1;
        $domain = $this->m_domain->getDomain($filter);


        $request = $this->input->get();
        if ($request) {
            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;

            if (isset($request['onlyMe'])) {
                $request['onlyMe'] = UID;
            }
            $request['approved_offer_also'] = UID;
            $request['uid'] = UID;

            $data['offers'] = $this->m_campaign->get_post_camp($request);

            if (!empty($data['offers'])) {
                foreach ($data['offers'] as $key => $offer) {

                    $tracking_link = $domain['domain_url'] . "?offer_id=" . $offer['offer_id'];
                    $tracking_link .= "&pub=" . UID;
                    $offer['tracking_link'] = $tracking_link;


                    if (isset($offer['group_payout']) && $offer['group_payout'] != NULL) {
                        $offer['payout_cost'] = $offer['group_payout'];
                    }
                    if (isset($offer['custom_payout']) && $offer['custom_payout'] != NULL) {
                        $offer['payout_cost'] = $offer['custom_payout'];
                    }

                    $offer['currency'] = CURR;
                    unset($offer['custom_payout']);
                    unset($offer['group_payout']);

                    $data['offers'][$key] = $offer;
                }
            }

            echo json_encode($data['offers']);
        }

        return;
    }

    public function get_offers_creative() {
        $this->load->model("admin/m_creative");

        $request = $this->input->get();
        if ($request) {

            $request['campaign_id'] = isset($request['offer_id']) ? $request['offer_id'] : 0;
            $request['limit'] = isset($request['page']) ? $request['page'] : 1;
            $data['creative'] = $this->m_creative->getOfferCreative($request);
            if (!empty($data['creative'])) {
                foreach ($data['creative'] as $key => $creative) {
                    $creative['offer_id'] = $creative['campaign_id'];
                    unset($creative['uid']);
                    unset($creative['campaign_id']);
                    $data['creative'][$key] = $creative;
                }
            }
            echo json_encode($data);
            return;
        }
    }

    public function get_all_category() {
        $this->load->model("admin/m_category");
        $data['category'] = $this->m_category->getCategory(0, array("allchild" => true));
        if (!empty($data['category'])) {
            foreach ($data['category'] as $key => $category) {

                $cat = array("category_id" => $category['category_id'],
                    "category_name" => $category['category_name'],
                    "status" => $category['status']);
                $data['category'][$key] = $cat;
            }
        }
        echo json_encode($data);
    }

    public function get_devices() {
        $this->load->model("api/m_devices");
        $data['devices'] = $this->m_devices->getDevices();
        echo json_encode($data);
    }

    public function get_os() {
        $this->load->model("api/m_devices");
        $data['os_list'] = $this->m_devices->getOS();
        echo json_encode($data);
    }
    
    public function get_offer_country() {
         $this->load->model("api/m_country");

        $request = $this->input->get();
        if ($request) {
            $data = array();
            $request['campaign_id'] = isset($request['offer_id']) ? $request['offer_id'] : 0;
            $data['offer_country'] = $this->m_country->get_country($request);
            
            echo json_encode($data);
        }
        
    }

}
