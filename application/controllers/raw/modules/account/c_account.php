<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of account
 *
 * @author kuldeep
 */
class c_account {

    public $CI;

    public function __construct(CI_Controller &$CI) {
        // parent::__construct();
        $this->CI = $CI;
        $this->CI->load->model("modules/m_account");
    }

    public function index($info = array()) {
        $response = "";
        $data = array();
        $SESSION = $this->CI->session->all_userdata();
        $data['user'] = $SESSION;
//        echo '<pre>';
//        print_r($SESSION);
//        echo '</pre>';
        if (isset($SESSION['customer_id']) && !empty($SESSION['customer_id'])) {
            $response.= $this->CI->load->view("modules/account/v-account-logged-in", $data, TRUE);
        } else {
            $response.= $this->CI->load->view("modules/account/v-account", NULL, TRUE);
        }
        //foreach ($products as $product) {
        // }
        return $response;
    }

    public function account_wrapper($info = array()) {
        $response = "";

        //foreach ($products as $product) {
        $response.= $this->CI->load->view("modules/account/v-account-wrapper", NULL, TRUE);
        //   print_r($this->CI->session->all_userdata());
        //$response.= ;
        // }
        return $response;
    }

    public function login() {
        $request = $this->CI->input->post();
        $response_json = array();
        $userdata = array();
        if (!empty($request) && !empty($userdata = $this->CI->m_account->CheckUser($request))) {
            $this->create_session($userdata);
            echo json_encode(array('success'=>true,"url"=>SITEURL.INDEX));
        } else {
            echo json_encode(array('success'=>false,"error"=>"Incorrect Login!"));
        }
    }

    public function create_session($userdata) {
        $this->CI->session->sess_create();

        $this->CI->session->set_userdata($userdata);
    }

    public function signup() {
        //new account data
        $response_json = array();
        $request = $this->CI->input->post();
        if (!empty($request) && $this->CI->m_account->new_user_account($request)) {
            $msg = "<h2 class='greeting' id='signupGreet'>
                Hi! <span>{$request['firstname']}</span>, your account is created .Login You Account.
                        </h2>";

            $response_json = array("success" => true, 'msg' => $msg,
                "redirect" => SITEURL . INDEX . ""
            );
        } else {

            $msg = "<h2 style='color: #AD1E18;
    font-size: 14px;' class='greeting text-danger  text-center'>Please Fill All fileds Or check the email address .It should be unique.
                        </h2>";

            $response_json = array("success" => FALSE, 'msg' => $msg);
        }

        echo json_encode($response_json);
    }

    public function logout() {
        $this->CI->session->sess_destroy();
        echo json_encode(array('succ' => true, 'url' => SITEURL . INDEX));
    }

}
