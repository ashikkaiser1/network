<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of offers_api_manager
 *
 * @author kuldeep
 */
class offers_api_manager extends CI_Controller {

    //put your code here

    private $Netwroks = array();

    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com");
        $this->com->is_admin();
        //end
        $this->load->model("admin/m_offers_api_manager");
    }

    public function index() {
        $data = array();
        $data['networks'] = $this->m_offers_api_manager->getNetworks();

        $data['title'] = "Offer SYNC Center";

        $data['PageContent'] = $this->load->view("admin/offers_api_manager/index", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function getNetworkSeting() {

        $request = $this->input->post();
        $data['success'] = TRUE;
        if ($request) {
            $data['allNetworkSetting'] = $this->m_offers_api_manager->getNetworkSetting($request);
            if (!empty($data['allNetworkSetting'])) {
                $data['success'] = TRUE;
            }
            echo json_encode($data);
        }
    }
    
    public function delete_api() {
        $request = $this->input->post();
        if($request){
             $json = array("success" => FALSE);
             if (isset($request['ons_id']) && $request['ons_id']) {
               if ($this->m_offers_api_manager->DeleteAPI($request['ons_id'])) {
                    $json['success'] = TRUE;
                    $json['msg'] = "You API is Deleted successfully.";
                } else {
                    $json['success'] = FALSE;
                    $json['msg'] = "You API is not Deleted.";
                }  
             }
             
             echo json_encode($json);
        }
    }

    public function other_network_settings() {
        // Add Network Advetisera and APIs
        $request = $this->input->post();


        if ($request) {
            $json = array("success" => FALSE);
            if (isset($request['ons_id']) && $request['ons_id']) {
                //update the existing one

                if ($this->m_offers_api_manager->UpdateAPI($request, $request['ons_id'])) {
                    $json['success'] = TRUE;
                    $json['msg'] = "You API is updated.";
                } else {
                    $json['success'] = FALSE;
                    $json['msg'] = "You API is not updated.";
                }
            } else {
                // Ad New API
                unset($request['ons_id']);
                if ($this->m_offers_api_manager->AddAPI($request)) {
                    $json['success'] = TRUE;
                    $json['msg'] = "You API is Added.";
                } else {
                    $json['success'] = FALSE;
                    $json['msg'] = "You API is not Added. Please Check Valid Fields";
                }
            }
            
            echo json_encode($json);
            return;
        }




        $data = array();
        $data['networks'] = $this->m_offers_api_manager->getNetworks();
        $data['title'] = "Add New API";
        $data['PageContent'] = $this->load->view("admin/offers_api_manager/add-api", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

}
