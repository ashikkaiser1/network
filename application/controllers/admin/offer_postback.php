<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
        $this->load->library("common/com");
        $this->com->is_admin();
        $this->load->model("affiliate/m_category");
        $this->load->model("affiliate/m_domain");
        $this->load->model("affiliate/m_post");
        $this->load->model("admin/m_macros");
        $this->load->model("admin/random_string_gen", "hashCode");
        $this->load->helper("form");

        $this->load->model("admin/m_pixel_manager");
        $this->load->model("admin/affiliate/m_links");
        //end

        $this->load->model("admin/m_users");
    }

    public function index() {
        $this->show_offer_postbacks();
        return;
//        $data = array();
//        $data['category'] = $this->m_category->getCategory();
//        $data['domain'] = $this->m_domain->getDomain();
//        $data['macros'] = $this->m_macros->getMacros();
//        $pub_filter = array();
//        $pub_filter['listFormated'] = "TRUE";
//        $pub_filter['UTID'] = AFFILIATE;
//        $data['publisher'] = $this->m_users->getUsers($pub_filter);
//        unset($data['publisher']['']);
//
//
//        $filter = array();
//        $filter['type'] = OFFER;
//        $data['offers'] = $this->m_post->getOffers($filter);
//
//        $data['PageContent'] = $this->load->view("admin/offer/v-offer_postback", $data, TRUE);
//        $this->load->view("admin/template", $data);
    }

    public function AddUserOfferPostbacks($campaign_id = 0, $uid = 0) {
        //new function to add User Offer Postbacl
        //other function in this file will be removed
        //like this one  AddConvsrionUrlPixel
        // we remove this (  AddConvsrionUrlPixel ) function from this file
        $this->load->model("admin/m_campaign");
        $pub_filter = array();
        $pub_filter['listFormated'] = "TRUE";
        $pub_filter['UTID'] = AFFILIATE;
        $data['publisher'] = $this->m_users->getUsers($pub_filter);
        unset($data['publisher']['']);
        $data['p_type'] = array("0" => "Postback Url", "1" => "Image Pixel", "2" => "Iframe Pixel");

        $filter = array();
        $filter['type'] = OFFER;
        $data['offers'] = array();
        if (isset($campaign_id) && $campaign_id != 0) {
            $filter['campaign_id'] = $campaign_id;
            $filter['Formated'] = "TRUE";
            $filter['status'] = 1;
            $data['offers'] = $this->m_campaign->getCampaign($filter);
            if (!empty($data['offers'])) {
                $list = array();
                $list[$data['offers']['campaign_id']] = $data['offers']['campaign_name'];
                $data['offers'] = $list;
            }
        }
        $data['campaign_id'] = $campaign_id;
        $data['uid'] = $uid;
        $data['add_link'] = SITEURL . "admin/offer_postback/show_offer_postbacks";
        $data['PageContent'] = $this->load->view("admin/offer/pixel-manager/v-setup-postback", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    //below function in not required alfter the completion of  
    //AddUserOfferPostbacks($campaign_id = 0)  function
//    public function AddConvsrionUrlPixel($post_id = 0) {
//        //this function is not usables//
//        
//        //we delete this function 
//
//        $data = array();
//
//        $getRequest = $this->input->get();
//        if ($getRequest) {
//
//            $data['selected'] = $getRequest;
//            $data['link'] = array_pop($this->m_pixel_manager->getPixels($getRequest));
//            $data['link_event'] = $this->m_links->getLinkEvents($data['link']);
//
////            echo '<pre>';
////            print_r($data);
////            exit();
//        } else {
//            $data['selected'] = array("post_id" => $post_id);
//        }
//
//        $data['category'] = $this->m_category->getCategory();
//        $data['domain'] = $this->m_domain->getDomain();
//        $data['macros'] = $this->m_macros->getMacros();
//        $pub_filter = array();
//        $pub_filter['listFormated'] = "TRUE";
//        $pub_filter['UTID'] = AFFILIATE;
//        $data['publisher'] = $this->m_users->getUsers($pub_filter);
//        unset($data['publisher']['']);
//
//        $data['p_type'] = array("0" => "Postback Url", "1" => "Image Pixel", "2" => "Iframe Pixel");
//
//
//        $filter = array();
//        $filter['type'] = OFFER;
//        $data['offers'] = array();
//        if (isset($data['selected']) && !empty($data['selected'])) {
//            $filter['post_id'] = $data['selected'];
//            $data['offers'] = $this->m_post->getOffers($filter);
//        }
////                
//
//        $data['add_link'] = SITEURL . "admin/offer_postback/show_offer_postbacks";
//        $data['PageContent'] = $this->load->view("admin/offer/pixel-manager/v-add-offer-postbacks", $data, TRUE);
//        $this->load->view("admin/template", $data);
//    }

    public function show_offer_postbacks() {

//        $this->load->model("admin/m_pixel_manager");

        $data = array();
//        $request = $this->input->post();
//        $getRequest = $this->input->get();
//        if ($request) {
//            $getRequest = $this->input->get();
//
//            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
//            $request['company'] = $request['search'];
//            $request['campaign_id'] = $request['search'];
//            $request['campaign_name'] = $request['search'];
//            $request['post_back'] = $request['search'];
//
//            $data['pixels'] = $this->m_pixel_manager->getPixels($request);
//            echo json_encode($data['pixels']);
//            return;
//        }

        $data['add_link'] = SITEURL . "admin/offer_postback/AddUserOfferPostbacks";

        $data['PageContent'] = $this->load->view("admin/offer/pixel-manager/v-show-offer-postbacks", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

//    public function delete_postback() {
//
//        $json = array();
//        $request = $this->input->post();
//        if ($request) {
//            $filter = array();
//            $filter['link_id'] = (isset($request['link_id']) && is_array($request['link_id'])) ? $request['link_id'] : array();
//            $update = array();
//            $update['p_status'] = 0;
//            $update['post_back'] = '';
//            $this->m_pixel_manager->delete_postback($filter, $update);
//            $json['success'] = TRUE;
//            $json['msg'] = 'Deleted';
//        } else {
//            $json['success'] = FALSE;
//            $json['msg'] = 'Not Deleted';
//        }
//
//        echo json_encode($json);
//    }

}
