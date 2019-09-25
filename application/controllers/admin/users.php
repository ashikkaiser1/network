<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of users
 *
 * @author NexGen
 */
class users extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com");
        $this->com->is_admin();
        //end
        $this->load->model("admin/m_users");
        $this->load->model("account/m_account");
        $this->load->model("email/mailer");
        $this->load->helper("form");
    }

    public function index() {
        $this->CreateUser();
    }

//    public function getTimeZone() {
//        $tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
//        echo '<pre>';
//        print_r($tzlist);
//    }

    public function CreateUser($UTID = 0) {
        //create a user 
        $request = $this->input->post();

        if ($request) {
            $json = array();

            switch ($request['UTID']) {
                case 1: $request['aff_id'] = uniqid("ADMIN") . date("dmy", time());
                    break;
                case 2: $request['aff_id'] = uniqid("AFF") . date("dmy", time());
                    break;
                case 3: $request['aff_id'] = uniqid("ADV") . date("dmy", time());
                    break;
                default: $request['aff_id'] = uniqid("AFF") . date("dmy", time());
                    break;
            }


            //get the trafic info from request and seperate it from user info
            $trafic_info = isset($request['trafic_info']) ? $request['trafic_info'] : '';
            unset($request['trafic_info']);
            //code end

            $otherNetwork = isset($request['otherNetwork']) ? $request['otherNetwork'] : array();
            unset($request['otherNetwork']);

            $uid = 0;

            $request['DOJ'] = date("d-m-Y", time());
            if ($uid = $this->m_users->CreateUser($request)) {
                //set the offer contryies where publisher wants to show offers
                if (isset($trafic_info['offer_countries']))
                    $this->m_users->setUsrOfferCountry($trafic_info['offer_countries'], $uid);
                //end
                //set the offer categaries inn which publisher interested.
                if (isset($trafic_info['offer_interest']))
                    $this->m_users->setUsrOfferInterest($trafic_info['offer_interest'], $uid);
                //end
                ///set the offer type in which publisher deals. It may be apk ,etx
                if (isset($trafic_info['offer_type']))
                    $this->m_users->setUsrofferType($trafic_info['offer_type'], $uid);
                //end
                //set the verticals of offer category in which publisher already in orworking   
                if (isset($trafic_info['offer_veticals']))
                    $this->m_users->setUsrOfferVertical($trafic_info['offer_veticals'], $uid);
                //emd
                //set the type of traffic publisher create a form facebbok or other media
                if (isset($trafic_info['offer_promotional']))
                    $this->m_users->setUsrTraffictype($trafic_info['offer_promotional'], $uid);
                //end

                if (isset($otherNetwork) && !empty($otherNetwork)) {
                    $otherNetwork['uon_status'] = 1;
                    $this->m_users->setUsrOtherNetwork($otherNetwork, $uid);
                }


                $json['success'] = TRUE;
                $json['msg'] = "Your new user is added.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your new user can't be added.";
            }

            echo json_encode($json);
            return;
        }


        $data = array();

        $filter = array();
        $filter['formated'] = TRUE;
        $data['offerCategory'] = $this->m_account->getofferCategory($filter);
        $data['offerType'] = $this->m_account->getOfferType($filter);
        $data['trafficType'] = $this->m_account->gettraficType($filter);
        $data['userType'] = $this->m_account->getUserType($filter);

        $filter = array();
        $filter['UTID'] = ACC_MANAGER;
        $filter['listFormated'] = "TRUE";
        $data['AccManager'] = $this->m_users->getUsers($filter);

        $filter = array();
        $filter['formated'] = TRUE;
        $data['country'] = $this->m_account->getCountry($filter);


        $data['timeZone'] = $this->m_account->getTimeZoneArray();
        $data['FormAction'] = SITEURL . "admin/users/CreateUser";
        $data['FormSubmitBtn'] = "Save";
        $data['SubmitAction'] = "Creating...";
        $data['panel_title'] = "Add New User";

        $data['all_title'] = "All User";
        $data['UTID'] = $UTID;
        switch ($UTID) {
            case AFFILIATE: $data['panel_title'] = "Add New Affiliate";
                $data['all_title'] = "All Affiliates";
                break;
            case ADVERTISER: $data['panel_title'] = "Add New Advertiser";
                $data['all_title'] = "All Advertisers";
                break;
            case ADMIN: $data['panel_title'] = "Add New Admin";
                $data['all_title'] = "All Admins";
                break;


            default:
                break;
        }


        $data['status'] = array("1" => "Active", "0" => "Inactive", "2" => "Pending", "3" => "Block", "4" => "Reject");

//        $data['UTID'] = $UTID;

        $data['PageContent'] = $this->load->view("admin/users/add-user", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function UpdateUser($uid = 0) {
        //create a user 

        $request = $this->input->post();

        if ($request) {
            $json = array();

            //get the trafic info from request and seperate it from user info
            $trafic_info = isset($request['trafic_info']) ? $request['trafic_info'] : '';
            unset($request['trafic_info']);
            //code end

            $otherNetwork = isset($request['otherNetwork']) ? $request['otherNetwork'] : array();
            unset($request['otherNetwork']);

            if (isset($otherNetwork) && !empty($otherNetwork)) {
                $otherNetwork['uon_status'] = 1;
                $this->m_users->updateUsrOtherNetwork($otherNetwork, $uid);
            }


            if ($this->m_users->UpdateUser($request, $uid) && $this->updateUserTrafficOptions($trafic_info, $uid)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your user is Updated.";

                if (isset($request['status'])) {
                    //send a mail according to status

                    $filter = array();
                    $filter['uid'] = $uid;
                    $mail_data = $this->m_users->getUsers($filter);
                    $request['email'] = $mail_data['email'];

                    $email = array();
                    $email['message'] = $this->load->view("account/email/account_status", $request, TRUE);
                    $email['to'] = $request['email'];
                    $email['subject'] = SITENAME . " Account Mail";
                    $this->mailer->send_mail($email);
                }
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your user can't be Updated.";
            }

            echo json_encode($json);
            return;
        }





        $data = array();
        $filter = array();
        $filter['uid'] = $uid;
        $data['user'] = $this->m_users->getUsers($filter);
        $data['trafic_info']['offer_countries'] = $this->m_users->getUsrOfferCountry($uid);
        $data['trafic_info']['offer_interest'] = $this->m_users->getUsrOfferInterest($uid);
        $data['trafic_info']['offer_type'] = $this->m_users->getUsrofferType($uid);
        $data['trafic_info']['offer_veticals'] = $this->m_users->getUsrOfferVertical($uid);
        $data['trafic_info']['offer_promotional'] = $this->m_users->getUsrTraffictype($uid);
        $data['otherNetwork'] = $this->m_users->getUsrOtherNetwork($uid);




        $filter = array();
        $filter['formated'] = TRUE;
        $data['offerCategory'] = $this->m_account->getofferCategory($filter);
        $data['offerType'] = $this->m_account->getOfferType($filter);
        $data['trafficType'] = $this->m_account->gettraficType($filter);
        $data['userType'] = $this->m_account->getUserType($filter);

        $filter = array();
        $filter['UTID'] = ACC_MANAGER;
        $filter['listFormated'] = "TRUE";
        $data['AccManager'] = $this->m_users->getUsers($filter);

        $filter = array();
        $filter['formated'] = TRUE;
        $data['country'] = $this->m_account->getCountry($filter);
        $data['timeZone'] = $this->m_account->getTimeZoneArray();


        $data['FormAction'] = SITEURL . "admin/users/UpdateUser/" . $uid;
        $data['FormSubmitBtn'] = "Update";
        $data['SubmitAction'] = "Updating...";
        $data['panel_title'] = "Update User";
        $data['status'] = array("1" => "Active", "0" => "Inactive", "2" => "Pending", "3" => "Block", "4" => "Reject");
//        $data['UTID'] = AFFILIATE;
//        echo '<pre>';
//        print_r($data['user']);
//        die();
        $data['PageContent'] = $this->load->view("admin/users/add-user", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function ViewUser($uid = 0) {
        //View a user 


        $data = array();
        $filter = array();
        $filter['uid'] = $uid;
        $data['user'] = $this->m_users->getUsers($filter);
        $data['trafic_info']['offer_countries'] = $this->m_users->getUsrOfferCountry($uid);
        $data['trafic_info']['offer_interest'] = $this->m_users->getUsrOfferInterest($uid);
        $data['trafic_info']['offer_type'] = $this->m_users->getUsrofferType($uid);
        $data['trafic_info']['offer_veticals'] = $this->m_users->getUsrOfferVertical($uid);
        $data['trafic_info']['offer_promotional'] = $this->m_users->getUsrTraffictype($uid);
        $data['otherNetwork'] = $this->m_users->getUsrOtherNetwork($uid);


        $filter = array();
        $filter['formated'] = TRUE;
        $data['offerCategory'] = $this->m_account->getofferCategory($filter);
        $data['offerType'] = $this->m_account->getOfferType($filter);
        $data['trafficType'] = $this->m_account->gettraficType($filter);


        $filter = array();
        $filter['formated'] = TRUE;
        $data['country'] = $this->m_account->getCountry($filter);
        $data['timeZone'] = $this->m_account->getTimeZoneArray();


        $filter = array();
        $filter['UTID'] = ACC_MANAGER;
        $filter['listFormated'] = "TRUE";
        $data['AccManager'] = $this->m_users->getUsers($filter);


        $data['FormAction'] = SITEURL . "admin/users/UpdateUser/" . $uid;
        $data['FormSubmitBtn'] = "Update";
        $data['SubmitAction'] = "Updating...";
        $data['panel_title'] = "User Deatils";

        $data['status'] = array("1" => "Active", "0" => "Inactive", "2" => "Pending", "3" => "Block", "4" => "Reject");

//        echo '<pre>';
//        print_r($data['user']);
//        die();
        $data['PageContent'] = $this->load->view("admin/users/view-user", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function updateUserTrafficOptions($trafic_info = array(), $uid = 0) {


        //set the offer contryies where publisher wants to show offers
        if (isset($trafic_info['offer_countries']))
            $this->m_users->setUsrOfferCountry($trafic_info['offer_countries'], $uid);
        //end
        //set the offer categaries inn which publisher interested.
        if (isset($trafic_info['offer_interest']))
            $this->m_users->setUsrOfferInterest($trafic_info['offer_interest'], $uid);
        //end
        ///set the offer type in which publisher deals. It may be apk ,etx
        if (isset($trafic_info['offer_type']))
            $this->m_users->setUsrofferType($trafic_info['offer_type'], $uid);
        //end
        //set the verticals of offer category in which publisher already in orworking 
        if (isset($trafic_info['offer_veticals']))
            $this->m_users->setUsrOfferVertical($trafic_info['offer_veticals'], $uid);
        //emd
        //set the type of traffic publisher create a form facebbok or other media
        if (isset($trafic_info['offer_promotional']))
            $this->m_users->setUsrTraffictype($trafic_info['offer_promotional'], $uid);
        //end

        return TRUE;
    }

    public function ShowUsers($userType = 0) {
        //create a user 
        $data = array();

        switch ($userType) {
            case AFFILIATE : $data['UTID'] = AFFILIATE;
                $data['title'] = "All Affiliates";
                $data['email_link'] = SITEURL . "admin/offer_email/index/";

                $data['add_link'] = SITEURL . "admin/users/CreateUser/" . AFFILIATE;
                $data['pending_link'] = SITEURL . "admin/users/show_user_request/" . AFFILIATE . "?status=2";
                $data['stats_link'] = SITEURL . "admin/report/advance_report?repType=aff_report";
                //status 2 show that the user is pending user

                break;
            case ADVERTISER : $data['UTID'] = ADVERTISER;
                $data['title'] = "All Advertiser";
                $data['add_link'] = SITEURL . "admin/users/CreateUser/" . ADVERTISER;

                $data['email_link'] = SITEURL . "admin/offer_email/index/";

                $data['add_link'] = SITEURL . "admin/users/CreateUser/" . ADVERTISER;
                $data['pending_link'] = SITEURL . "admin/users/show_user_request/" . ADVERTISER . "?status=2";
                //status 2 show that the user is pending user
                $data['stats_link'] = SITEURL . "admin/report/advance_report?repType=adv_report";



                break;
            case ACC_MANAGER : $data['UTID'] = ACC_MANAGER;
                $data['title'] = "All Account Manager";
                $data['add_link'] = SITEURL . "admin/users/CreateUser/" . ACC_MANAGER;
                break;
            case EMPLOYEE : $data['UTID'] = EMPLOYEE;
                $data['title'] = "All Employee";
                $data['add_link'] = SITEURL . "admin/users/CreateUser/" . EMPLOYEE;
                $data['pending_link'] = SITEURL . "admin/users/show_user_request/" . EMPLOYEE . "?status=2";
                $data['email_link'] = SITEURL . "admin/offer_email/index/";

                break;

            default : $data['UTID'] = '';
                $data['title'] = "All Users";
                $data['add_link'] = SITEURL . "admin/users/CreateUser/";
        }


        $request = $this->input->post();
        if ($request) {

            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            $data['users'] = $this->m_users->getUsers($request);
            echo json_encode($data['users']);
            return;
        }
        $data['status'] = array("" => "All", "1" => "Active", "0" => "Inactive", "2" => "Pending", "3" => "Block", "4" => "Reject");


        $data['PageContent'] = $this->load->view("admin/users/all-users", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function show_user_request($userType = -1) {


        $data = array();

        switch ($userType) {
            case AFFILIATE : $data['UTID'] = AFFILIATE;
                $data['title'] = "All Affiliates Request";
                $data['add_link'] = SITEURL . "admin/users/CreateUser/" . AFFILIATE;
                break;
            case ADVERTISER : $data['UTID'] = ADVERTISER;
                $data['title'] = "All Advertiser Request";
                $data['add_link'] = SITEURL . "admin/users/CreateUser/" . ADVERTISER;
                break;
            case ACC_MANAGER : $data['UTID'] = ACC_MANAGER;
                $data['title'] = "All Account Manager";
                $data['add_link'] = SITEURL . "admin/users/CreateUser/" . ACC_MANAGER;
                break;


            default : $data['UTID'] = '';
                $data['title'] = "All Users Request";
                $data['add_link'] = SITEURL . "admin/users/CreateUser/";
        }


        $request = $this->input->post();
        if ($request) {

            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            $data['users'] = $this->m_users->getUsers($request);
            echo json_encode($data['users']);
            return;
        }

        $data['status'] = array("" => "All", "1" => "Active", "0" => "Inactive", "2" => "Pending", "3" => "Block", "4" => "Reject");

        $getRequest = $this->input->get();

        $data['selected_status'] = isset($getRequest['status']) ? $getRequest['status'] : '';

        $data['PageContent'] = $this->load->view("admin/users/all-users-request", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function change_status() {

        //chnage to sttau of user (pending,block,active ,deactive,);
        $request = $this->input->post();
        $data = array();
        if ($request) {
            $update = array();
            $update['status'] = isset($request['status']) ? $request['status'] : 0;
            $uid = isset($request['uid']) ? $request['uid'] : 0;
            if ($this->m_users->UpdateUser($request, $uid)) {


                //send mail to use when 
                if ($update['status'] == 1) {
                    $this->load->model("email/mailer");

                    $filter = array("uid" => $uid);
                    $emaildata = $this->m_users->getUsers($filter);

                    if (!empty($emaildata)) {
                        $email = array();
                        //$email['message'] = $this->load->view("account/email/invitation_email", $data, TRUE);
                        $email['message'] = $this->load->view("account/email/account-approved", $emaildata, TRUE);
                        $email['to'] = $emaildata['email'];
                        $email['subject'] = "Account Approved";
                        $this->mailer->send_mail($email);
                    }
                }

                //end


                $data['success'] = TRUE;
                $data['msg'] = "User status is changed";
            } else {
                $data['success'] = FALSE;
                $data['msg'] = "User status can't changed";
            }
        } else {
            $data['success'] = FALSE;
            $data['msg'] = "User status can't changed";
        }

        echo json_encode($data);
    }

    public function userCount() {

        $request = $this->input->post();
        $data = array();
        if ($request) {
            $data = $this->m_users->getUserCount($request);
            if (isset($data['totalUser']) && $data['totalUser'] == 0) {
                $data['success'] = FALSE;
            } else {
                $data['success'] = TRUE;
            }
        } else {
            $data['success'] = FALSE;
            $data['msg'] = 0;
        }

        echo json_encode($data);
    }

    public function search_suggetions() {

        //search suggetion 
        $request = $this->input->post();
        if ($request && isset($request['phrase'])) {
            $request['username'] = $request['phrase'];
            $request['email'] = $request['phrase'];
            $request['company'] = $request['phrase'];
            $request['limit'] = 1;
            $data['users'] = $this->m_users->getUsers($request);

            $json = array();
            foreach ($data['users'] as $row) {
                $json[] = array("name" => $row['username'],
                    "company" => $row['company'],
                    "email" => $row['email'],
                );
            }

            echo json_encode($json);
        }
    }

    public function email_suggetions() {

        $request = $this->input->post();
        if ($request && isset($request['phrase'])) {
            $request['email'] = $request['phrase'];
            $request['limit'] = 1;
            $data['users'] = $this->m_users->getUsers($request);

//             echo "<pre>";
//             print_r($data);

            $json = array();
            foreach ($data['users'] as $row) {
//                 print_r($row);
//                 ." in {$row['category_name']}"
                $json[] = array("name" => $row['email'],
//                    "category" => $row['category_name'],
//                    "category_id" => $row['category_id']
                );
            }

            echo json_encode($json);
        }
    }

    public function bultupdate() {
        //Admin can bulk update the status of users 
        //from All Affiliate,All Admisni.allEmployrr or all acc manager
        $getRequest = $this->input->get();
        $json = array();
        $json['success'] = FALSE;
        $json['msg'] = "Incomplete Request.";
        if ($getRequest) {
            $request = $this->input->post();

            $request['status'] = isset($getRequest['status']) ? $getRequest['status'] : 0;
            $uid = isset($request['uid']) ? $request['uid'] : 0;
            unset($request['uid']);

            $UserData = array();
            $UserData['status'] = $request['status'];

            if ($this->m_users->UpdateUser($UserData, $uid)) {
                $json['success'] = TRUE;
                $json['msg'] = "Update Complete";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Update Incomplete.";
            }
        }


        echo json_encode($json);
    }
    
    

}
