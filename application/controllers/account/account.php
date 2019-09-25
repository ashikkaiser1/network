<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of account
 *
 * @author NexGen
 */
class account extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->model("account/m_account");
        $this->load->model("email/mailer");
        $this->load->helper("form");
        $this->load->model("admin/m_system");
        ///System Option
        $system_options = $this->m_system->getSettings(array("Formated" => 'TRUE'));
        $this->m_system->init_system($system_options);
        if ((!isset($_SERVER['HTTPS'])) && defined("PROTOCOL") && @PROTOCOL == 'https') {
            redirect(SITEURL);
        }
    }

    public function index() {
        $data = array();

        $data['PageContent'] = $this->load->view("account/login", $data, TRUE);
        $this->load->view("account/template", $data);
    }

    public function index_login() {
        $data = array();

        if (defined("LOGIN_PAGE")) {
            $data['PageContent'] = LOGIN_PAGE;
        }

        $this->load->view("account/custom_login/template", $data);
    }

    public function oAuth() {

        $this->load->library('form_validation');
        //  $this->form_validation->set_rules('username', 'Username', 'required');
        //  $this->form_validation->set_rules('password', 'Password', 'required');
        //  $this->session->sess_destroy();
        $request = $this->input->post();
        $json = array();
        $json['success'] = FALSE;
        $json['msg'] = "security credentials are incorrect.";
        if ($request) {

            if (isset($request['username']) && isset($request['password']) && $request['username'] != '' && $request['password'] != '' && $this->validateUserCredentials($request)) {
                $validate = array();
                $validate = $this->m_account->getUser($request);
                if (empty($validate)) {
                    //check via email address
                    $request['email'] = $request['username'];
                    unset($request['username']);
                    $validate = $this->m_account->getUser($request);
                }
                if ($validate) {


                    if (!empty($validate)) {
                        // $this->session->sess_destroy();
                        $this->createSession($validate);
                        $json['success'] = TRUE;
                        $json['msg'] = "Logging in.....";

                        switch ($validate['usertype_name']) {
                            case "Administrator": $json['redirectTo'] = SITEURL . "admin/dashboard";
                                break;
                            case "Affiliate": $json['redirectTo'] = SITEURL . "affiliate/dashboard";
                                break;
                            case "Account Manager": $json['redirectTo'] = SITEURL . "admin/dashboard";
                                break;
                            case "Advertiser": $json['redirectTo'] = SITEURL . "advertiser/dashboard";
                                break;

                            default:
                                break;
                        }
                    } else {
                        $json['success'] = FALSE;
                        $json['msg'] = "security credentials are incorrect. Or May be you account is not verified..!!!";
                    }
                }
            }
        }
        echo json_encode($json);
    }

    public function validateUserCredentials($request = array()) {

        if (!empty($request['username'])) {
            return TRUE;
        }
    }

    public function createSession($userData = array()) {

        $Sessiondata = array();
        $Sessiondata['uid'] = $userData['uid'];
        $Sessiondata['UTID'] = $userData['UTID'];
        $Sessiondata['manager'] = $userData['manager'];
        $Sessiondata['username'] = $userData['username'];
        $Sessiondata['name'] = $userData['name'];
        $Sessiondata['email'] = $userData['email'];
        $Sessiondata['contact'] = $userData['username'];

        $Sessiondata['company'] = $userData['company'];
        $Sessiondata['aff_id'] = $userData['aff_id'];
        $Sessiondata['contact'] = $userData['contact'];
        $Sessiondata['usertype_name'] = $userData['usertype_name'];



        $this->session->set_userdata($Sessiondata);
    }

    public function getUser() {

        $request = $this->input->post();
        $json = array();
        if ($request) {
            if ($this->m_account->getaUser($request['username'])) {
                //echo

                $json["valid"] = FALSE;
                $json['msg'] = "Username is not avaliable. User Already exist";
            } else {
                $json["valid"] = TRUE;
                $json['msg'] = "Username is avaliable.";
            }
        }

        echo json_encode($json);
    }

    public function getEmail() {

        $request = $this->input->post();
        $json = array();
        if ($request) {
//            echo "<pre>";
//            print_r($request);
//            exit;
            if ($this->m_account->getaEmail($request['email'])) {
                //echo
                $json["valid"] = FALSE;

                //$json['msg'] ="Username is avaliable.";
            } else {
                $json["valid"] = TRUE;
                //  $json['msg'] ="Username is not avaliable. User Already exist";
            }
        }


        $request = $this->input->get();
        // $json = array();
        if ($request) {
            if (!$this->m_account->getaEmail($request['in_email'])) {
                //echo
                $json["valid"] = FALSE;
                //$json['msg'] ="Username is avaliable.";
            } else {
                $json["valid"] = TRUE;
                //  $json['msg'] ="Username is not avaliable. User Already exist";
            }
        }

        echo json_encode($json);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(SITEURL);
    }

    public function CreateAccountRequest() {
        //publisher
        //step 1
        $data = array();
        $request = $this->input->post();
        if ($request) {
            $this->load->model("admin/random_string_gen", "hashCode");
            $json = array();
            //$in_code = FALSE;
            if ($this->m_account->getaEmail($request['in_email'])) {
                $json['success'] = FALSE;
                $json['msg'] = "Please provide a valid mail .Account already exist with this mail.";
                echo json_encode($json);
                return;
            }
            $data['ref_by'] = isset($request['ref_by']) ? $request['ref_by'] : '';
            unset($request['ref_by']);
            $request['in_code'] = $this->getUniqueCode();
            if ($this->m_account->inviteMe($request)) {
                $data['in_code'] = $request['in_code'];
                $data['in_for'] = $request['in_for'];

                $email = array();
                //$email['message'] = $this->load->view("account/email/invitation_email", $data, TRUE);
                $email['message'] = $this->load->view("account/email/text-invite-signup", $data, TRUE);
                $email['to'] = $request['in_email'];
                $email['subject'] = "Email Verfication. " . SITENAME;
                $this->mailer->send_mail($email);
                $json['success'] = TRUE;
                $json['msg'] = "Please check your email for the sign up link in inbox or spam.";
//                $json['msg'] = "Redirecting";  
//                $json['redirectTo'] = SITEURL . "account/account/signup?in_code=" . $request['in_code'];
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Please Enter valid mail.";
            }

            echo json_encode($json);
            return;
        }

        $data['ref_by'] = $this->input->get("ref_by");
        $data['PageContent'] = $this->load->view("account/new_account_request", $data, TRUE);
        // $data['PageContent'] = $this->load->view("account/signup_type", $data, TRUE);
        $this->load->view("account/template", $data);
    }

    function getUniqueCode() {
        $code = $this->hashCode->generate(12);

        if ($this->m_account->checkCodeExist($code)) {
            $code = $this->getUniqueCode();
        }

        return $code;
    }

    public function signup() {
        //publisher
        //step 2

        $request = $this->input->get();
        $data = array();

        if ($request) {
            //check the in_code and in_email form database to check valid invite or valid email address.
            $invite = array();

            $invite['in_code'] = isset($request['in_code']) ? $request['in_code'] : uniqid();
            $data['in_code'] = $invite['in_code'];
            if (($this->m_account->checkInvitation($invite) && $this->m_account->checkedCodeUsed($invite)) || isset($request['in_for'])) {


                $filter = array();
                $filter['formated'] = TRUE;
                $data['offerCategory'] = $this->m_account->getofferCategory($filter);
                $data['offerType'] = $this->m_account->getOfferType($filter);
                $data['trafficType'] = $this->m_account->gettraficType($filter);
                $data['UserEmail'] = $this->m_account->getEmailbyin_code($data['in_code']);
                $filter = array();
                $filter['formated'] = TRUE;
                $data['country'] = $this->m_account->getCountry($filter);
                $data['timeZone'] = $this->m_account->getTimeZoneArray();
                $data['ref_by'] = isset($request['ref_by']) ? $request['ref_by'] : '';
                $data['in_for'] = isset($request['in_for']) ? $request['in_for'] : AFFILIATE;
                if (isset($data['in_for']) && $data['in_for'] == AFFILIATE) {
                    $data['title'] = " Affilate Sign up";

                    $data['PageContent'] = $this->load->view("account/signup", $data, TRUE);
                }

                if (isset($data['in_for']) && $data['in_for'] == ADVERTISER) {
                    $data['title'] = "Advertiser Sign up";
                    $data['PageContent'] = $this->load->view("account/sign_up_advertiser", $data, TRUE);
                }
                $this->load->view("account/template", $data);
            } else {
                $this->CreateAccountRequest();
            }

            return;
        }


        //code for when user submit the detailed form  of their info to create account

        $json = array();
        $request = $this->input->post();
        if ($request) {


            if (!$this->validate_sign_upform($request)) {
                $json['success'] = FALSE;
                $json['msg'] = "Please Fill all fields";

                echo json_encode($json);
                return;
            }

            //get the trafic info from request and seperate it from user info
            $trafic_info = isset($request['trafic_info']) ? $request['trafic_info'] : array();
            unset($request['trafic_info']);

            $otherNetwork = isset($request['otherNetwork']) ? $request['otherNetwork'] : array();
            unset($request['otherNetwork']);
            //end of code
//            echo '<pre>';
//            print_r($trafic_info);
//            die();
            //step 3
            $this->load->model("admin/m_users");

            if (!isset($request['in_code'])) {
                $json['success'] = FALSE;
                $json['msg'] = "Please verify your email address with new sign up..";

                echo json_encode($json);
                return;
            }
            $in_code = $request['in_code'];

            if (!(isset($request['email']) && $request['email'] != '')) {
                $request['email'] = $this->m_account->getEmailbyin_code($in_code);
            }

            $invite = array();
            $invite['in_code'] = $request['in_code'];
            if (!$this->m_account->checkedCodeUsed($invite)) {
                //if code already used for another account..
                $json['success'] = FALSE;
                $json['msg'] = "Please verify your email address with new sign up..";

                echo json_encode($json);
                return;
            }

            unset($request['in_code']);

            if (isset($request['in_for']) && $request['in_for'] == AFFILIATE) {
                $request['UTID'] = AFFILIATE;
                $request['aff_id'] = uniqid("AFF") . date("dmy", time());
            }

            if (isset($request['in_for']) && $request['in_for'] == ADVERTISER) {
                $request['UTID'] = ADVERTISER;
                $request['aff_id'] = uniqid("ADV") . date("dmy", time());
            }

            unset($request['in_for']);


            $user = $request;
            $user['in_code'] = $in_code;



            $user['DOJ'] = date("d-m-Y", time());
            $user['status'] = 0;
            if (defined("AUTO_APPROVAL") && @AUTO_APPROVAL == 1) {
                $user['status'] = 1;
            }

            $user['verified'] = 1;
            $user['ref_id'] = "REF_" . rand(0, 999) . "_ID" . date("Ymd", time());
            $user['ref_by'] = isset($request['ref_by']) ? $request['ref_by'] : '';
            $uid = 0;
            if ($uid = $this->m_users->CreateUser($user)) {

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


                //Referal Program code 
                $this->refferealProgram($user, $uid);
                //end of Referal Program code
                //send mail and notification to amdin for new registration
                $this->send_notification($user, $uid);
                //end of code



                $json['success'] = TRUE;
                $json['msg'] = "Account Created....";
                $json['user'] = $user;
                $json['redirect'] = SITEURL . "account/account/thankyou";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Account NOt Created....";
            }

            echo json_encode($json);
            //create the account ...
            return;
        }
        //code end
//        else the new account request form is shown...
        $this->CreateAccountRequest();
    }

    public function refferealProgram($user = array(), $uid = 0) {

        if ((!empty($user)) && $uid != 0 && isset($user['ref_by']) && $user['ref_by'] != '') {
            //then we should start the referal program next step
            $referal_program = array();
            $referalUserInfo = $this->m_account->getUserByRefferalID($user['ref_by']);
            if ($referalUserInfo && !empty($referalUserInfo)) {
                $referal_program['uid'] = $referalUserInfo['uid'];
                $referal_program['ref_uid'] = $uid; // this user is refered by $referalUserInfo['uid'];
                $referal_program['status'] = 1;
                $referal_program['amt'] = REFERAL_AMT;
                //OFFER_DATE_FROMAT is just a date format 
                $referal_program['dateof_ref'] = date(OFFER_DATE_FROMAT, time());
                if ($this->m_account->some_one_reffer_me($referal_program)) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    public function send_notification($user = array(), $uid = 0) {
        $this->load->model("notification/m_notify");
        //function is used for send a notification to admin and a mail to user 
        //that fill the form
        //notification controller
        $notification = array();
        switch ($user['UTID']) {
            case AFFILIATE: $notification['title'] = "New Affiliate";

                $notification['link'] = SITEURL . "admin/users/UpdateUser/{$uid}";
                $notification['description'] = " <a href='{$notification['link']}'><span class='noti_new_affiliate'>{$user['name']}</span></a> applied as a affiliate to network.";
                $notification['noti_for'] = -1;
                $notification['add_user'] = $uid;
                break;

            case ADVERTISER : $notification['title'] = "New Advertiser";
                $notification['link'] = SITEURL . "admin/users/UpdateUser/{$uid}";
                $notification['description'] = "<a href='{$notification['link']}'><span class='noti_new_adv'>{$user['name']}</span></a> applied as a advertiser to network.";

                $notification['noti_for'] = -1;
                $notification['add_user'] = $uid;
            default:
                break;
        }
        $this->m_notify->save_notification($notification);





        //end code
    }

    public function forgotPasswordRequest() {
        //publisher
        //step 1
        $data = array();
        $request = $this->input->post();
        if ($request) {
            $this->load->model("admin/random_string_gen", "hashCode");
            $json = array();
            //$in_code = FALSE;
            $request['in_code'] = $this->getUniqueCode();
            if ($this->m_account->inviteMe($request)) {
                $data['in_code'] = $request['in_code'];
                $email = array();
//                $email['message'] = $this->load->view("account/email/fogot_password_email", $data, TRUE);
                $email['message'] = $this->load->view("account/email/forgot_password_text", $data, TRUE);
                $email['to'] = $request['in_email'];
                $email['subject'] = "Password Reset " . SITENAME;
                $this->mailer->send_mail($email);
                $json['success'] = TRUE;
                $json['msg'] = "Send a mail";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Please Enter ";
            }

            echo json_encode($json);
            return;
        }



        $data['PageContent'] = $this->load->view("account/forgot_password", $data, TRUE);
        $this->load->view("account/template", $data);
    }

    public function reset_password() {
        //PUBLISHER /ADVERTISER
        //step 2

        $request = $this->input->get();
        $data = array();

        if ($request) {
            //check the in_code and in_email form database to check valid invite for reset code  or valid email address.
            $invite = array();

            $invite['in_code'] = isset($request['in_code']) ? $request['in_code'] : 0;
            $data['in_code'] = $invite['in_code'];
            if ($this->m_account->checkInvitation($invite) && $this->m_account->checkedCodeUsed($invite)) {
                $data['PageContent'] = $this->load->view("account/reset_password", $data, TRUE);
                $this->load->view("account/template", $data);
            } else {
                $this->forgotPasswordRequest();
            }

            return;
        }


        //code for when user submit the detailed form  of their info to create account

        $json = array();
        $request = $this->input->post();
        if ($request) {
            //step 3
            $this->load->model("admin/m_users");

            if (!isset($request['in_code'])) {
                $json['success'] = FALSE;
                $json['msg'] = "Please verify your email address with new sign up..";

                echo json_encode($json);
                return;
            }
            $in_code = $request['in_code'];
            unset($request['in_code']);

            $userEmail = $this->m_account->getEmailbyin_code($in_code);
            $passwords = array();

            $passwords['password'] = $request['password'];
            $passwords['re_password'] = $request['re_password'];

            if ($this->m_account->reset_password($passwords, $userEmail)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your Account Password changed.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your Account Password not changed.";
            }


            echo json_encode($json);
            //create the account ...
            return;
        }
        //code end
//        else the new account request form is shown...
        $this->forgotPasswordRequest();
    }

    public function notifiy_admin_by_mail() {
        
        //this function is used for sending mail to admin
        //when the new affiliate and advertiser signup//
        //
        $username = $this->input->get('username');
        if ($username) {
            $this->load->model("admin/m_users");
            //send a mail to admin when a new user register;;;;;
            $filter = array();
            $filter['username'] = $username;
//            $filter['check_status'] = "NO";
            $user = $this->m_users->getUsers($filter);
            if ($user) {
                $admins = $this->m_users->getUsers(array("UTID" => ADMIN));

                $admin_emails = implode(",", array_column($admins, "email"));
                $user = isset($user[0]) ? $user[0] : array();

                $email = array();

                switch ($user['UTID']) {
                    case ADVERTISER:$email['subject'] = "New Advertiser {$user['name']} is Registered.";
                        break;
                    case AFFILIATE:$email['subject'] = "New Affiliate {$user['name']} is Registered.";
                    default:
                        break;
                }

                $email['message'] = $this->load->view("account/email/notify_to_admin", $user, TRUE);
                $email['to'] = $admin_emails;

                $this->mailer->send_mail($email);
            }
            //
            //end of code

            return;
        }
    }

    public function thankyou() {


        $data = array();
        $data['PageContent'] = $this->load->view("account/thankyou", $data, TRUE);
        $this->load->view("account/template", $data);
    }

    public function validate_sign_upform($form = array()) {
        if (!isset($form['username']) || $form['username'] == '')
            return false;
        if (!isset($form['password']) || $form['password'] == '')
            return false;
        if (!isset($form['re_password']) || $form['re_password'] == '')
            return false;
        if ($form['re_password'] != $form['re_password'])
            return false;

        return TRUE;
    }

}
