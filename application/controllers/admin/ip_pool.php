<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ip_pool
 *
 * @author NexGen
 */
class ip_pool extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com"); $this->com->is_admin();
        //end
        $this->load->model("admin/m_ip_pool");
        $this->load->helper("form");
    }

    public function CreateIp() {

        $request = $this->input->post();

        $json = array("success" => FALSE, "msg" => "Not Added");
        if ($request) {

            if ($request['name'] != '' && $request['ip_address'] == '') {
               
                $request['ip_address'] = gethostbyname($request['name']);
            }

            if ($this->m_ip_pool->CreateIp_pool($request)) {
                $json = array("success" => TRUE, "msg" => "New IP Added");
            }

            echo json_encode($json);
            return 0;
        }

        $data['FormAction'] = SITEURL . "admin/ip_pool/CreateIp";
        $data['FormSubmitBtn'] = "Save";
        $data['SubmitAction'] = "Creating...";
        $data['panel_title'] = "Add New IPs";
        $data['PageContent'] = $this->load->view("admin/ip_pool/add-ips", $data, TRUE);
        $data['PageContent'] .= $this->load->view("admin/ip_pool/all-ips", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function UpdateIp($ip_id = 0) {

        $request = $this->input->post();

        $json = array("success" => FALSE, "msg" => "Not Update");
        if ($request) {
            
            if ($request['name'] != '' && $request['ip_address'] == '') {
                $request['ip_address'] = gethostbyname($request['name']);
            }
            
            if ($this->m_ip_pool->UpdateIp_pool($request, $ip_id)) {
                $json = array("success" => TRUE, "msg" => "IP Updated");
            }

            echo json_encode($json);
            return 0;
        }

        $filter = array();
        $filter['ip_id'] = $ip_id;
        $data['ip_pool'] = $this->m_ip_pool->getIPs($filter);

        $data['FormAction'] = SITEURL . "admin/ip_pool/UpdateIp/" . $ip_id;
        $data['FormSubmitBtn'] = "Update";
        $data['SubmitAction'] = "Update...";
        $data['panel_title'] = "Update IPs";
        $data['PageContent'] = $this->load->view("admin/ip_pool/add-ips", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function show_ips() {
        $request = $this->input->post();
        if ($request) {

            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            $data['ip_pool'] = $this->m_ip_pool->getIPs($request);
        }
        if (!empty($data['ip_pool'])) {
            $data['success'] = TRUE;
        } else {
            $data['success'] = FALSE;
        }
        echo json_encode($data);
    }

    public function deleteIp() {
        $request = $this->input->post();
        $json = array("success" => FALSE, "msg" => "Not Deleted");
        if ($request) {
            if ($this->m_ip_pool->deleteIp($request)) {
                $json = array("success" => TRUE, "msg" => "IP Deleted");
            }
            echo json_encode($json);
            return 0;
        }
    }

}
