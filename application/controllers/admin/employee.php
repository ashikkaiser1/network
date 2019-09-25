<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of employee
 *
 * @author NexGen
 */
class employee extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com");
        $this->com->is_admin();
        //end
        $this->load->model("admin/m_employee");
        $this->load->model("account/m_account");
        $this->load->helper("form");
    }

    public function CreateEmployee() {
        //create a user 



        $request = $this->input->post();

        if ($request) {
            $json = array();

            switch ($request['UTID']) {
                case 1: $request['aff_id'] = uniqid("ADMIN") . date("dmy", time());
                    break;
                case 2: $request['aff_id'] = uniqid("AFF") . date("dmy", time());
                    break;
                case 3: $request['aff_id'] = uniqid("ADV") . date("dmy", time());
                    break;
                default: $request['aff_id'] = uniqid("AFF") . date("dmy", time());
                    break;
            }

            $uid = 0;
            $request['DOJ'] = date("d-m-Y", time());
            if ($uid = $this->m_employee->CreateEmployee($request)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your new user is added.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your new user can be added.";
            }

            echo json_encode($json);
            return;
        }


        $data = array();

        $filter = array();
        $filter['formated'] = TRUE;
        $data['userType'] = $this->m_account->getUserType($filter);

        $filter = array();
        $filter['formated'] = TRUE;
        $data['country'] = $this->m_account->getCountry($filter);



        $data['FormAction'] = SITEURL . "admin/employee/CreateEmployee";
        $data['FormSubmitBtn'] = "Save";
        $data['SubmitAction'] = "Creating...";
        $data['panel_title'] = "Add New Employee";
        $data['PageContent'] = $this->load->view("admin/employee/add-employee", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function UpdateEmployee($uid = 0) {
        //create a user 
        $request = $this->input->post();
        if ($request) {
            $json = array();
            if ($this->m_employee->UpdateEmployee($request, $uid)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your user is Updated.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your user can't be Updated.";
            }

            echo json_encode($json);
            return;
        }





        $data = array();
        $filter = array();
        $filter['uid'] = $uid;
        $data['user'] = $this->m_employee->getEmployee($filter);

        $filter = array();
        $filter['formated'] = TRUE;
        $data['userType'] = $this->m_account->getUserType($filter);

        $filter = array();
        $filter['formated'] = TRUE;
        $data['country'] = $this->m_account->getCountry($filter);


        $data['FormAction'] = SITEURL . "admin/employee/UpdateEmployee/" . $uid;
        $data['FormSubmitBtn'] = "Update";
        $data['SubmitAction'] = "Updating...";
        $data['panel_title'] = "Update Employee";
//        echo '<pre>';
//        print_r($data['user']);
//        die();
        $data['PageContent'] = $this->load->view("admin/employee/add-employee", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function ViewEmployee($uid = 0) {
        //View a user 


        $data = array();
        $filter = array();
        $filter['uid'] = $uid;
        $data['user'] = $this->m_employee->getEmployee($filter);


        $filter = array();
        $filter['formated'] = TRUE;
        $data['userType'] = $this->m_account->getUserType($filter);

        $filter = array();
        $filter['formated'] = TRUE;
        $data['country'] = $this->m_account->getCountry($filter);



        $data['FormAction'] = SITEURL . "admin/employee/UpdateEmployee/" . $uid;
        $data['FormSubmitBtn'] = "Update";
        $data['SubmitAction'] = "Updating...";
        $data['panel_title'] = "Employee Deatils";
//        echo '<pre>';
//        print_r($data['user']);
//        die();
        $data['PageContent'] = $this->load->view("admin/employee/view-employee", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function updateEmployeeTrafficOptions($trafic_info = array(), $uid = 0) {


        //set the offer contryies where publisher wants to show offers
        if (isset($trafic_info['offer_countries']))
            $this->m_employee->setUsrOfferCountry($trafic_info['offer_countries'], $uid);
        //end
        //set the offer categaries inn which publisher interested.
        if (isset($trafic_info['offer_interest']))
            $this->m_employee->setUsrOfferInterest($trafic_info['offer_interest'], $uid);
        //end
        ///set the offer type in which publisher deals. It may be apk ,etx
        if (isset($trafic_info['offer_type']))
            $this->m_employee->setUsrofferType($trafic_info['offer_type'], $uid);
        //end
        //set the verticals of offer category in which publisher already in orworking 
        if (isset($trafic_info['offer_veticals']))
            $this->m_employee->setUsrOfferVertical($trafic_info['offer_veticals'], $uid);
        //emd
        //set the type of traffic publisher create a form facebbok or other media
        if (isset($trafic_info['offer_promotional']))
            $this->m_employee->setUsrTraffictype($trafic_info['offer_promotional'], $uid);
        //end

        return TRUE;
    }

    public function ShowEmployees() {
        //create a user 
        $data = array();

        $request = $this->input->post();
        if ($request) {

            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            $data['employee'] = $this->m_employee->getEmployee($request);
            echo json_encode($data['employee']);
            return;
        }


        $data['PageContent'] = $this->load->view("admin/employee/all-employee", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function permission_manager($uid = 0) {
        
        //this module help admin to set permission for Affiliate Manager
        
        //
        $request = $this->input->post();
        if ($request) {
            $json = array();
            $json['success'] = FALSE;

            $batch = array();
            if (!empty($request['permission']) && isset($request['uid']) && $request['uid'] != '') {

                foreach ($request['permission'] as $permission) {
                    $batch[] = array(
                        "uid" => $request['uid'],
                        "p_id" => $permission
                    );
                }

                if (!empty($batch)) {

                    if ($this->m_employee->set_employee_permission($batch, $request['uid'])) {
                        $json['success'] = TRUE;
                        $json['msg'] = "The permissions are set to selected user";
                    } else {
                        $json['success'] = FALSE;
                        $json['msg'] = "The permissions can't set to selected user";
                    }
                }
            }

            echo json_encode($json);

            return;
        }

        $data = array();
        $data['uid'] = $uid;
        $data['permissions'] = $this->m_system->get_permissions($uid);
        $permission_list = array();
        if (!empty($data['permissions'])) {
            $data['permissions'] = array_column($data['permissions'], "p_id");
            foreach ($data['permissions'] as $row) {
                $permission_list[$row] = $row;
            }
        }
        $data['permissions'] = $permission_list;
        $data['PageContent'] = $this->load->view("admin/employee/all-permission", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

}
