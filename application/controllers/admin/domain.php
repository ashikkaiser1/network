<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of domain
 *
 * @author NexGen
 */
class domain extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
         //check the login for user
        $this->load->library("common/com"); $this->com->is_admin();
        //end

        $this->load->model("admin/m_domain");
    }

    public function CreateDomain() {

        $request = $this->input->post();

        if ($request) {
            $json = array();
            if ($this->m_domain->CreateDomain($request)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your new domain is added.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your new domain can be added.";
            }

            echo json_encode($json);
            return;
        }



        $data = array();
        
        
        
        $data['domain'] = $this->m_domain->getDomain();
       
        
        
        
        $data['Submiting'] = "Creating..";
        $data['allDomain'] = $this->load->view("admin/domain/all-domain", $data, TRUE);
        $data['PageContent'] = $this->load->view("admin/domain/add-domain", $data, TRUE);
        $this->load->view("admin/template", $data);
    }
    
    public function setdefault($domain_id=0) {
        if($domain_id==0){
            return;
        }
        
        $setUpdate = array("default"=>0);
        $this->m_domain->UpdateAllDomain($setUpdate);
        $setUpdate = array("default"=>1);
        $this->m_domain->UpdateDomain($setUpdate, $domain_id);
        
        $this->CreateDomain();
    }

    public function UpdateDomain($domain_id=0) {

        $request = $this->input->post();

        if ($request) {
            $json = array();
            $domain_id = $request['domain_id'];

            if ($this->m_domain->UpdateDomain($request, $domain_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your new domain is updated.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your new domain can't be updated.";
            }

            echo json_encode($json);
            return;
        }



        $data = array();
        $filters = array();
        $filters['domain_id'] = $domain_id;
        $data['domain'] = $this->m_domain->getDomain($filters);
        
//        echo '<pre>';
//        print_r($data['domain']);

        $data['PageContent'] = $this->load->view("admin/domain/update-domain", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    
      public function deletedomain($domain_id=0) {
        //create a user 

        $request = $this->input->post();    

        if ($request) {
            $json = array();
            $domain_id = $request['domain_id'];
           // $request['status'] = isset($request['status']) ? 1 : 0;
            if ($this->m_domain->deletedomain($domain_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your domain is deleted.";
                
                $json['data'] = $request;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your domain canot be deleted.";
            }

            echo json_encode($json);
            return;
        }


    }
}
