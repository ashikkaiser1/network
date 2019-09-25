<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of offer_payout
 *
 * @author kuldeep
 */
class offer_payout extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();

        //check the login for user
        $this->load->library("common/com"); $this->com->is_admin();
        //end
        $this->load->model("admin/m_campaign");
        $this->load->model("admin/m_users");
        $this->load->helper("form");
        $this->load->model("admin/m_pay_type");
        $this->load->model("admin/m_user_group");
        $this->load->model("admin/m_group_payout");
    }

    public function index($campaign_id = 0) {
        //show offer request form to user to request the admin for offer approval.
        //offer details page for admin

        $request = $this->input->post();
        if ($request) {
            //the request is accepeted by affiliate_apply_for_offer function
        }




        //$this->m_campaign =null;
        // $this->load->model("affiliate/m_campaign", "aff_m_campaign");
//        echo '<pre>';
        $data = array();
        $data['campaign'] = $this->m_campaign->getOfferDetails($campaign_id);


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
        //group list
        $usr_group = array();
        $usr_group['listFormated'] = 'TRUE';
        $data['usr_group'] = $this->m_user_group->getUserGroup($usr_group);


        //gruop list ened




        $this->load->model("admin/m_pay_type");
        $rev_filter = array();

        $rev_filter['type'] = PAYOUT;
        $rev_filter['formated'] = TRUE;
        $data['payout'] = $this->m_pay_type->getPayType($rev_filter);

        $rev_filter['type'] = REVENUE;
        $rev_filter['formated'] = TRUE;
        $data['revenue'] = $this->m_pay_type->getPayType($rev_filter);


        //end of code
        $data['campaign_id'] = $campaign_id;




        $data['affiliate_payout'] = $this->load->view("admin/offer/offer_payout/affiliate_payout", $data, TRUE);
        //$data['group_payout'] = $this->load->view("admin/offer/offer_payout/group_payout", $data, TRUE);




        $data['PageContent'] = $this->load->view("admin/offer/offer_payout/offer_data", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function setOfferPayout() {

        $request = $this->input->post();
        if ($request) {

            $uids = isset($request['uid']) ? $request['uid'] : 0;
            $groups = isset($request['group_id']) ? $request['group_id'] : 0;

            $json = array();

            if ($this->m_group_payout->setPayoutForAffiliate($request, $uids) && $this->m_group_payout->setPayoutForGroup($request, $groups)) {

               //Pending Work
               // $this->send_notifications_about_payout($uids, $groups, $request);

                $json['success'] = TRUE;
                $json['msg'] = "Your Payout is added.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your Payout can be added.";
            }

            echo json_encode($json);
            return;
        }
    }

    public function send_notifications_about_payout($uids, $groups, $request = array()) {
        $this->load->model("notification/m_notify");

        $filter = array();
        $filter['group_ids'] = $groups;
        $group_members = array_column($this->m_user_group->getGroupMembers($filter), "uid");

        if (is_array($uids) && !empty($uids)) {

            $uids = $uids + $group_members;
//            echo '<pre>';
//            print_r($uids);

            $campaign_id = isset($request['campaign_id']) ? $request['campaign_id'] : 0;
            $pub_filter = array();
            $pub_filter['uid'] = $uids;
            $users = $this->m_users->getUsers($pub_filter);

//            echo '<pre>';
//            print_r($users);
            $BulkNotification = array();
            foreach ($users as $user) {

                $notification = array();
                $notification['link'] = SITEURL . "affiliate/campaign/offerRequest/{$campaign_id}";
                $notification['description'] = " <a href='{$notification['link']}'><span class='payoutChange'>Offer Link</span></a> Payout Change.";
                $notification['noti_for'] = $user['uid'];
                $notification['add_user'] = UID;
                $notification['add_date'] = date('Y-m-d H:i:s', time());
                $BulkNotification[] = $notification;
            }
            
             $this->m_notify->save_notification_bulk($BulkNotification);
        }

       
    }

    public function show_payouts_aff() {
        //show the payouts of affiliates of 
        $request = $this->input->post();
        $data = array();
        if ($request) {
            $data['payoutsAff'] = $this->m_group_payout->getAffiliatePayout($request);
            $data['success'] = TRUE;
        }

        echo json_encode($data);
    }

    public function show_payouts_group() {
        //show the payouts of affiliates of 
        $request = $this->input->post();
        $data = array();
        if ($request) {
            $data['payoutsGroup'] = $this->m_group_payout->getGroupPayout($request);
            $data['success'] = TRUE;
        }

        echo json_encode($data);
    }

    public function deletePayout() {

        $request = $this->input->post();
        $json = array();
        if ($request) {

            if ($this->m_group_payout->deletePayoutGroup($request)) {
                $json['success'] = TRUE;
                $json['msg'] = "Deleted";
            } else {
                $json['success'] = TRUE;
                $json['msg'] = "Deleted";
            }
        }

        echo json_encode($json);

        return;
    }

}
