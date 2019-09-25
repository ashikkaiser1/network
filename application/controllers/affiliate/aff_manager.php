<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**my_aff_manager
 * Description of aff_manager
 *
 * @author kuldeep
 */
class aff_manager extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
//        //check the login for user
        $this->load->library("common/com");
        $this->com->is_affiliate();
        $this->load->model("admin/m_users");
        //end
    }

    public function index() {

        $this->my_aff_manager();
    }

    public function my_aff_manager() {
        $data = array();
        $filter = array();
        $filter['UTID'] = ACC_MANAGER;
        $filter['uid'] = MANAGER;
        $filter['manager'] = 'true';
        $this->load->model("admin/m_users");
        $data['acc_manager'] = $this->m_users->getUsers($filter);
//        echo "<pre>";
//        print_r($data);
//        die();
        if (!empty($data['acc_manager'])) {

            $acc_manger = array();
            $acc_manger['name'] = $data['acc_manager']['name'];
            $acc_manger['email'] = $data['acc_manager']['email'];
            $acc_manger['skype_id'] = $data['acc_manager']['skype_id'];
            $acc_manger['company'] = $data['acc_manager']['company'];
            $data['acc_manager'] = $acc_manger;

            $request = $this->input->post();
            if ($request) {
                echo json_encode($data);
                return;
            }
        }else
        {
            $request = $this->input->post();
            if ($request) {
                echo json_encode($data);
                return;
            }
        }
        $data['PageContent'] = $this->load->view("affiliate/acc_mananger/index", $data, TRUE);
        $this->load->view("affiliate/template", $data);
    }

    public function my_aff_manager2() {
        $data = array();
        $filter = array();
        $filter['UTID'] = ACC_MANAGER;
        $filter['uid'] = MANAGER;
        $filter['manager'] = 'true';
        $this->load->model("admin/m_users");
        $data['acc_manager'] = $this->m_users->getUsers($filter);
//        echo "<pre>";
//        print_r($data);
//        die();
        $data['PageContent'] = $this->load->view("affiliate/acc_mananger/index", $data, TRUE);
        $this->load->view("affiliate/template", $data);
    }

}
