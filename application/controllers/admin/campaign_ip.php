<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of campaign_ip
 *
 * @author NexGen
 */
class campaign_ip extends CI_Controller {

    //put your code here
    //Class is used for setting up or whitelisting Advertisedr server ips

    public function __construct() {
        parent::__construct();

        //check the login for user
        $this->load->library("common/com"); $this->com->is_admin();
        $this->load->model("admin/m_campaign_ip");
        $this->load->model("admin/m_ip_pool");
    }

    public function SetIpWhiteList() {


        $request = $this->input->post();

        $json = array("success" => FALSE, "msg" => "Not Added");
        if ($request) {

            $campToip = array();
            $campToip[] = array("campaign_id" => $request['campaign_id'],
                "ip_address" => $request['ip_address']);

            if ($this->m_campaign_ip->setipToCampaign($campToip)) {
                $json = array("success" => TRUE, "msg" => "New IP Added");
            }

            echo json_encode($json);
            return 0;
        }
    }

    public function show_ips($campaign_id = 0) {

        $data = array();
        $data['success'] = FALSE;
        if ($campaign_id) {
            $filters = array();
            $filters['campaign_id'] = $campaign_id;

            $data['all_ips'] = $this->m_campaign_ip->getIps($filters);
            if (!empty($data['all_ips']))
                $data['success'] = TRUE;
        }

        echo json_encode($data);
    }

    public function setDefaultIps() {



        $request = $this->input->post();

        $json = array("success" => FALSE, "msg" => "Not Deleted");
        if ($request) {
            $filters = array();
            $filters['status'] = 1;
            $data['default_ip'] = $this->m_ip_pool->getIPs($filters);

            if (!empty($data['default_ip'])) {
                $Bulkip = array();
                foreach ($data['default_ip'] as $row) {
                    $Bulkip[] = array("campaign_id"=> $request['campaign_id'],
                        "ip_address" => $row['ip_address']);
                }

                if (!empty($Bulkip)) {
                    if ($this->m_campaign_ip->setipToCampaign($Bulkip)) {
                        $json = array("success" => TRUE, "msg" => "New IP Added");
                    }
                }
            }
        }

        echo json_encode($json);
    }

    public function deleteip() {
        $request = $this->input->post();

        $json = array("success" => FALSE, "msg" => "Not Deleted");
        if ($request) {
            if ($this->m_campaign_ip->deleteip($request)) {
                $json = array("success" => TRUE, "msg" => "IP Deleted");
            }
        }

        echo json_encode($json);
    }

}
