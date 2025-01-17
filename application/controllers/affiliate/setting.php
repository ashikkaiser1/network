<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of setting
 *
 * @author NexGen
 */
class setting extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();

        //check the login for user
        $this->load->library("common/com"); $this->com->is_affiliate();
        $this->load->helper("form");
        $this->load->model("affiliate/m_users");
        //end
    }

    public function index() {
        $data = array();
        $filters = array();
        $filters['uid'] = UID;
        
      //  echo "<pre>";
        //print_r($value);
        $request = $this->input->get();
       if($request)
       {
           $data['section'] = $request['section'];
       }
        
        $data['user'] = $this->m_users->getUsers($filters);

        $data['globalPostBack'] = $this->load_controller("affiliate/modules/globalpostback");

        $data['PageContent'] = $this->load->view("affiliate/setting/v-setting", $data, TRUE);
        $this->load->view("affiliate/template", $data);
    }

    public function my_profile() {
        $data = array();
        $filters = array();
        $filters['uid'] = UID;
        $data['user'] = $this->m_users->getUsers($filters);
        if(isset($data['user']['ref_id']) && $data['user']['ref_id'] ==''){
            //generate new ref_if if ref not present
            $referal = array();
            $referal['ref_id'] = "REF_" . rand(0, 999) . "_ID" . date("Ymd", time());
            if($this->m_users->UpdateUser($referal, UID)){
                $data['user']['ref_id'] = $referal['ref_id'];
            }
        }
        $data['PageContent'] = $this->load->view("affiliate/setting/v-my-profile", $data, TRUE);
        $this->load->view("affiliate/template", $data);
    }
    
     public function my_payment() {
        $data = array();
        $filters = array();
        $filters['uid'] = UID;
        $data['user'] = $this->m_users->getUsers($filters);
        
//        echo"<pre>";
//        print_r($data['user']);
//        exit;
        
        $data['PageContent'] = $this->load->view("affiliate/setting/v-payment", $data, TRUE);
        $this->load->view("affiliate/template", $data);
    }

    public function setmy_globalpostback() {

        $data = array();
//        $filters = array();
//        $filters['uid'] = UID;
//        $data['user'] = $this->m_users->getUsers($filters);

        $data['globalPostBack'] = $this->load_controller("affiliate/modules/globalpostback");

        $data['PageContent'] = $this->load->view("affiliate/setting/v-gbp", $data, TRUE);
        $this->load->view("affiliate/template", $data);
    }

    public function setting_edit() {

        $request = $this->input->get();
        if ($request) {
            if (isset($request['type']) && $request['type'] == 'basic') {
                $this->basic_info();
            }

            if (isset($request['type']) && $request['type'] == 'security') {
                $this->security();
            }

            if (isset($request['type']) && $request['type'] == 'payment') {
                $this->bank_info();
            }
        }
    }

    public function basic_info() {
        $request = $this->input->post();
        $json = array();
        if ($request) {
            if ($this->m_users->UpdateUser($request, UID)) {
                $json = array("success" => TRUE, "msg" => "Basic Information Updated");
            } else {
                $json = array("success" => FALSE, "msg" => "Basic Information Updated");
            }
        }
        echo json_encode($json);
    }

    public function security() {
        $this->load->model("account/m_account");
        $json = array();
        $request = $this->input->post();
        $filter = array();
        $filter['username'] = USERNAME;
        $filter['password'] = isset($request['old_password']) ? $request['old_password'] : '';
        $user = array();
        //print_r($filter);
        if ($user = $this->m_account->getUser($filter)) {
            //      echo "hi";
            if (!empty($user)) {
                unset($request['old_password']);
                if ($this->m_users->UpdateUser($request, UID)) {
                    $json = array("success" => TRUE, "msg" => "Security Setting Updated");
                } else {
                    $json = array("success" => FALSE, "msg" => "Security Setting Not Updated");
                }
            } else {
                $json = array("success" => FALSE, "msg" => "Security Setting Not Updated");
            }
        } else {
            $json = array("success" => FALSE, "msg" => "Security Setting Not Updated");
        }

        echo json_encode($json);
    }

    public function bank_info() {
        $json = array();
        $request = $this->input->post();
        if ($this->m_users->UpdateUser($request, UID)) {
            $json = array("success" => TRUE, "msg" => "Bank Information Updated");
        } else {
            $json = array("success" => FALSE, "msg" => "Bank Information Updated");
        }

        echo json_encode($json);
    }

}
