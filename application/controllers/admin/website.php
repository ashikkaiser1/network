<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of website
 *
 * @author NexGen
 */
class website extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com"); $this->com->is_admin();
        //end
        $this->load->model("admin/m_website");
    }

    public function CreateWebsite() {

        $request = $this->input->post();

        if ($request) {
            $json = array();
            if ($this->m_website->CreateWebsite($request)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your new website is added.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your new website can be added.";
            }

            echo json_encode($json);
            return;
        }



        $data = array();
        $data['website'] = $this->m_website->getWebsite();
        $data['Submiting'] ='Creating..';
        $data['allWebsite'] = $this->load->view("admin/website/all-website", $data, TRUE);
        $data['PageContent'] = $this->load->view("admin/website/add-website", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function UpdateWebsite($web_id = 0) {

        $request = $this->input->post();

        if ($request) {
            $json = array();
            $web_id = $request['web_id'];

            if ($this->m_website->UpdateWebsite($request, $web_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your website is updated.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your website can't be updated.";
            }

            echo json_encode($json);
            return;
        }



        $data = array();
        $filters = array();
        $filters['web_id'] = $web_id;
        $data['website'] = $this->m_website->getWebsite($filters);
          $data['Submiting'] ='Updating..';
//        echo '<pre>';
//        print_r($data['website']);

        $data['PageContent'] = $this->load->view("admin/website/update-website", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function deletewebsite($web_id = 0) {
        //create a user 

        $request = $this->input->post();

        if ($request) {
            $json = array();
            $web_id = $request['web_id'];
            // $request['status'] = isset($request['status']) ? 1 : 0;
            if ($this->m_website->deletewebsite($web_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your website is deleted.";

                $json['data'] = $request;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your website canot be deleted.";
            }

            echo json_encode($json);
            return;
        }
    }

}
