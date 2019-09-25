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
 * @author kuldeep
 */
class api_token extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com"); $this->com->is_admin();
        $this->load->model("admin/m_api_token");
        
    }

    public function showApiTokenRequest() {

        $this->load->helper("form");
        $request = $this->input->post();
        $data = array();
        if ($request) {
            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            $data['tokenReq'] = $this->m_api_token->getTokenRequest($request);
            echo json_encode($data['tokenReq']);
            return;
        }

        $data['UTID'] =AFFILIATE;

        $data['PageContent'] = $this->load->view("admin/api/all-request", $data, TRUE);
        $this->load->view("admin/template", $data);
    }
    
    public function ChangeUsrTokenStatus() {
        
        

        $request = $this->input->post();
        $json = array("success" => FALSE, "msg" => "Token Status Not Changes");
        if ($request) {
           
            $updateData = array();
            $updateData['status'] = isset($request['status']) ? $request['status'] : 0;
            if ($this->m_api_token->ChangeStatus($request, $updateData)) {
                $json = array("success" => TRUE, "msg" => "Token Status Changed");
            } else {
                $json = array("success" => FALSE, "msg" => "Token Status Not Changes");
            }
        }

        echo json_encode($json);
    }

}
