<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of campaign
 *
 * @author NexGen
 */
class offer extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com_api");
        //end
        $this->load->model("api/m_campaign");
//        $this->load->model("admin/m_users");
//        $this->load->helper("form");
        $this->load->model("api/m_category");
        $this->load->model("api/m_post");
//        $this->load->model("admin/m_website");
//        $this->load->model("admin/m_pay_type");
    }

    public function CreateOffers() {
        //$this->load->helper("form");

        $request = $this->input->get();

//        echo json_encode(array("response"=>array(
//            "status"=>TRUE,
//            "result"=>$request
//        )));
//        die();
        if ($request) {
            $json = array();



            $offerData = isset($request['data']) ? $request['data'] : array();

            $campaign = array();

            $campaign['campaign_name'] = isset($offerData['campaign_name']) ? $offerData['campaign_name'] : '';
            $campaign['advertiser_id'] = isset($offerData['advertiser_id']) ? $offerData['advertiser_id'] : 0;
            $campaign['start_date'] = isset($offerData['start_date']) ? $offerData['start_date'] : '';
            $campaign['end_date'] = isset($offerData['end_date']) ? $offerData['end_date'] : '';
            $campaign['cap'] = isset($offerData['cap']) ? $offerData['cap'] : 0;

            $campaign['revenue_type'] = isset($offerData['revenue_type']) ? $offerData['revenue_type'] : 0;
            $campaign['revenue_cost'] = isset($offerData['revenue_cost']) ? $offerData['revenue_cost'] : 0;

            $campaign['payout_type'] = isset($offerData['payout_type']) ? $offerData['payout_type'] : 0;
            $campaign['payout_cost'] = isset($offerData['payout_cost']) ? $offerData['payout_cost'] : 0;

            $campaign['status'] = isset($offerData['status']) ? $offerData['status'] : 0;
            $campaign['ctype'] = OFFER;

//            echo '<pre>';
//
//            print_r($campaign);
            $campaign_id = 0;
            if ($campaign_id = $this->m_campaign->CreateCampaign($campaign)) {

                //create a post //oofer

                $post = array();
                $post['web_id'] = isset($offerData['web_id']) ? $offerData['web_id'] : 0;
                $post['preview_link'] = isset($offerData['preview_link']) ? $offerData['preview_link'] : '';
                $post['url_slug'] = isset($offerData['url_slug']) ? $offerData['url_slug'] : '';
                $post['title'] = isset($offerData['campaign_name']) ? $offerData['campaign_name'] : '';
                $post['meta'] = isset($offerData['meta']) ? $offerData['meta'] : '';
                $post['status'] = isset($offerData['status']) ? $offerData['status'] : 0;
                $post['type'] = OFFER;
                $post['image'] = isset($offerData['image']) ? $offerData['image'] : 0;


                $image = $this->do_upload("image");
                if (!isset($image['error'])) {
                    $post['image'] = UPLOAD . "post/" . $image['upload_data']['file_name'];
                }

                $category_ids = isset($offerData['category_id']) ? $offerData['category_id'] : 0;

                unset($post['category_id']);
                unset($post['campaign_id']);
                $json = array();
                $post_id = 0;

//                echo '<pre>';
//
//            print_r($post);

                if ($post_id = $this->m_post->CreatePost($post)) {
                    $this->m_campaign->addpostToCampaign($campaign_id, $post_id);
                    if ($category_ids) {
                        if ($this->m_category->category_to_post($category_ids, $post_id)) {
                            
                        }
                    }
                }



                //post created
                $json['status'] = TRUE;
                $json['msg'] = "Your new offer is added.";
                $json['request'] = $offerData;
                $json['response'] = array("offer_id" => $campaign_id);
            } else {
                $json['status'] = FALSE;
                $json['msg'] = "Offer cant created.";
            }

            echo json_encode(array("response" => $json));


            //  echo json_encode($json);
            return;
        }
    }

    public function UpdateOffers($campaign_id = 0) {
//        $this->load->helper("form");
        $request = $this->input->post();

        if ($request) {
            $json = array();

            $campaign = array();

            $campaign['campaign_name'] = isset($request['campaign_name']) ? $request['campaign_name'] : '';
            $campaign['advertiser_id'] = isset($request['advertiser_id']) ? $request['advertiser_id'] : 0;
            $campaign['start_date'] = isset($request['start_date']) ? $request['start_date'] : '';
            $campaign['end_date'] = isset($request['end_date']) ? $request['end_date'] : '';
            $campaign['cap'] = isset($request['cap']) ? $request['cap'] : 0;

            $campaign['revenue_type'] = isset($request['revenue_type']) ? $request['revenue_type'] : 0;
            $campaign['revenue_cost'] = isset($request['revenue_cost']) ? $request['revenue_cost'] : 0;

            $campaign['payout_type'] = isset($request['payout_type']) ? $request['payout_type'] : 0;
            $campaign['payout_cost'] = isset($request['payout_cost']) ? $request['payout_cost'] : 0;
            $campaign['status'] = isset($request['status']) ? $request['status'] : 0;
            $campaign['req_approval'] = isset($request['req_approval']) ? $request['req_approval'] : 0;
            $campaign['ctype'] = OFFER;
            //post
            $post = array();
            $post['web_id'] = isset($request['web_id']) ? $request['web_id'] : 0;
            $post['preview_link'] = isset($request['preview_link']) ? $request['preview_link'] : '';
            $post['url_slug'] = isset($request['url_slug']) ? $request['url_slug'] : '';
            $post['title'] = isset($request['campaign_name']) ? $request['campaign_name'] : '';
            $post['meta'] = isset($request['meta']) ? $request['meta'] : '';
            $post['status'] = isset($request['status']) ? $request['status'] : 0;
            $post['type'] = OFFER;
            $post['image'] = isset($request['image']) ? $request['image'] : 0;


            $image = $this->do_upload("image");
            if (!isset($image['error'])) {
                $post['image'] = UPLOAD . "post/" . $image['upload_data']['file_name'];
            }

            $category_ids = isset($request['category_id']) ? $request['category_id'] : 0;

            unset($post['category_id']);
            unset($post['campaign_id']);



            $post_id = $request['post_id'];

            if ($this->m_post->UpdatePost($post, $post_id) || $this->m_category->category_to_post_update($category_ids, $post_id) || $this->m_campaign->updatepostTocampaign($campaign_id, $post_id)
            ) {
                $json['success'] = TRUE;
                $json['msg'] = "Your Offer is update.";
            }




            if ($this->m_campaign->UpdateCampaign($campaign, $campaign_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your Offer is update.";
                $json['result'] = $request;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your Offer can't be update.";
            }

            echo json_encode($json);
            return;
        }


        $data = array();
        $CampFilter = array();
        $CampFilter['campaign_id'] = $campaign_id;
        $data['campaign'] = $this->m_campaign->getCampaign($CampFilter);
        $post_id = $this->m_campaign->getPost_id($CampFilter);
        $post = $this->m_post->getPostForUpdate($post_id);

        $rev_filter = array();
        $rev_filter['type'] = REVENUE;
        $rev_filter['formated'] = TRUE;
        $data['revenue'] = $this->m_pay_type->getPayType($rev_filter);

        $rev_filter['type'] = PAYOUT;
        $rev_filter['formated'] = TRUE;
        $data['payout'] = $this->m_pay_type->getPayType($rev_filter);



        if (isset($post))
            $data['post'] = $post;


//        echo "<pre>";
//        print_r($data['post']);

        $data['category'] = $this->m_category->getCategoryList();
        $data['website'] = $this->m_website->getWebsiteList();
        $filters = array();
        $filters['UTID'] = ADVERTISER;
        $filters['listFormated'] = TRUE;
        $data['affiliates'] = $this->m_users->getUsers($filters);
        $data['FormAction'] = SITEURL . "admin/offer/UpdateOffers/" . $campaign_id;
        $data['SubmitBtn'] = "Update";
        $data['Submiting'] = "Updating...";
        $data['title'] = "Update Offer";
        // $data['Campaign'] = $this->m_campaign->getCategory(0,array("allchild"=>true));
        //$data['allCategory'] = $this->load->view("admin/Campaign/all-Campaign", $data, TRUE);
        $data['PageContent'] = $this->load->view("admin/offer/add-offer", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

//    public function deleteCampaign() {
//        //delete the campaing 
//
//        $request = $this->input->post();
//
//        if ($request) {
//            $json = array();
//            $campaign_id = $request['campaign_id'];
//            // $request['status'] = isset($request['status']) ? 1 : 0;
//            if ($this->m_campaign->deleteCampaign($campaign_id)) {
//                $json['success'] = TRUE;
//                $json['msg'] = "Your campaign is deleted.";
//
//                $json['data'] = $request;
//            } else {
//                $json['success'] = FALSE;
//                $json['msg'] = "Your campaign canot be deleted.";
//            }
//
//            echo json_encode($json);
//            return;
//        }
//    }
//
//    public function delPostFromCamp() {
////        delete or remove the post from campaign that is attach to it
//        $request = $this->input->post();
//        if ($request) {
//            $json = array();
//
//            if ($this->m_campaign->delPostFromCamp($request)) {
//                $json['success'] = TRUE;
//                $json['msg'] = "Your post is removed from campaign.";
//
//                $json['data'] = $request;
//            } else {
//                $json['success'] = FALSE;
//                $json['msg'] = "Your  post canot be removed from campaign.";
//            }
//
//            echo json_encode($json);
//            return;
//        }
//    }

    public function get_offers() {
        //show the avilabele campaignss....
        $data = array();
        $request = $this->input->get();
        if ($request) {
            $getRequest = $this->input->get();
            $request['page'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            $request['limit'] = isset($getRequest['limit']) ? $getRequest['limit'] : 1;
            $request['campaign_id'] = isset($getRequest['offer_id']) ? explode(',', $getRequest['offer_id']) : 0;

            $response['offers'] = $this->m_campaign->getCampaign($request);

            $data['success'] = TRUE;
            $data['message'] = "Offer List found.";
            $data['total'] = count($response['offers']);
            if ($data['total'] == 0) {
                $data['success'] = FALSE;
                $data['message'] = "No Offer found.";
            }

            $data['request'] = $getRequest;
            $data['response'] = $response;



            echo json_encode($data);
            return;
        } else {
            
        }
    }

    public function get_offer_country() {

        $this->load->model("api/m_country");
        $data = array();
        $request = $this->input->get();
        if ($request) {
            $getRequest = $this->input->get();
//            $request['page'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
//            $request['limit'] = isset($getRequest['limit']) ? $getRequest['limit'] : 1;
            $request['campaign_id'] = isset($getRequest['offer_id']) ? explode(',', $getRequest['offer_id']) : 0;

            $response['country'] = $this->m_country->get_country($request);

            $data['success'] = TRUE;
            $data['message'] = "Country List found.";
            $data['total'] = count($response['country']);
            if ($data['total'] == 0) {
                $data['success'] = FALSE;
                $data['message'] = "No country found.";
            }

            $data['request'] = $getRequest;
            $data['response'] = $response;



            echo json_encode($data);
            return;
        } else {
            
        }
    }

    public function post_to_campaign($campaign_id = 0) {
        //view generate for set the post to campaign

        $data = array();
        $request = $this->input->post();
        if ($request) {
            $data['campaign'] = $this->m_campaign->getCampaign();

            echo json_encode($data['campaign']);
            return;
        }
        $data['campaign_id'] = $campaign_id;


        $this->load->model("admin/m_category");
        $this->load->model("admin/m_website");

        $data['category'] = $this->m_category->getCategoryList();
        $data['website'] = $this->m_website->getWebsiteList();

        //$data['allCategory'] = $this->load->view("admin/Campaign/all-Campaign", $data, TRUE);
        $data['PageContent'] = $this->load->view("admin/campaign/add-campaign-post", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function getPost() {
        //get all post from db that is related to campaign and vice versa
        $this->load->model("admin/m_post");
        $request = $this->input->post();
        if ($request) {

            $data['posts'] = $this->m_campaign->get_post_camp($request);
            echo json_encode($data['posts']);
        }

        return;
    }

    public function addpostToCampaign() {

        //add a post to campaign
        $request = $this->input->post();
        if ($request) {

            $json = array();
            $campaign_id = $request['campaign_id'];
            $post_id = $request['post_id'];
            if ($this->m_campaign->addpostToCampaign($campaign_id, $post_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Post Added To camapign";
                $json['data'] = $request;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Post not Added To camapign";
            }

            echo json_encode($json);
        }
    }

    public function do_upload($user_file, $folder = "post") {
        $data = array();

        $config['upload_path'] = APPPATH . "../upload/" . $folder;
        $config['allowed_types'] = 'gif|jpg|png|mp3';
//        $config['max_size'] = 100;
//        $config['max_width'] = 1024;
//        $config['max_height'] = 768;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($user_file)) {
            $data = array('error' => $this->upload->display_errors());
//            echo '<pre>';
//            print_r($error);
            // $this->load->view('upload_form', $error); 
        } else {
            $data = array('upload_data' => $this->upload->data());
            // $this->load->view('upload_success', $data); 
        }

        return $data;
    }

}
