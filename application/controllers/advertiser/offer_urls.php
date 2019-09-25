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
//        $this->load->library("common/com"); $this->com->is_advertiser();
//        //end
//        $this->load->model("advertiser/m_offer_url");
//        
        $this->load->library("common/com"); $this->com->is_advertiser();

        //end
        $this->load->model("admin/m_campaign");
        $this->load->model("admin/m_offer_url");
        $this->load->helper("form");
    }

    public function AddOfferLandingUrl($campaign_id = 0) {

        $request = $this->input->post();
        if ($request) {
            $json = array(); 
            if ($this->m_offer_url->CreateOfferUrl($request)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your new Url is added.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your new Url can be added.";
            }

            echo json_encode($json);
            return;
        }

        $data = array();
        $filter = array();
//        $filter['Formated'] = TRUE;
        $filter['group_by'] = 'campaign_id';
        $camp = array();
        if ($campaign_id != 0) {
            $filter['campaign_id'] = $campaign_id;
            $camp = $this->m_campaign->getCampaign($filter);
        }
        $data['campaign'] = $camp;
        
//        echo '<pre>';
//        print_r($camp);
//        die();
        
        $data['campaign_id'] = $campaign_id;

        $data['FormAction'] = SITEURL . "advertiser/offer_urls/AddOfferLandingUrl";
        $data['SubmitBtn'] = "Create";
        $data['Submiting'] = "Creating...";
        $data['panel_title'] = "Add Offer Url";

        // $data['Campaign'] = $this->m_campaign->getCategory(0,array("allchild"=>true));
        //$data['allCategory'] = $this->load->view("admin/Campaign/all-Campaign", $data, TRUE);
        $data['PageContent'] = $this->load->view("advertiser/offer/create/offer_url/add-offer-url.php", $data, TRUE);
        $this->load->view("advertiser/template", $data);
    }

    public function UpdateOfferUrl($url_id = 0) {

        $request = $this->input->post();
        if ($request) {
            $json = array();
            if ($this->m_offer_url->UpdateOfferUrl($request, $url_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your new Url is Updated.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your new Url can be Updated.";
            }

            echo json_encode($json);
            return;
        }

        $data = array();
        
         $o_filter = array();
        $o_filter['url_id'] = $url_id;
        $data['offerUrlData'] = $this->m_offer_url->getOfferUrl($o_filter);
        
        $filter = array();
        $filter['Formated'] = TRUE;
        $filter['group_by'] = 'campaign_id';
        if(!empty($data['offerUrlData'])){
            $data['campaign_id']=$filter['campaign_id'] = $data['offerUrlData']['campaign_id'];
            $camp = $this->m_campaign->getCampaign($filter);
        }
       
        $data['campaign'] = $camp;
//        echo '<pre>';
//        print_r($camp);
//        die();
         
        $data['FormAction'] = SITEURL . "advertiser/offer_urls/UpdateOfferUrl/" . $url_id;
        $data['SubmitBtn'] = "Update";
        $data['Submiting'] = "Updating...";
        $data['panel_title'] = "Update Offer Url";

        // $data['Campaign'] = $this->m_campaign->getCategory(0,array("allchild"=>true));
        //$data['allCategory'] = $this->load->view("admin/Campaign/all-Campaign", $data, TRUE);
        $data['PageContent'] = $this->load->view("advertiser/offer/create/offer_url/add-offer-url.php", $data, TRUE);
        $this->load->view("advertiser/template", $data);
    }

    public function showOfferUrls() {
        $data = array();
        $request = $this->input->post();
        if ($request) {
            $getRequest = $this->input->get();
            $data['success'] = FALSE;
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            $data['offerUrls'] = $this->m_offer_url->getOfferUrl($request);
            if (!empty($data['offerUrls']))
                $data['success'] = TRUE;
            echo json_encode($data);
            return;
        }
    }

    public function deleteOfferUrl($url_id = 0) {
        //create a user 

        $request = $this->input->post();

        if ($request) {
            $json = array();
            $url_id = $request['url_id'];
            // $request['status'] = isset($request['status']) ? 1 : 0;
            if ($this->m_offer_url->deleteOfferUrl($url_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your Offer Url is deleted.";

                $json['data'] = $request;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your Offer Url canot be deleted.";
            }

            echo json_encode($json);
            return;
        }
    }

}
