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
class offer_email extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com");
        $this->com->is_admin();
        //end
        $this->load->model("admin/m_campaign");
        $this->load->model("admin/m_users");
        $this->load->model("account/m_account");
        $this->load->helper("form");
        $this->load->model("email/mailer");
//        $this->load->model("admin/m_category");
//        $this->load->model("admin/m_post");
//        $this->load->model("admin/m_website");
//        $this->load->model("admin/m_pay_type");
    }

    public function index() {
        $this->load->helper("form");
        $request = $this->input->post();
        $getReuest = $this->input->get();
        if ($request) {

            $this->mail_sendTo_affiliates();

            return TRUE;
        }

        $data['autoUidSelected'] = array();
        $data['autoOfferSelected'] = array();
        if ($getReuest) {


            if (isset($getReuest['uid']) && !is_array($getReuest['uid'])) {
                $data['autoUidSelected'][] = isset($getReuest['uid']) ? $getReuest['uid'] : 0;
            } else if (isset($getReuest['uid']) && is_array($getReuest['uid'])) {
                $data['autoUidSelected'] = isset($getReuest['uid']) ? $getReuest['uid'] : 0;
            }


            if (isset($getReuest['campaign_id']) && !is_array($getReuest['campaign_id'])) {
                $data['autoOfferSelected'][] = isset($getReuest['campaign_id']) ? $getReuest['campaign_id'] : 0;
            } else if (isset($getReuest['campaign_id']) && is_array($getReuest['campaign_id'])) {
                $data['autoOfferSelected'] = isset($getReuest['campaign_id']) ? $getReuest['campaign_id'] : 0;
            }
        }

        $filters = array();
        $filters['UTID'] = AFFILIATE;
        $filters['listFormated'] = TRUE;
        $data['affiliates'] = $this->m_users->getUsers($filters);

        $data['FormAction'] = SITEURL . "admin/offer_email/";
        $data['SubmitBtn'] = "Send";
        $data['Submiting'] = "Sending";
        $data['title'] = "Send Offer Mail";



        //redirection offer

        $filter = array();
        $filter['type'] = OFFER;
        $filter['Formated'] = "TRUE";
        $filter['status'] = 1;
        $filter['group_by'] = 'campaign_id';
        $data['offers'] = array();
        if (!empty($data['autoOfferSelected'])) {
            $filter['campaign_id'] = $data['autoOfferSelected'];
            $data['offers'] = $this->m_campaign->getCampaign($filter);
        }
//                
        //end redirection offer
        // $data['Campaign'] = $this->m_campaign->getCategory(0,array("allchild"=>true));
        //$data['allCategory'] = $this->load->view("admin/Campaign/all-Campaign", $data, TRUE);
        $data['PageContent'] = $this->load->view("admin/offer/offer_email/offer_mail", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function mail_sendTo_affiliates() {

        $this->load->model("admin/m_offer");
        $request = $this->input->post();
        if ($request) {

            $filters = array();
            $filters['UTID'] = AFFILIATE;
//            $filters['listFormated'] = TRUE;
            $filters['uid'] = (isset($request['uid']) && !empty($request['uid'])) ? $request['uid'] : 0;
            $data['affiliates'] = $this->m_users->getUsers($filters);

            $filter = array();
            $filter['type'] = OFFER;
            $filter['all'] = "all";
            $filter['campaign_id'] = (isset($request['campaign_id']) && !empty($request['campaign_id'])) ? $request['campaign_id'] : 0;
            $filter['status'] = 1;
            $data['offers'] = $this->m_offer->getCampaign($filter);

//            echo '<pre>';
//            print_r($data['offers']);
//            die();

            $email_msg = isset($request['emailMsg']) ? $request['emailMsg'] : '';

            if (!empty($data['affiliates']) && !empty($data['offers'])) {
                foreach ($data['affiliates'] as $user) {
                    $this->mail_formating($user, $data['offers'], $email_msg);
                }
            }

            $data['success'] = TRUE;
            $data['msg'] = "All mail sent";


            echo json_encode($data);
        }
    }

    public function mail_formating($user = array(), $camapigns = array(), $email_msg = '') {

        $data = array();
        $data['user'] = $user;
        $data['campaign'] = $camapigns;
        $data['email_msg'] = $email_msg;

        $email = array();
        //$email['message'] = $this->load->view("account/email/invitation_email", $data, TRUE);
        $email['message'] = $this->load->view("admin/email/offer/offer_share", $data, TRUE);
        if (isset($user['email']) && $user['email'] != '') {
            $email['to'] = $user['email'];
            $email['subject'] = "Offer Sharing Mail";
            $this->mailer->send_mail($email);
        }
    }

}
