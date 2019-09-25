<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of faq
 *
 * @author kuldeep
 */
class faq extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();

        $this->load->library("common/com");
        $this->com->is_admin();

        $this->load->helper("url");
        $this->load->helper('form');
        $this->load->model('admin/m_faq');
        //  $this->load->model("publisher/utility", "util_model");
    }

    public function index() {
        $this->CreateFaq();
    }
    //function to show add new faq form
    public function CreateFaq() {

        $data['title'] = "Add FAQs";
        //  

        $request = $this->input->post();

        if ($request) {
            if ($this->m_faq->save_faq($request)) {
                $json = array("success" => TRUE, "msg" => "Success: FAQs Saved!");
            } else {
                $json = array("success" => FALSE, "msg" => "Error: FAQs not Saved!");
            }

            echo json_encode($json);
            return;
        }
        $data['Formaction'] = SITEURL . "admin/faq/CreateFaq";


        $data['Submiting'] = "Creating..";


        $data['PageContent'] = $this->load->view("admin/faq/add-faq", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    //function to update the faq details

    public function update_faq($faq_id = 0) {

        $request = $this->input->post();

        $data['title'] = "Update FAQs";

        $json = array("success" => FALSE);
        $data['action'] = "update_faq";

//        $this->load->model('admin/m_faq');

        if ($request) {

            if ($this->m_faq->update_faq($request, $faq_id)) {
                $json = array("success" => TRUE, "msg" => "Success: FAQs Updated!", "data" => $faq_id);
            } else {
                $json = array("success" => TRUE, "msg" => "Error: FAQs not Updated!");
            }

            echo json_encode($json);
            return;
        }

        $data['faq'] = $this->m_faq->get_faq_by_id($faq_id);
        $data['Formaction'] = SITEURL . "admin/faq/update_faq/" . $faq_id;


        $data['Submiting'] = "Updating..";


        $data['PageContent'] = $this->load->view("admin/faq/add-faq", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    //function to view and manage ie. change status, update, delete faqs
    public function allFAQs() {

        $data['title'] = "All FAQss";
        //
        $request = $this->input->post();
        if ($request) {
            $this->load->model('admin/m_faq');
            $request['uid'] = UID;
            if (UTID == ADMIN) {
                $request['all'] = "all";
            }
            $data['faqs'] = $this->m_faq->get_all_faqs($request);

            echo json_encode($data['faqs']);
            return;
        }

        $data['PageContent'] = $this->load->view("admin/faq/all-faqs", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function delete_faq() {

        $faq_id = $this->input->post();
        if ($faq_id) {
//            $this->load->model('admin/m_faq');

            if ($this->m_faq->delete_faq($faq_id['faq_id'])) {
                echo json_encode(array('success' => TRUE, 'msg' => 'FAQs Deleted!'));
            } else {
                echo json_encode(array('success' => FALSE, 'msg' => 'Error: FAQs not Deleted!'));
            }
            return;
        }
    }

    public function faq_change_status($faq_id = '', $status = 1) {
//        $this->load->model('admin/m_faq');
        if ($this->m_faq->faq_change_status($faq_id, $status)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false));
        }
    }

    //affiliate part
}
