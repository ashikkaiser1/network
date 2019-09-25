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
class globalpostback {

    //put your code here
    public function __construct($CI) {
        $this->CI = $CI;
        $this->CI->load->model("advertiser/modules/m_globalpostback", "g_postb");
    }

    public function index() {

        $data['post_back'] = $this->CI->g_postb->get_globalpostback(UID);
        return $this->CI->load->view("advertiser/modules/globalpostback/v-globalpostback", $data, TRUE);
        ///return "Leader Borad";
    }

    public function setGlobalPostBack() {

        $request = $this->CI->input->post();
        if ($request) {
            $request['uid'] = UID;
            if ($this->CI->g_postb->set_globalpostback($request)) {
                $json = array("success" => TRUE, "msg" => "Global postback is setted.");
            } else {
                $json = array("success" => FALSE, "msg" => "Global postback is not setted");
            }
            
            echo json_encode($json);
        }
    }

}
