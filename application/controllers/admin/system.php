<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of system
 *
 * @author NexGen
 */
class system extends CI_Controller {//put your code here

    public $transaction_id_type = array("random" => "Random Number",
        "IP/YY/MM/DD" => "IP Address / Date",
        "IP/YY/MM/DD/OFFER_ID" => "IP Address / Date / Offer ID / User Agent");

    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com");
        $this->com->is_admin();
        //end
        $this->load->model("admin/m_system");
        $this->load->helper("form");
    }

    public function index() {

        $request = $this->input->post();
        if ($request) {
            $this->SetSetting($request);
            return;
        }

        $data['FormAction'] = SITEURL . "admin/system/index";
        $data['SubmitBtn'] = "Create";
        $data['Submiting'] = "Creating...";
        $data['title'] = "System Settings";
        $data['tr_type'] = $this->transaction_id_type;
        $filters = array();
        $filters['Formated'] = 'TRUE';
        $data['settings'] = $this->m_system->getSettings($filters);
        // $data['Campaign'] = $this->m_campaign->getCategory(0,array("allchild"=>true));
        //$data['allCategory'] = $this->load->view("admin/Campaign/all-Campaign", $data, TRUE);
        $data['PageContent'] = $this->load->view("admin/system/v-system", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function SetSetting($request = array()) {
        $json = array();
        $json['success'] = false;

        if ($this->m_system->SetSetting($request['option'])) {
            $json['success'] = TRUE;
            $json['msg'] = "Setting Saved Successfully";
        } else {
            $json['msg'] = "Setting not Saved Successfully";
        }

        echo json_encode($json);
    }

    public function remove_logo_favicon() {

        $request = $this->input->post();
        $json = array("success" => FALSE, "msg" => "NO data in request..!!!!");

        if ($request) {
            $option_name = isset($request['option_name']) ? $request['option_name'] : FALSE;
            $option = array();
            $option['option_value'] = '';
            if ($this->m_system->update_settings($option, $option_name)) {
                $json['success'] = TRUE;
                $json['msg'] = "Successfully Removed";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "There is an error .. Something went wrong.. !!!!";
            }
        }

        echo json_encode($json);
    }

    public function setup_logo_favicon() {

        $this->load->model("utility/m_upload");
        $image = $this->m_upload->do_upload("file", '');
        $request = $this->input->post();
        $media = array();
        $json = array();
        if (!isset($image['error'])) {
            $media['option_value'] = UPLOAD . $image['upload_data']['file_name'];
            $media['status'] = 1;
            $option_name = '';
            $type = isset($request['type']) ? $request['type'] : FALSE;
            if ($type && $type == 'logo') {
                $option_name = "LOGO";
            } elseif ($type && $type == 'favicon') {
                $option_name = 'FAVICON';
            }


            if (!empty($media)) {

                if ($this->m_system->update_settings($media, $option_name)) {
                    $json['success'] = TRUE;
                    $json['msg'] = "Successfully Updated";
                    $json['data'] = $image;
                } else {
                    $json['success'] = FALSE;
                    $json['msg'] = "There is an error .. Something went wrong.. !!!!";
                }

                echo json_encode($json);

                return;
            }
        }

        $json['success'] = FALSE;
        $json['msg'] = "There is an error .. Something went wrong.. !!!!";


        echo json_encode($json);
    }

    public function get_menus() {
        //get menus for admin pane in permission panel so
        // that admin can grant oermission to affiliate manager
        $request = $this->input->post();
        $json = array("success" => FALSE);
        if ($request) {
            $json['menus'] = $this->m_system->get_main_menus(0);
        }
        echo json_encode($json);
    }

    public function get_menu_access() {

        //get menus for Affiliate Access
        $request = $this->input->post();
        $json = array("success" => FALSE);
        if ($request) {
            $json['menus'] = $this->m_system->get_aff_manager_menus(UID,0);
        }

        echo json_encode($json);
    }

}
