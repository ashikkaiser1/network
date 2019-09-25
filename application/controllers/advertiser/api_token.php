<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of api_token
 *
 * @author NexGen
 */
class api_token extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com"); $this->com->is_advertiser();
        $this->load->model("advertiser/m_api");
        $this->load->model("admin/random_string_gen", "hashCode");
        //end
    }

    public function index() {
        $data = array();

        $data['token'] = $this->m_api->getToken(UID);
        $data['tokenInfo'] = $this->m_api->getTokenInfo(UID);
//        echo '<pre>';
//        print_r($data);
        $data['PageContent'] = $this->load->view("advertiser/api_token/v-api-token", $data, TRUE);
        $this->load->view("advertiser/template", $data);
    }

    public function generateToken() {
        $request = $this->input->post();
        $json = array();
        $data = array();
        if ($request) {
            $usr_token = array();
            $usr_token['token'] = $this->getUniqueCode();
            $usr_token['uid'] = UID;

            if ($this->m_api->setToken($usr_token)) {


                $data['usr_token'] = $this->m_api->getTokenInfo(UID);

                //send notification to admin


                $this->load->model("advertiser/m_users");
                $u_filter = array();
                $u_filter['uid'] = UID;
                $data['user'] = $this->m_users->getUsers($u_filter);


                $notification = array();
                $notification['title'] = "New API Token Request";
                $notification['description'] = $this->load->view("advertiser/common/notif_layout/v-api-approval-request", $data, true);
                $notification['link'] = SITEURL . "admin/campaign/show_request";
                $notification['noti_for'] = MANAGER;
                $notification['add_user'] = UID;


                $this->m_notify->save_notification($notification);

                //send notfication


                $json['success'] = TRUE;
                $json['msg'] = "New Token Generated";
                $json['token'] = $usr_token['token'];
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "New Token cant be generated";
            }

            echo json_encode($json);
        }
    }

    function getUniqueCode() {
        $code = $this->hashCode->generate(25);
        if ($this->m_api->checkCodeExist($code)) {
            $code = $this->getUniqueCode();
        }

        return $code;
    }

}
