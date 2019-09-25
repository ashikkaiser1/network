<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of globalpostback
 *
 * @author NexGen
 */
class globalpostback extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com"); $this->com->is_admin();
        //end
        $this->load->model("admin/m_globalpostback", "g_postb");
    }

    public function index($uid = 0) {

        $data['post_back'] = $this->g_postb->get_globalpostback($uid);
        $data['uid'] =$uid;
//        echo '<pre>';
//        print_r($data);
        $data['PageContent'] = $this->load->view("admin/users/v-gbp", $data, TRUE);
        $this->load->view("admin/template", $data);
        ///return "Leader Borad";
    }

    public function setGlobalPostBack() {

        $request = $this->input->post();
        if ($request) {
//            $request['uid'] = UID;
            if ($this->g_postb->set_globalpostback($request)) {
                $json = array("success" => TRUE, "msg" => "Global postback is setted.");
            } else {
                $json = array("success" => FALSE, "msg" => "Global postback is not setted");
            }

            echo json_encode($json);
        }
    }

}
