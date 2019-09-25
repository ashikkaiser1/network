<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
        $this->load->library("common/com");
        $this->com->is_advertiser();
//        $this->com->is_admin();
        //end
        $this->load->model("admin/m_campaign");
        $this->load->model("admin/m_users");
        $this->load->model("account/m_account");
        $this->load->helper("form");
        $this->load->model("admin/m_category");
        $this->load->model("admin/m_post");
        $this->load->model("admin/m_website");
        $this->load->model("admin/m_pay_type");
    }

    public function CreateOffers($request = array()) {

        //step one 
        $this->load->helper("form");
        if (empty($request))
            $request = $this->input->post();

        if ($request) {
            $json = array();

            $campaign = array();

            $campaign['campaign_name'] = isset($request['campaign_name']) ? $request['campaign_name'] : '';
            $campaign['advertiser_id'] = isset($request['advertiser_id']) ? $request['advertiser_id'] : UID;
            $campaign['start_date'] = isset($request['start_date']) && $request['start_date'] != '' ? date(OFFER_DATE_FROMAT, strtotime($request['start_date'])) : date(OFFER_DATE_FROMAT, time());
            $campaign['end_date'] = isset($request['end_date']) && $request['end_date'] != '' ? date(OFFER_DATE_FROMAT, strtotime($request['end_date'])) : date(OFFER_DATE_FROMAT, strtotime("+30 day"));
            $campaign['cap'] = isset($request['cap']) ? $request['cap'] : 0;
            $campaign['manager'] = isset($request['manager']) ? $request['manager'] : 0;

            $campaign['revenue_type'] = isset($request['revenue_type']) ? $request['revenue_type'] : 0;
            $campaign['revenue_cost'] = isset($request['revenue_cost']) ? $request['revenue_cost'] : 0;

            $campaign['payout_type'] = isset($request['payout_type']) ? $request['payout_type'] : 0;
            $campaign['payout_cost'] = isset($request['payout_cost']) ? $request['payout_cost'] : 0;
            if (defined('COMM_PERCENTAGE') && COMM_PERCENTAGE != 0) {
                $getAveraageRevenueCost = number_format((float) $campaign['revenue_cost'], 2, '.', '');
                $campaign['payout_cost'] = $getAveraageRevenueCost - (($getAveraageRevenueCost * COMM_PERCENTAGE) / 100);
            }




            $campaign['redirection'] = isset($request['redirection']) ? $request['redirection'] : 0;
            $campaign['redirectUrl'] = isset($request['redirectUrl']) ? $request['redirectUrl'] : 0;

            $campaign['status'] = isset($request['status']) ? $request['status'] : 0;
            $campaign['p_type'] = isset($request['p_type']) ? $request['p_type'] : 0;
            $campaign['ctype'] = OFFER;
            $campaign['req_approval'] = isset($request['req_approval']) ? $request['req_approval'] : 0;
            $campaign['geo'] = isset($request['geo']) ? $request['geo'] : 0;
            $campaign['private'] = isset($request['private']) ? $request['private'] : 0;
            $campaign['conv_status'] = isset($request['conv_status']) ? $request['conv_status'] : 0;
            $campaign['click_span'] = isset($request['click_span']) ? $request['click_span'] : 0;

            $campaign['all_os'] = isset($request['Alloffer_OS']) && !empty($request['Alloffer_OS']) ? 0 : 1;
            $campaign['all_devices'] = isset($request['Alloffer_devices']) && !empty($request['Alloffer_devices']) ? 0 : 1;


//            echo '<pre>';
//
//            print_r($campaign);
            $campaign_id = 0;
            if ($campaign_id = $this->m_campaign->CreateCampaign($campaign)) {
                //redirection setup

                if (isset($request['redirection']) && isset($request['r_campaign_id']) && $request['r_campaign_id'] != '') {
                    $offerRedirect = array();
                    $offerRedirect['campaign_id'] = $campaign_id;
                    $offerRedirect['r_campaign_id'] = $request['r_campaign_id'];
                    $this->m_campaign->offer_redirection_setup($offerRedirect);
                }

                //end redirection set up end
                //
                
                //set Cap Dail ,omnth
                $this->setUpCampaignToCap($campaign_id);
                //end
                ///  
                //create a post //oofer

                $post = array();
                $post['web_id'] = isset($request['web_id']) ? $request['web_id'] : 0;
                $post['preview_link'] = isset($request['preview_link']) ? $request['preview_link'] : '';
                if (isset($request['baseUrl_slug']) && $request['baseUrl_slug'] != '') {
                    $request['url_slug'] = base64_decode($request['baseUrl_slug']);
                }
                $post['url_slug'] = isset($request['url_slug']) ? $request['url_slug'] : '';
                $post['title'] = isset($request['campaign_name']) ? $request['campaign_name'] : '';
                $post['meta'] = isset($request['meta']) ? $request['meta'] : '';
                $post['status'] = isset($request['status']) ? $request['status'] : 0;
                $post['type'] = OFFER;


                $image = $this->do_upload("image");
                if (!isset($image['error'])) {
                    $post['image'] = UPLOAD . "post/" . $image['upload_data']['file_name'];
                }

                $category_ids = isset($request['category_id']) ? $request['category_id'] : 0;

                unset($post['category_id']);
                unset($post['campaign_id']);
                $json = array();
                $post_id = 0;

                //offer country

                $offer_country = isset($request['offer_country']) ? $request['offer_country'] : array();

                ////ebd 
//                echo '<pre>';
//
//            print_r($post);

                if ($post_id = $this->m_post->CreatePost($post)) {
                    $this->m_campaign->addpostToCampaign($campaign_id, $post_id);
                    if ($campaign['geo'] == 0) {
                        $this->m_campaign->addOfferCountry($campaign_id, $offer_country);
                    }

                    if (is_array($category_ids) && !empty($category_ids)) {
                        if ($this->m_category->category_to_post($category_ids, $post_id)) {
                            
                        }
                    }

                    //this is for auto approve offer to all publishers when requireed approval is disable
                    $this->setOfferApprovalSettings($campaign, $campaign_id);
                }

                //post created







                $json['success'] = TRUE;
                $json['msg'] = "Your new offer is added.";
                //$json['redirect'] = SITEURL . "advertiser/campaign/offerRequest/" . $campaign_id;
                $json['redirect'] = SITEURL . "advertiser/offer/SetOfferCreative/" . $campaign_id;
                $json['post_id'] = $post_id;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your new offer can be added.";
            }
            if (isset($request['return']) && $request['return'])
                return $json;

            echo json_encode($json);
            return;
        }


        //check if account balance is not zero
        $this->load->model("advertiser/m_payment");
        $data['user_balance'] = $this->m_payment->getUserCurrentBalance(UID);
        if (empty($data['user_balance'])) {
            redirect(SITEURL . "advertiser/payment/my_payments");
        }
        if (!empty($data['user_balance'])) {
            if ($data['user_balance'] <= 0)
                redirect(SITEURL . "advertiser/payment/my_payments");
        }
        //end of chekc ign


        $data = array();
        $rev_filter = array();


        //country //
        $filter = array();
        $filter['formated'] = TRUE;
        $data['country'] = $this->m_account->getCountry($filter);

        //end country

        $rev_filter['type'] = PAYOUT;
        $rev_filter['formated'] = TRUE;
        $data['payout'] = $this->m_pay_type->getPayType($rev_filter);

        $rev_filter['type'] = REVENUE;
        $rev_filter['formated'] = TRUE;
        $data['revenue'] = $this->m_pay_type->getPayType($rev_filter);


//        $filter = array();
//        $filter['UTID'] = ACC_MANAGER;
//        $filter['listFormated'] = "TRUE";
//        $data['AccManager'] = $this->m_users->getUsers($filter);
//        $filters = array();
//        $filters['UTID'] = ADVERTISER;
////        echo ADVERTISER;
////        die();
//        $filters['listFormated'] = TRUE;
//        $data['affiliates'] = $this->m_users->getUsers($filters);
//        echo '<pre>';
//        print_r($data);
//        die();


        $data['FormAction'] = SITEURL . "advertiser/offer/CreateOffers";
        $data['SubmitBtn'] = "Create";
        $data['Submiting'] = "Creating...";
        $data['title'] = "Create new Offer";
        $data['category'] = $this->m_category->getCategoryList();
        $data['website'] = $this->m_website->getWebsiteList();


        //redirection offer

        $filter = array();
        $filter['type'] = OFFER;
        $filter['Formated'] = "TRUE";
        $filter['status'] = 1;
        $filter['advertiser_id'] = array(UID);
        $filter['group_by'] = 'campaign_id';
        $data['offers'] = $this->m_campaign->getCampaign($filter);

        $data['camapign_status'] = $this->config->item("campaign_status");
        $data['p_type'] = $this->config->item("p_type");

        $data['private'] = array("0" => "Disable", "1" => "Enable");

        //end redirection offer
        // $data['Campaign'] = $this->m_campaign->getCategory(0,array("allchild"=>true));
        //$data['allCategory'] = $this->load->view("admin/Campaign/all-Campaign", $data, TRUE);
        $data['PageContent'] = $this->load->view("advertiser/offer/create/add-offer", $data, TRUE);
        $this->load->view("advertiser/template", $data);
    }

    public function CopyOffer($campaign_id = 0, $copy = 0) {
        $this->UpdateOffers($campaign_id, $copy);
    }

    public function setOfferDevices($camapign_id = 0) {
        //this function set up the respective devices id in db which 
        // the admin selected .
        //receiver variable offer_devices[] , Alloffer_devices

        $offer_devices = $this->input->post("offer_devices");
        if ($offer_devices && !empty($offer_devices) && is_array($offer_devices) && $camapign_id) {
            $offer_devicesBatch = array();
            foreach ($offer_devices as $val) {
                $offer_devicesBatch[] = array(
                    "campaign_id" => $camapign_id,
                    "device_id" => $val
                );
            }

            $this->m_campaign->setOfferDevices($offer_devicesBatch, $camapign_id);

            return TRUE;
        }

        return FALSE;
    }

    //end of offer device setting


    public function setOfferOS($camapign_id = 0) {
        //this function set up the respective OS in db which 
        // the admin selected .
        //receiver variable offer_OS[] , Alloffer_OS

        $offer_OS = $this->input->post("offer_OS");
        if ($offer_OS && !empty($offer_OS) && is_array($offer_OS) && $camapign_id) {
            $offer_OSBatch = array();
            foreach ($offer_OS as $val) {
                $offer_OSBatch[] = array(
                    "campaign_id" => $camapign_id,
                    "os_name" => $val
                );
            }

            $this->m_campaign->setOfferOS($offer_OSBatch, $camapign_id);

            return TRUE;
        }

        return FALSE;
    }

    public function setUpCampaignToCap($campaign_id = 0) {

        $request = $this->input->post();
        if ($request && $campaign_id) {
            $CampToCap = array();
            $CampToCap[] = array("campaign_id" => $campaign_id,
                "capType" => isset($request['daily_cap']) ? 1 : 0,
                "cap" => isset($request['daily_cap']) ? $request['daily_cap'] : 0,
                "budget" => isset($request['daily_budget']) ? $request['daily_budget'] : 0,
                "status" => 1
            );


            $CampToCap[] = array("campaign_id" => $campaign_id,
                "capType" => isset($request['monthly_cap']) ? 2 : 0,
                "cap" => isset($request['monthly_cap']) ? $request['monthly_cap'] : 0,
                "budget" => isset($request['monthly_budget']) ? $request['monthly_budget'] : 0,
                "status" => 1
            );

            $this->m_campaign->setCampaignToCaps($CampToCap);
        }
    }

    public function UpdateOffers($campaign_id = 0, $copy = 0) {
        //Direct Offer update
        $this->load->helper("form");
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

            $campaign['redirection'] = isset($request['redirection']) ? $request['redirection'] : 0;
            $campaign['redirectUrl'] = isset($request['redirectUrl']) ? $request['redirectUrl'] : 0;
            $campaign['private'] = isset($request['private']) ? $request['private'] : 0;
            $campaign['conv_status'] = isset($request['conv_status']) ? $request['conv_status'] : 0;
            $campaign['p_type'] = isset($request['p_type']) ? $request['p_type'] : 0;



            $campaign['status'] = isset($request['status']) ? $request['status'] : 0;
            $campaign['req_approval'] = isset($request['req_approval']) ? $request['req_approval'] : 0;
            $campaign['ctype'] = OFFER;
            $campaign['geo'] = isset($request['geo']) ? $request['geo'] : 0;
            $campaign['click_span'] = isset($request['click_span']) ? $request['click_span'] : 0;


            //post
            $post = array();
            $post['web_id'] = isset($request['web_id']) ? $request['web_id'] : 0;
            $post['preview_link'] = isset($request['preview_link']) ? $request['preview_link'] : '';
            if (isset($request['baseUrl_slug']) && $request['baseUrl_slug'] != '') {
                $request['url_slug'] = base64_decode($request['baseUrl_slug']);
            }
            $post['url_slug'] = isset($request['url_slug']) ? $request['url_slug'] : '';
            $post['title'] = isset($request['campaign_name']) ? $request['campaign_name'] : '';
            $post['meta'] = isset($request['meta']) ? $request['meta'] : '';
            $post['status'] = isset($request['status']) ? $request['status'] : 0;
            $post['type'] = OFFER;


            $image = $this->do_upload("image");
            if (!isset($image['error'])) {
                $post['image'] = UPLOAD . "post/" . $image['upload_data']['file_name'];
            }

            $category_ids = isset($request['category_id']) ? $request['category_id'] : 0;

            unset($post['category_id']);
            unset($post['campaign_id']);

            //offer country
            $offer_country = isset($request['offer_country']) ? $request['offer_country'] : array();

            ////ebd 
            //start updating
            $this->m_campaign->addOfferCountry($campaign_id, $offer_country);
            //updating end

            $post_id = 0;
            if (isset($request['post_id'])) {
                $post_id = isset($request['post_id']);
            } else {
                $post_data = $this->m_campaign->get_post_camp(array("campaign_id" => $campaign_id));
                if (isset($post_data[0]) && isset($post_data[0]['post_id']))
                    $post_id = $post_data[0]['post_id'];
            }


            if ($this->m_post->UpdatePost($post, $post_id) || $this->m_category->category_to_post_update($category_ids, $post_id) || $this->m_campaign->updatepostTocampaign($campaign_id, $post_id)
            ) {
                $json['success'] = TRUE;
                $json['msg'] = "Your Offer is update.";
            }


            //redirection update
            if (isset($request['redirection']) && isset($request['r_campaign_id']) && $request['r_campaign_id'] != '') {
                $offerRedirect = array();
                $offerRedirect['campaign_id'] = $campaign_id;
                $offerRedirect['r_campaign_id'] = $request['r_campaign_id'];
                $this->m_campaign->offer_redirection_setup($offerRedirect);
            }

            //end redirect update    





            if ($this->m_campaign->UpdateCampaign($campaign, $campaign_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your Offer is update.";
                $json['redirect'] = SITEURL . "advertiser/campaign/offerRequest/" . $campaign_id;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your Offer can't be update.";
            }
            if (isset($request['return']) && $request['return'])
                return $json;
            echo json_encode($json);
            return;
        }


        $data = array();


        //country //
        $filter = array();
        $filter['formated'] = TRUE;
        $data['country'] = $this->m_account->getCountry($filter);

        //end country


        $CampFilter = array();
        $CampFilter['campaign_id'] = $campaign_id;
        $data['campaign'] = $this->m_campaign->getCampaign($CampFilter);
        $data['campaign']['r_campaign_id'] = $this->m_campaign->getRedirectOffer($CampFilter);
        //$this->m_campaign->getRedirectOffer($CampFilter['campaign_id'] );

        $data['offer_country'] = array_column($this->m_campaign->getOfferCountry($CampFilter), "country_id");

        $post_id = $this->m_campaign->getPost_id($CampFilter);
        $post = $this->m_post->getPostForUpdate($post_id);

        $rev_filter = array();
        $rev_filter['type'] = REVENUE;
        $rev_filter['formated'] = TRUE;
        $data['revenue'] = $this->m_pay_type->getPayType($rev_filter);

        $rev_filter['type'] = PAYOUT;
        $rev_filter['formated'] = TRUE;
        $data['payout'] = $this->m_pay_type->getPayType($rev_filter);


        $filter = array();
        $filter['UTID'] = ACC_MANAGER;
        $filter['listFormated'] = "TRUE";
        $data['AccManager'] = $this->m_users->getUsers($filter);



        //redirection offer

        $filter = array();
        $filter['type'] = OFFER;
        $filter['Formated'] = "TRUE";
        $filter['status'] = 1;
        $data['offers'] = $this->m_campaign->getCampaign($filter);

        //end redirection offer



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
        if ($copy) {
            $data['FormAction'] = SITEURL . "advertiser/offer/CreateOffers/";
            $data['SubmitBtn'] = "Create";
            $data['Submiting'] = "Creating...";
            $data['title'] = "Create Offer";
        } else {
            $data['FormAction'] = SITEURL . "advertiser/offer/UpdateOffers/" . $campaign_id;
            $data['SubmitBtn'] = "Update";
            $data['Submiting'] = "Updating...";
            $data['title'] = "Update Offer";
        }
        $data['camapign_status'] = $this->config->item("campaign_status");
        $data['private'] = array("0" => "Disable", "1" => "Enable");
        $data['p_type'] = $this->config->item("p_type");


        // $data['Campaign'] = $this->m_campaign->getCategory(0,array("allchild"=>true));
        //$data['allCategory'] = $this->load->view("admin/Campaign/all-Campaign", $data, TRUE);
        $data['PageContent'] = $this->load->view("advertiser/offer/create/add-offer", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function deleteCampaign() {
        //delete the campaing 

        $request = $this->input->post();

        if ($request) {
            $json = array();
            $campaign_id = $request['campaign_id'];
            // $request['status'] = isset($request['status']) ? 1 : 0;
            if ($this->m_campaign->deleteCampaign($campaign_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your campaign is deleted.";

                $json['data'] = $request;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your campaign canot be deleted.";
            }

            echo json_encode($json);
            return;
        }
    }

    public function delPostFromCamp() {
//        delete or remove the post from campaign that is attach to it
        $request = $this->input->post();
        if ($request) {
            $json = array();

            if ($this->m_campaign->delPostFromCamp($request)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your post is removed from campaign.";

                $json['data'] = $request;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your  post canot be removed from campaign.";
            }

            echo json_encode($json);
            return;
        }
    }

    public function show_campaign() {
        //show the avilabele campaignss....
        $data = array();
        $request = $this->input->post();
        if ($request) {
            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;


            $data['campaign'] = $this->m_campaign->getCampaign($request);
            echo json_encode($data['campaign']);
            return;
        }
        //$data['allCategory'] = $this->load->view("admin/Campaign/all-Campaign", $data, TRUE);
        $filter = array();
        $filter['listFormated'] = TRUE;
        $filter['UTID'] = ADVERTISER;
        $data['advertiser'] = $this->m_users->getUsers($filter);
        $data['advertiser'] = array("" => "All") + $data['advertiser'];
        $data['ctype'] = array(OFFER => "ALL OFFERS");

        $data['stats_link'] = SITEURL . "advertiser/report/advance_report?repType=offers_report";
        $data['email_link'] = SITEURL . "advertiser/offer_email/index/";


        $data['PageContent'] = $this->load->view("admin/campaign/all-campaign", $data, TRUE);
        $this->load->view("admin/template", $data);
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

    public function setFeatureOffer() {
        ///set offers to featured offers

        $request = $this->input->post();
        if ($request) {
            $request['featured'] = 1;
            if ($this->m_campaign->UpdateCampaign($request, $request['campaign_id'])) {
                $json['success'] = TRUE;
                $json['msg'] = "Your Offer is set to featured .";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your Offer can't be set to featured .";
            }

            echo json_encode($json);
            return;
        }
    }

    public function featureofferRemove() {
        ///set offers to featured offers

        $request = $this->input->post();
        if ($request) {
            $request['featured'] = 0;
            if ($this->m_campaign->UpdateCampaign($request, $request['campaign_id'])) {
                $json['success'] = TRUE;
                $json['msg'] = "Your Offer is removed from featured .";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your Offer can't be removed from featured .";
            }

            echo json_encode($json);
            return;
        }
    }

    public function featureoffer() {
        //get featured offers

        $this->load->model("admin/m_featured_offers");
        $filter = array();
        $filter['Featured'] = 'TRUE';
        $data = array();
        $data['featureOffer'] = $this->m_featured_offers->getFeaturedOffers($filter);

        echo json_encode($data);
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

    public function campaign_name_suggetions() {

        $request = $this->input->post();
        if ($request && isset($request['phrase'])) {
            $request['campaign_name'] = $request['phrase'];
            $request['limit'] = 1;
            $data['offers'] = $this->m_campaign->getCampaign($request);

//             echo "<pre>";
//             print_r($data);

            $json = array();
            foreach ($data['offers'] as $row) {
//                 print_r($row);
//                 ." in {$row['category_name']}"
                $json[] = array("name" => $row['campaign_name'],
//                    "category" => $row['category_name'],
//                    "category_id" => $row['category_id']
                );
            }

            echo json_encode($json);
        }
    }

    public function bulkupdate() {
        //Admin can bulk update the status of users 
        //from All Affiliate,All Admisni.allEmployrr or all acc manager
        $getRequest = $this->input->get();
        $json = array();
        $json['success'] = FALSE;
        $json['msg'] = "Incomplete Request.";
        if ($getRequest) {
            $request = $this->input->post();

            $request['status'] = isset($getRequest['status']) ? $getRequest['status'] : 0;
            $uid = isset($request['campaign_id']) ? $request['campaign_id'] : 0;
            unset($request['campaign_id']);

            $CampaignData = array();
            $CampaignData['status'] = $request['status'];

            if ($this->m_campaign->UpdateCampaign($CampaignData, $uid)) {
                $json['success'] = TRUE;
                $json['msg'] = "Update Complete";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Update Incomplete.";
            }
        }


        echo json_encode($json);
    }

    //update offer 
    //payout update

    public function UpdateOfferPayout($campaign_id = 0) {
        //Direct Offer Payout update
        $this->load->helper("form");
        $request = $this->input->post();

        if ($request) {
            $json = array();

            $campaign = array();


            $campaign['revenue_type'] = isset($request['revenue_type']) ? $request['revenue_type'] : 0;
            $campaign['revenue_cost'] = isset($request['revenue_cost']) ? $request['revenue_cost'] : 0;

            $campaign['payout_type'] = isset($request['payout_type']) ? $request['payout_type'] : 0;
            $campaign['payout_cost'] = isset($request['payout_cost']) ? $request['payout_cost'] : 0;
            if (defined('COMM_PERCENTAGE') && COMM_PERCENTAGE != 0) {
                $getAveraageRevenueCost = number_format((float) $campaign['revenue_cost'], 2, '.', '');
                $campaign['payout_cost'] = $getAveraageRevenueCost - (($getAveraageRevenueCost * COMM_PERCENTAGE) / 100);
            }

            $this->setUpCampaignToCap($campaign_id);

            if ($this->m_campaign->UpdateCampaign($campaign, $campaign_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your Offer Payout is update.";
                $json['redirect'] = SITEURL . "advertiser/campaign/offerRequest/" . $campaign_id;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your Offer Payout can't be update.";
            }

            echo json_encode($json);
            return;
        }


        $data = array();



        //end country


        $CampFilter = array();
        $CampFilter['campaign_id'] = $campaign_id;
        $data['campaign'] = $this->m_campaign->getCampaign($CampFilter);
        $CampFilter['order_by'] = $campaign_id;
        $data['campToCaps'] = $this->m_campaign->getCampaignToCaps($CampFilter);

        if (!empty($data['campToCaps'])) {
            $campToCaps = array();
            foreach ($data['campToCaps'] as $row) {

                $campToCaps[$row['capType']] = $row;
            }
            $data['campToCaps'] = $campToCaps;
        }

        unset($CampFilter['order_by']);
        $post_id = $this->m_campaign->getPost_id($CampFilter);
        $post = $this->m_post->getPostForUpdate($post_id);

        $rev_filter = array();
        $rev_filter['type'] = REVENUE;
        $rev_filter['formated'] = TRUE;
        $data['revenue'] = $this->m_pay_type->getPayType($rev_filter);

        $rev_filter['type'] = PAYOUT;
        $rev_filter['formated'] = TRUE;
        $data['payout'] = $this->m_pay_type->getPayType($rev_filter);



        $data['FormAction'] = SITEURL . "advertiser/offer/UpdateOfferPayout/" . $campaign_id;
        $data['SubmitBtn'] = "Update";
        $data['Submiting'] = "Update...";
        $data['title'] = "Update Offer Payout";

        $data['PageContent'] = $this->load->view("advertiser/offer/create/offer_edit/payout_edit", $data, TRUE);
        $this->load->view("advertiser/template", $data);
    }

    //end of payout update
    //start offer details update

    public function UpdateOfferDetails($campaign_id = 0) {
        //Direct Offer update
        $this->load->helper("form");
        $request = $this->input->post();

        if ($request) {
            $json = array();

            $campaign = array();

            $campaign['campaign_name'] = isset($request['campaign_name']) ? $request['campaign_name'] : '';
//            $campaign['advertiser_id'] = isset($request['advertiser_id']) ? $request['advertiser_id'] : 0;
//            $campaign['start_date'] = isset($request['start_date']) ? $request['start_date'] : '';
//            $campaign['end_date'] = isset($request['end_date']) ? $request['end_date'] : '';
            $campaign['start_date'] = isset($request['start_date']) && $request['start_date'] != '' ? date(OFFER_DATE_FROMAT, strtotime($request['start_date'])) : date(OFFER_DATE_FROMAT, time());
            $campaign['end_date'] = isset($request['end_date']) && $request['end_date'] != '' ? date(OFFER_DATE_FROMAT, strtotime($request['end_date'])) : date(OFFER_DATE_FROMAT, strtotime("+30 day"));

            $campaign['cap'] = isset($request['cap']) ? $request['cap'] : 0;



            $campaign['redirection'] = isset($request['redirection']) ? $request['redirection'] : 0;
            $campaign['redirectUrl'] = isset($request['redirectUrl']) ? $request['redirectUrl'] : 0;
            $campaign['private'] = isset($request['private']) ? $request['private'] : 0;
            $campaign['conv_status'] = isset($request['conv_status']) ? $request['conv_status'] : 0;




            $campaign['status'] = isset($request['status']) ? $request['status'] : 0;
            $campaign['req_approval'] = isset($request['req_approval']) ? $request['req_approval'] : 0;
            $campaign['ctype'] = OFFER;

//            echo '<pre>';
//            print_r($campaign);
//            die();
            //post
            $post = array();

            $post['preview_link'] = isset($request['preview_link']) ? $request['preview_link'] : '';
            if (isset($request['baseUrl_slug']) && $request['baseUrl_slug'] != '') {
                $request['url_slug'] = base64_decode($request['baseUrl_slug']);
            }
            $post['url_slug'] = isset($request['url_slug']) ? $request['url_slug'] : '';
            //die();
            $post['title'] = isset($request['campaign_name']) ? $request['campaign_name'] : '';
            $post['meta'] = isset($request['meta']) ? $request['meta'] : '';
            $post['status'] = isset($request['status']) ? $request['status'] : 0;
            $post['type'] = OFFER;


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
                $json['msg'] = "Your Offer Detials is update.";
            }


            //redirection update
            if ($request['redirection'] && isset($request['r_campaign_id']) && $request['r_campaign_id'] != '') {
                $offerRedirect = array();
                $offerRedirect['campaign_id'] = $campaign_id;
                $offerRedirect['r_campaign_id'] = $request['r_campaign_id'];
                $this->m_campaign->offer_redirection_setup($offerRedirect);
            }

            //end redirect update    

            $this->setOfferApprovalSettings($campaign, $campaign_id);




            if ($this->m_campaign->UpdateCampaign($campaign, $campaign_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your Offer Details is update.";
                $json['redirect'] = SITEURL . "advertiser/campaign/offerRequest/" . $campaign_id;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your Offer Details can't be update.";
            }

            echo json_encode($json);
            return;
        }


        $data = array();

        $CampFilter = array();
        $CampFilter['campaign_id'] = $campaign_id;
        $data['campaign'] = $this->m_campaign->getCampaign($CampFilter);
        $data['campaign']['r_campaign'] = $this->m_campaign->getRedirectOffer($CampFilter);
        //$this->m_campaign->getRedirectOffer($CampFilter['campaign_id'] );


        $post_id = $this->m_campaign->getPost_id($CampFilter);
        $post = $this->m_post->getPostForUpdate($post_id);




        $filter = array();
        $filter['UTID'] = ACC_MANAGER;
        $filter['listFormated'] = "TRUE";
        $data['AccManager'] = $this->m_users->getUsers($filter);



        //redirection offer

        $filter = array();
        $filter['type'] = OFFER;
        $filter['Formated'] = "TRUE";
        $filter['status'] = 1;
        $filter['group_by'] = "campaign_id";
        $data['offers'] = array();
//                $this->m_campaign->getCampaign($filter);
        //end redirection offer



        if (isset($post))
            $data['post'] = $post;


//        echo "<pre>";
//        print_r($data['post']);

        $data['category'] = $this->m_category->getCategoryList();

        $filters = array();
        $filters['UTID'] = ADVERTISER;
        $filters['listFormated'] = TRUE;
        $data['affiliates'] = $this->m_users->getUsers($filters);


        $data['FormAction'] = SITEURL . "advertiser/offer/UpdateOfferDetails/" . $campaign_id;
        $data['SubmitBtn'] = "Update";
        $data['Submiting'] = "Updating...";
        $data['title'] = "Update Offer Details";

        $data['camapign_status'] = $this->config->item("campaign_status");
        $data['private'] = array("0" => "Disable", "1" => "Enable");

        // $data['Campaign'] = $this->m_campaign->getCategory(0,array("allchild"=>true));
        //$data['allCategory'] = $this->load->view("admin/Campaign/all-Campaign", $data, TRUE);
        $data['PageContent'] = $this->load->view("advertiser/offer/create/offer_edit/offer_details", $data, TRUE);
        $this->load->view("advertiser/template", $data);
    }

    //end of offer details update
    //Offer approval auton
    public function setOfferApprovalSettings($campaign, $campaign_id = 0) {
        //this is for auto approve offer to all publishers when requireed approval is disable
        if (isset($campaign['req_approval'])) {
            $this->load->model("admin/m_offer_permission");
            $pub_filter = array();
            $pub_filter['UTID'] = AFFILIATE;
            $data['publisher'] = $this->m_users->getUsers($pub_filter);
            $uids = array_column($data['publisher'], "uid");
            if ($campaign['req_approval'] == 0) {
                $this->m_offer_permission->setApprovePublisher($uids, $campaign_id, 1);
            } else {
                $filter = array();
                $filter['uid'] = $uids;
                $filter['campaign_id'] = $campaign_id;
                $this->m_offer_permission->delete_offer_approvalData($filter);
            }
        }
        //end  
    }

    //end


    public function setGeoTargetting($campaign_id = 0) {
        //Update or set Geo Targeting
        $this->load->helper("form");
        $request = $this->input->post();
        $data = array();

        if ($request) {
            $json = array();
            $campaign = array();
            $campaign['geo'] = isset($request['geo']) || empty($request['offer_country']) ? 1 : 0;
            //offer country
            $offer_country = isset($request['offer_country']) ? $request['offer_country'] : array();


            $campaign['all_os'] = isset($request['Alloffer_OS']) || empty($request['offer_OS']) ? 1: 0;
            $campaign['all_devices'] = isset($request['Alloffer_devices']) || empty($request['offer_devices']) ? 1 : 0;

            //start Offer DEvice setting

            if (!(isset($request['Alloffer_devices']))) {
                $this->setOfferDevices($campaign_id);
            } else {
                $this->m_campaign->deleteOfferDevices($campaign_id);
            }

            //
            //end of offer device Setting
            //
                //start set offerOs
            if (!(isset($request['Alloffer_OS']))) {
                $this->setOfferOS($campaign_id);
            } else {
                $this->m_campaign->deleteOfferOS($campaign_id);
            }

            //end
            ////ebd 
            //start updating
            $this->m_campaign->addOfferCountry($campaign_id, $offer_country);
            //updating end

            if ($this->m_campaign->UpdateCampaign($campaign, $campaign_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your Offer Geo is update.";
                $json['redirect'] = SITEURL . "advertiser/campaign/offerRequest/" . $campaign_id;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your Offer Geo can't be update.";
            }

            echo json_encode($json);

            return;
        }

        if ($campaign_id) {
            //country //
            $filter = array();
            $filter['formated'] = TRUE;
            $data['country'] = $this->m_account->getCountry($filter);
            //end country

            $CampFilter = array();
            $CampFilter['campaign_id'] = $campaign_id;
            $data['campaign'] = $this->m_campaign->getCampaign($CampFilter);
            $data['offer_country'] = array_column($this->m_campaign->getOfferCountry($CampFilter), "country_id");

            $data['offer_devices'] = array_column($this->m_campaign->getOfferDevices($CampFilter), "device_id");
            $data['offer_os'] = array_column($this->m_campaign->getOfferOS($CampFilter), "os_name");
        }

        $data['FormAction'] = SITEURL . "advertiser/offer/setGeoTargetting/" . $campaign_id;
        $data['SubmitBtn'] = "Save";
        $data['Submiting'] = "Saving...";
        $data['title'] = "Offer Geo Targeting";
        $data['PageContent'] = $this->load->view("advertiser/offer/create/offer_edit/offer_geo_target", $data, TRUE);
        $this->load->view("advertiser/template", $data);
    }

    //end of code..


    public function SetOfferCreative($campaign_id = 0) {
        //set ou uload new creatives to offers  
        $data = array();
        if ($campaign_id) {
            $this->load->model("admin/m_creative");
            $filterCreavtive = array();
            $filterCreavtive['campaign_id'] = $campaign_id;
            $data['OfferCreative'] = $this->m_creative->getOfferCreative($filterCreavtive);


            $CampFilter = array();
            $CampFilter['campaign_id'] = $campaign_id;
            $data['campaign'] = $this->m_campaign->getCampaign($CampFilter);
            $data['campaign_id'] = $campaign_id;
        }

        $data['PageContent'] = $this->load->view("admin/offer/offer_edit/offer_creative", $data, TRUE);
        $this->load->view("admin/template", $data);

        //end of code
    }

}
