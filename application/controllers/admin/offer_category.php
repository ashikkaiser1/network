<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of offer_category
 *
 * @author NexGen
 */
class offer_category extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com"); $this->com->is_admin();
        //end
        $this->load->model("admin/m_offer_category");
        $this->load->helper("form");
    }
    
    public function index() {
        
        $this->Createoffer_category();
    }

    public function Createoffer_category() {

        $request = $this->input->post();

        $json = array("success" => FALSE, "msg" => "Not Added");
        if ($request) {
            if ($this->m_offer_category->Createoffer_category($request)) {
                $json = array("success" => TRUE, "msg" => "New Offer Category /Vertical Added");
            }

            echo json_encode($json);
            return 0;
        }

        $data['FormAction'] = SITEURL . "admin/offer_category/Createoffer_category";
        $data['FormSubmitBtn'] = "Save";
        $data['SubmitAction'] = "Creating...";
        $data['panel_title'] = "Add New Offer Category / Verticals";
        $data['PageContent'] = $this->load->view("admin/offer_category/add-oc", $data, TRUE);
        $data['PageContent'] .= $this->load->view("admin/offer_category/all-oc", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function Updateoffer_category($offer_cat_id = 0) {

        $request = $this->input->post();

        $json = array("success" => FALSE, "msg" => "Not Update");
        if ($request) {
        
            if ($this->m_offer_category->Updateoffer_category($request, $offer_cat_id)) {
                $json = array("success" => TRUE, "msg" => "Offer Category Updated");
            }

            echo json_encode($json);
            return 0;
        }

        $filter = array();
        $filter['offer_cat_id'] = $offer_cat_id;
        $data['offer_category'] = $this->m_offer_category->getOfferCategory($filter);

        $data['FormAction'] = SITEURL . "admin/offer_category/Updateoffer_category/" . $offer_cat_id;
        $data['FormSubmitBtn'] = "Update";
        $data['SubmitAction'] = "Update...";
        $data['panel_title'] = "Update Offer Category / Verticals";
        $data['PageContent'] = $this->load->view("admin/offer_category/add-oc", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function show_offer_cat() {
        $request = $this->input->post();
        if ($request) {

            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            $data['offer_category'] = $this->m_offer_category->getOfferCategory($request);
        }
        if (!empty($data['offer_category'])) {
            $data['success'] = TRUE;
        } else {
            $data['success'] = FALSE;
        }
        echo json_encode($data);
    }

    public function deleteoffer_category() {
        $request = $this->input->post();
        $json = array("success" => FALSE, "msg" => "Not Deleted");
        if ($request) {
            if ($this->m_offer_category->deleteoffer_category($request)) {
                $json = array("success" => TRUE, "msg" => "Offer Category Deleted");
            }
            echo json_encode($json);
            return 0;
        }
    }

}
