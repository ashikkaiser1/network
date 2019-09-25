<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of refferal_program
 *
 * @author kuldeep
 */
class refferal_program extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();

        //check the login for user
        $this->load->library("common/com");
        $this->com->is_admin();
        //end

        $this->load->model("admin/m_refferal_program");
    }

    public function index() {

        $request = $this->input->post();
        if ($request) {

            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            $data['users'] = $this->m_refferal_program->getUsers($request);
            echo json_encode($data);
            return;
        }

        $data = array();
        $data['UTID'] = AFFILIATE;
        $data['title'] = "Referral Program Report";
        $data['PageContent'] = $this->load->view("admin/refferal_program/all_referal_list", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

}
