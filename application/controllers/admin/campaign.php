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
class campaign extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com");
        $this->com->is_admin();
        //end
        $this->load->model("admin/m_campaign");
        $this->load->model("admin/m_users");
        $this->load->helper("form");
        $this->load->model("admin/m_pay_type");
        $this->load->model("admin/m_goals");
        $this->load->model("admin/m_creative");
        $this->load->model("admin/m_user_group");
    }

    public function CreateCampaign() {
//        $this->load->helper("form");


        $request = $this->input->post();

        if ($request) {
            $json = array();

            if ($this->m_campaign->CreateCampaign($request)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your new Campaign is added.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your new Campaign can be added.";
            }

            echo json_encode($json);
            return;
        }


        $data = array();
        $rev_filter = array();
        $rev_filter['type'] = REVENUE;
        $rev_filter['formated'] = TRUE;
        $data['revenue'] = $this->m_pay_type->getPayType($rev_filter);

        $rev_filter['type'] = PAYOUT;
        $rev_filter['formated'] = TRUE;
        $data['payout'] = $this->m_pay_type->getPayType($rev_filter);



        $filters = array();
        $filters['UTID'] = ADVERTISER;
        $filters['listFormated'] = TRUE;
        $data['affiliates'] = $this->m_users->getUsers($filters);

        $data['FormAction'] = SITEURL . "admin/campaign/CreateCampaign";
        $data['SubmitBtn'] = "Create";
        $data['Submiting'] = "Creating...";
        $data['title'] = "Create new Camapaign";

        // $data['Campaign'] = $this->m_campaign->getCategory(0,array("allchild"=>true));
        //$data['allCategory'] = $this->load->view("admin/Campaign/all-Campaign", $data, TRUE);
        $data['PageContent'] = $this->load->view("admin/campaign/add-campaign", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function UpdateCampaign($campaign_id = 0) {
//        $this->load->helper("form");
        $request = $this->input->post();

        if ($request) {
            $json = array();
            if ($this->m_campaign->UpdateCampaign($request, $campaign_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your Campaign is update.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your Campaign can't be update.";
            }

            echo json_encode($json);
            return;
        }


        $data = array();
        $CampFilter = array();
        $CampFilter['campaign_id'] = $campaign_id;
        $data['campaign'] = $this->m_campaign->getCampaign($CampFilter);


        $rev_filter = array();
        $rev_filter['type'] = REVENUE;
        $rev_filter['formated'] = TRUE;
        $data['revenue'] = $this->m_pay_type->getPayType($rev_filter);

        $rev_filter['type'] = PAYOUT;
        $rev_filter['formated'] = TRUE;
        $data['payout'] = $this->m_pay_type->getPayType($rev_filter);


        $filters = array();
        $filters['UTID'] = ADVERTISER;
        $filters['listFormated'] = TRUE;
        $data['affiliates'] = $this->m_users->getUsers($filters);
        $data['FormAction'] = SITEURL . "admin/campaign/UpdateCampaign/" . $campaign_id;
        $data['SubmitBtn'] = "Update";
        $data['Submiting'] = "Updating...";
        // $data['Campaign'] = $this->m_campaign->getCategory(0,array("allchild"=>true));
        //$data['allCategory'] = $this->load->view("admin/Campaign/all-Campaign", $data, TRUE);
        $data['PageContent'] = $this->load->view("admin/campaign/add-campaign", $data, TRUE);
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
            $request['order_by'] = 'campaign_id';
            $request['group_by'] = 'campaign_id';

            $data['campaign'] = $this->m_campaign->getCampaign($request);
            echo json_encode($data['campaign']);
            return;
        }
        //$data['allCategory'] = $this->load->view("admin/Campaign/all-Campaign", $data, TRUE);
        $filter = array();
        $filter['listFormated'] = TRUE;
        $filter['UTID'] = ADVERTISER;
        $data['advertiser'] = $this->m_users->getUsers($filter);

        $data['ctype'] = array("" => "ALL", OFFER => "ALL OFFERS", NORMALCAMP => "ALL CAMPAIGNS");

        $data['PageContent'] = $this->load->view("admin/campaign/all-campaign", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function post_to_campaign($campaign_id = 0) {
        //view generate for set the post to campaign

        $data = array();
        $request = $this->input->post();
        if ($request) {
            $data['campaign'] = $this->m_campaign->getCampaign($request);

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

    public function offerRequest($campaign_id = 0) {
        //show offer request form to user to request the admin for offer approval.
        //offer details page for admin

        if ($campaign_id == 0 || !is_numeric($campaign_id)) {

            //if a user delete the campaign id from url and send blank and non numeric 
            // the it will show blank page
            return;
        }

        $request = $this->input->post();
        if ($request) {
            //the request is accepeted by affiliate_apply_for_offer function
        }
        //$this->m_campaign =null;
        // $this->load->model("affiliate/m_campaign", "aff_m_campaign");
//        echo '<pre>';
        $data = array();
        $data['campaign'] = $this->m_campaign->getOfferDetails($campaign_id);
        if (empty($data['campaign'])) {
            return;
        }


        //publisher 

        $pub_filter = array();
        $pub_filter['listFormated'] = "TRUE";
        $pub_filter['UTID'] = AFFILIATE;
        $data['publisher'] = $this->m_users->getUsers($pub_filter);
        unset($data['publisher']['']);

        //end pblisger lis
        //payout type list

        $rev_filter['type'] = PAYOUT;
        $rev_filter['formated'] = TRUE;
        $data['payoutList'] = $this->m_pay_type->getPayType($rev_filter);




        //end of payout type list
        //group drop dowm selection
        //end of group dropdown selection



        $county_filter = array();
        $county_filter['campaign_id'] = $campaign_id;

        if (isset($data['campaign']['geo']) && $data['campaign']['geo'] == 0) {
            $filter_con = array();
            $filter_con['countries'] = array_column($this->m_campaign->getOfferCountry($county_filter), "country_id");
            if (!empty($filter_con['countries']))
                $data['offer_country'] = array_column($this->m_campaign->getCountry($filter_con), 'name');
            else
                $data['offer_country'] = array();
        }

        $data['offer_goals'] = $this->m_goals->getGoals($county_filter);

        //offer goal helper
        //$this->load->model("admin/m_goals");

        $this->load->model("admin/m_pay_type");
        $rev_filter = array();

        $rev_filter['type'] = PAYOUT;
        $rev_filter['formated'] = TRUE;
        $data['payout'] = $this->m_pay_type->getPayType($rev_filter);

        $rev_filter['type'] = REVENUE;
        $rev_filter['formated'] = TRUE;
        $data['revenue'] = $this->m_pay_type->getPayType($rev_filter);

        //global goals
        $filter = array();
        $filter['Formated'] = "TRUE";
        $data['global_goals'] = $this->m_goals->getGlobalGoals($filter);

        //end of code
        $data['campaign_id'] = $campaign_id;
        $data['goals'] = $this->load->view("admin/offer/offer-details/offer_goals", $data, TRUE);

        $data['trackingPanel'] = $this->load->view("admin/offer/offer-details/offer_tracking_link", $data, TRUE);

        $data['offerApprovalPanel'] = $this->load->view("admin/offer/offer-details/offer-approval", $data, TRUE);

        $filterCreavtive = array();
        $filterCreavtive['campaign_id'] = $campaign_id;
        $data['OfferCreative'] = $this->m_creative->getOfferCreative($filterCreavtive);

        $data['creativePanel'] = $this->load->view("admin/offer/offer-details/offer_creative", $data, TRUE);

        $data['OfferUrls'] = $this->load->view("admin/offer/offer_url/all-offer-urls", $data, TRUE);

        $data['IpWhiteList'] = $this->load->view("admin/offer/offer_ip_whiteList/whitelist_ip", $data, TRUE);

        //Please veirfy aaign the code is used for check the approval sttaus for logged user
//        if (!$this->check_offer_approve($campaign_id, UID)) {
//            //if true it means offer is approved or no offer approval is required
//            //the show the genralte link form
//            $data['trackingPanel'] = $this->load->view("admin/offer/offer-details/offer_tracking_link", $data, TRUE);
//        } else if ($this->m_campaign->is_pending_request($campaign_id, UID)) {
//            //Request is pending and not approved;
//            $data['trackingPanel'] = "Your Reuest is pending";
//        } else {
//            $data['trackingPanel'] = $this->load->view("admin/offer/offer-details/offer_request_form", $data, TRUE);
//        }
        //ened of code

        $data['payout'] = $this->load->view("admin/offer/offer-details/offer_payout", $data, TRUE);

        $data['getTargeting'] = $this->load->view("admin/offer/offer-details/offer_geo", $data, TRUE);
//        print_r($data);
//        die();


        $data['PageContent'] = $this->load->view("admin/offer/offer-details/offer-details", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function check_offer_approve($campaign_id = 0, $uid = 0) {

        //funcation is used for check the offer is approved or not .. or by default approved for all

        if ($this->m_campaign->check_offerApproval($campaign_id)) {
            //true means the offer is not require any approval
            $filter = array();
            $filter['status'] = 1;
            if ($this->m_campaign->offerApprovedForUser($campaign_id, $uid, $filter)) {
                //if true the ogffer is available for user
                return FALSE;
            } else {

                return TRUE;
                //offer not available for user please send a request to admin
            }
        }

        return FALSE;

        //return FALSE;
        //send use the message to please send an approval to the admin for this offer
        //false means offer required approval  and system the check tthat the offer is enable for uid or not
    }

    public function show_request() {

        //show the offer request application from publisher to advertiser
        //this function show all reuest in tablur form 
        //$data['allCategory'] = $this->load->view("admin/Campaign/all-Campaign", $data, TRUE);
        $request = $this->input->post();
        if ($request) {
            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            $data['campaign'] = $this->m_campaign->getOfferRequest($request);
            echo json_encode($data['campaign']);
            return;
        }

        $filter = array();
        $filter['listFormated'] = TRUE;
        $filter['UTID'] = ADVERTISER;
        $data['advertiser'] = $this->m_users->getUsers($filter);

        $data['ctype'] = array("" => "ALL", OFFER => "ALL OFFERS", NORMALCAMP => "ALL CAMPAIGNS");

        $data['PageContent'] = $this->load->view("admin/campaign/all-request", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function show_offer_request($request_id = 0) {
        $data = array();

        if ($request_id) {
            $filter = array();
            $filter['request_id'] = $request_id;
            $data['offer_request'] = $this->m_campaign->getOfferRequest($filter);
        }

        //this function is used for to show the 
        //one single reuest ro admin a
        //data contains Offer name ,Publisher Name
        // Question and their answers
        //Approve and Reject options.
        //if already approve then reject or cancel and vice versas for rejection


        $data['PageContent'] = $this->load->view("admin/campaign/offer-approval-request/single-request", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function approve_offer_request() {

        $this->load->model("admin/m_offer_permission");
        //approve requesrt by admin
        //when a user is request for offer the admin goes to offer request panel and click on approve button.
        $request = $this->input->post();
        if ($request) {
            $json = array();
//            $request['campaign_id'] = $this->m_post->getCampaign($request);
            $offerRequest = array();
            $offerRequest['req_status'] = 1;
            $offerRequest['request_id'] = $request['request_id'];
            unset($request['request_id']);
            //Offer Approved
            $uids = array(isset($request['uid']) ? $request['uid'] : 0);


            if ($this->m_offer_permission->setApprovePublisher($uids, $request['campaign_id'], 1) && $this->m_campaign->changeOfferRequest($offerRequest)) {
                $json['success'] = TRUE;
                $json['msg'] = "Offer is approved for Publisher.";


                //notification controller
                $notification = array();
                $notification['title'] = "Offer approved";
                $notification['description'] = "Your request is approved for the offer.";
                $notification['link'] = SITEURL . "affiliate/campaign/offerRequest/{$request['campaign_id']}";
                $notification['noti_for'] = $request['uid'];
                $notification['add_user'] = UID;


                $this->m_notify->save_notification($notification);
                //end notifiation end
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Offer is not approved for Publisher.";
            }

            echo json_encode($json);
        }
    }

    public function reject_offer_request() {
        //approve requesrt by admin
        //when a user is request for offer the admin goes to offer request panel and click on reject button.
        $request = $this->input->post();
        if ($request) {
            $json = array();
//            $request['campaign_id'] = $this->m_post->getCampaign($request);
            $offerRequest = array();
            $offerRequest['req_status'] = 2;
            $offerRequest['request_id'] = $request['request_id'];

            $usr_offerAproval = array();
            $usr_offerAproval['uid'] = $request['uid'];
            $usr_offerAproval['campaign_id'] = $request['campaign_id'];
            //delete the row for usr_offerApproval where uid and campaign_id is matched
            $this->m_campaign->deleteOferApproval($usr_offerAproval);
            //end of code 







            unset($request['request_id']);
            if ($this->m_campaign->changeOfferRequest($offerRequest)) {

                //notification controller
                $notification = array();
                $notification['title'] = "Offer approved";
                $notification['description'] = "Your request is not approved for the offer.";
                $notification['link'] = SITEURL . "affiliate/campaign/offerRequest/{$request['campaign_id']}";
                $notification['noti_for'] = $request['uid'];
                $notification['add_user'] = UID;
                $this->m_notify->save_notification($notification);
                //end notifiation end


                $json['success'] = TRUE;
                $json['msg'] = "Offer request is rejected for Publisher.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Offer  request is not rejected for Publisher.";
            }

            echo json_encode($json);
        }
    }

}
