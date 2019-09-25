<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of common
 *
 * @author kuldeepsingh
 */
class com {

    public $ci;
    public $campaign_status = array("1" => "Active", "0" => "In-Active", "2" => "Pause", "3" => "Pending", "4" => "Deleted");
    public $p_type = array("0" => "Postback Url", "1" => "Image Pixel", "2" => "Iframe Pixel");
    public $conv_status = array("1" => "Auto Approval/Reject", "2" => "Manual Approval/Reject");
    public $apiToken_status = array("1" => "Active", "0" => "In-Active", "2" => "Pending", "3" => "Rejected");
    public $jobType = array("" => "Select Type", "1" => "Campaign", "2" => "Report", "3" => "Notification", "4" => "Payout");
    public $PaymentModes = array("Cash" => "Cash", "Bank Transfer" => "Bank Transfer", "Paypal" => "Paypal", "Payoneer" => "Payoneer");
    
    public function __construct() {


        $this->ci = & get_instance();
        $this->ci->load->helper("url");
        $this->ci->load->model("admin/m_system");
        $session = $this->ci->session->all_userdata();




        ///System Option
        $system_options = $this->ci->m_system->getSettings(array("Formated" => 'TRUE'));
        $this->ci->m_system->init_system($system_options);

        if ((!isset($_SERVER['HTTPS'])) && defined("PROTOCOL") && @PROTOCOL == 'https') {
            redirect(SITEURL);
        }

//         echo TIMEZONE;
        date_default_timezone_set(TIMEZONE);
//        die();
//        echo"<pre>";
//        print_r($system_options);
//        exit;
        //end of system options
//        echo '<pre>';
//        print_r($session);
        if (isset($session['uid']) && $session['uid'] != '') {
            $this->ci->load->model("notification/m_notify");
            if (!defined("UserTitle")) {
                define("UserTitle", $session['name']);
                define("USERNAME", $session['username']);
                define("USERTYPE", $session['usertype_name']);
                define("UTID", $session['UTID']);
                define("MANAGER", $session['manager'] == 0 ? 2 : $session['manager']);
                define("UID", $session['uid']);
                $this->ci->config->set_item("permissions", array_column($this->ci->m_system->get_permissions(UID), "link"));
            }

            $this->ci->config->set_item('campaign_status', $this->campaign_status);
            $this->ci->config->set_item('p_type', $this->p_type);
            $this->ci->config->set_item('conv_status', $this->conv_status);
            $this->ci->config->set_item('apiToken_status', $this->apiToken_status);
            $this->ci->config->set_item('jobType', $this->jobType);
            $this->ci->config->set_item('PaymentModes', $this->PaymentModes);
            $this->ci->config->set_item('deviceType', $this->ci->m_system->getDevices());
            $this->ci->config->set_item('PlatformType', $this->ci->m_system->getOS());


            //
//             $this->ci->load->library('user_agent');
//             $this->ci->agent->referrer();
//            if($this->ci->uri->segment(1) == "admin" && (UTID !=ADMIN || UTID !=ADVERTISER))
//            {
//                redirect(SITEURL);
//            }
            // define("", $session)
        } else {
            redirect(SITEURL);
        }
    }

    public function is_admin() {
        if (UTID != ADMIN) {
            if (UTID != ACC_MANAGER)
                redirect(SITEURL . "util/auth");
        }

        if (!$this->check_permission(uri_string())) {
            if ($this->ci->input->is_ajax_request()) {
//                $json = array();
//                $json['success'] = FALSE;
//                $json['msg'] = "Sorry, You haven't permission for this module..!!!";
//                echo json_encode($json);
//                die();
                return;
            }
            redirect(SITEURL . "util/auth/premission_denied");
        }
    }

    public function is_advertiser() {
        if (UTID != ADVERTISER) {
            redirect(SITEURL . "util/auth");
        }
    }

    public function is_affiliate() {
        if (UTID != AFFILIATE) {
            redirect(SITEURL . "util/auth");
        }
    }

    public function check_permission($uri_string = '') {

        if (UTID == ADMIN) {
            return TRUE;
        }
        $permissions = $this->ci->config->item('permissions');
        //current page acecss request
        $access_page = explode("/", $uri_string);
        foreach ($permissions as $page) {
            //compare the $page and $access page
            $page = explode("/", $page);
            $complete_check = 0;
            foreach ($page as $key => $segment) {

                if (isset($access_page[$key]) && $access_page[$key] == $segment || ($segment == "(.*)") || $access_page[$key]=="(.*)") {
                    $complete_check++; 
                } else { 
                    break;
                }
                if ($complete_check == count($page)) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

}
