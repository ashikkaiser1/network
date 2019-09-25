<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of creative
 *
 * @author NexGen
 */
class creative extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com"); $this->com->is_admin();
        //end
        $this->load->model("admin/m_creative");
        $this->load->model("admin/m_campaign");
        $this->load->helper("form");
    }

    public function index() {


        $data = array();

        $filter = array();
        $filter['type'] = OFFER;
        $filter['Formated'] = "TRUE";
        $filter['status'] = 1;
        $filter['group_by'] ='campaign_id';
        $camp =array();
//                $this->m_campaign->getCampaign($filter);
        unset($camp[0]);
        $data['Camapign'] = $camp;
//        $data['creative'] = $this->m_creative->getCreative(0,array("allchild"=>true));
//        $data['cat_type'] = array(OFFER => "OFFER", NORMALCAMP => "CAMPAIGN");

        $data['Submiting'] = "Creating..";
        $data['allCreative'] = $this->load->view("admin/creative/all-creative", $data, TRUE);
        $data['PageContent'] = $this->load->view("admin/creative/add-creative", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function upload_creative() {
        $image = $this->do_upload("file");

        $request = $this->input->post();
        $creative = array();
        $json = array();
        if (!isset($image['error'])) {
            $creative['creative_link'] = UPLOAD . "creative/" . $image['upload_data']['file_name'];
            $creative['status'] = 1;
            $creative['creative_name'] = $image['upload_data']['file_name'];
            if (!empty($creative)) {
                $creative_id = 0;
                if ($creative_id = $this->m_creative->setCreative($creative)) {
                    $campaign_ids = isset($request['campaign_id']) ? $request['campaign_id'] : array();
                    $this->m_creative->setCreativeToOffer($campaign_ids, $creative_id);

                    $json['success'] = TRUE;
                    $json['msg'] = "Creative Addred";
                    $json['data'] = $image;
                } else {
                    $json['success'] = FALSE;
                    $json['msg'] = "Creative can't Addred";
                }

                echo json_encode($json);

                return;
            }
        }

        $json['success'] = FALSE;
        $json['msg'] = "Creative can't Added";
        $json['data'] = $image;

        echo json_encode($json);
    }

    public function updateLinkToOffer() {
        $request = $this->input->post();
        if ($request) {
            $campaign_ids = isset($request['campaign_id']) ? $request['campaign_id'] : array();
            $creative_id = $request['creative_id'];
            $this->m_creative->setCreativeToOffer($campaign_ids, $creative_id);
            $json['success'] = TRUE;
            $json['msg'] = "Creative Added to offer";
        } else {
            $json['success'] = FALSE;
            $json['msg'] = "Creative can't Added to offer";
        }
        echo json_encode($json);
    }

    public function getCreativeOffers() {

        $request = $this->input->post();
        $data = array();
        if ($request) {
//            $data['creativeOffers'] = array_column($this->m_creative->getCreativeOffers($request), "campaign_id");
            $data['creativeOffers'] = $this->m_creative->getCreativeOffers($request);
            
            $data['result'] =  array();
            foreach ($data['creativeOffers'] as $row) {
                $data['result'][] = array(
                    'id' => $row['campaign_id'],
                    'text' =>  $row['campaign_name'],
                    'selected'> true
                    
                );
            }

            $data['success'] = TRUE;

            echo json_encode($data);

            return;
        }
        $data['success'] = FALSE;

        echo json_encode($data);

        return;
    }

    public function getCreative() {
        $request = $this->input->post();
        if ($request) {
            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            $data['creative'] = $this->m_creative->getCreative($request);
            echo json_encode($data);
            return;
        }
    }

    public function getOfferCreative() {
        $request = $this->input->post();
        if ($request) {
            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            $data['creative'] = $this->m_creative->getOfferCreative($request);
            echo json_encode($data);
            return;
        }
    }

    public function deleteCreative() {
        $request = $this->input->post();

        if ($request) {
            $json = array();
            $creative_id = $request['creative_id'];
            // $request['status'] = isset($request['status']) ? 1 : 0;
            if ($this->m_creative->deleteCreative($creative_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your creative is Deleted.";

                $json['data'] = $request;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your creative canot be Deleted.";
            }

            echo json_encode($json);
            return;
        }
    }

    public function do_upload($user_file, $folder = "creative") {
        $data = array();

        $config['upload_path'] = APPPATH . "../upload/" . $folder;
        $config['allowed_types'] = '*';
        $config['max_size'] = 2048000000;
//        $config['max_width'] = 1024;
//        $config['max_height'] = 768;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($user_file)) {
            $data = array('error' => $this->upload->display_errors());
//            echo '<pre>';
//            print_r($error);
            // $this->load->view('upload_form', $error); 
        } else {
            $data = array('upload_data' => $this->upload->data());
            // $this->load->view('upload_success', $data); 
        }

        return $data;
    }

//      public function deleteCreative($creative_id=0) {
//        //create a user 
//
//        $request = $this->input->post();
//
//        if ($request) {
//            $json = array();
//            $creative_id = $request['creative_id'];
//           // $request['status'] = isset($request['status']) ? 1 : 0;
//            if ($this->m_creative->deleteCreative($creative_id)) {
//                $json['success'] = TRUE;
//                $json['msg'] = "Your new creative is Deleted.";
//                
//                $json['data'] = $request;
//            } else {
//                $json['success'] = FALSE;
//                $json['msg'] = "Your new creative canot be Deleted.";
//            }
//
//            echo json_encode($json);
//            return;
//        }
//
//
//    }
//    
//     public function UpdateCreative($creative_id=0) {
//        //create a user 
//
//        $request = $this->input->post();
//
//        if ($request) {
//            $json = array();
//            $creative_id = $request['creative_id'];
//           
//            if ($this->m_creative->creative_sort_and_update($request,$creative_id)) {
//                $json['success'] = TRUE;
//                $json['msg'] = "Your new creative is updated.";
//                
//                $json['data'] = $request;
//            } else {
//                $json['success'] = FALSE;
//                $json['msg'] = "Your new creative canot be updated.";
//            }
//
//            echo json_encode($json);
//            return;
//        }
//
//
//    }
//   
//
//    public function creative_sort() {
//        //$jsonPOST = json_decode(file_get_contents("php://input"));
//        $sort = 0;
//        $request = $this->input->post();
//        $jsonPOST =  json_decode($request["data"],TRUE);
//
////        
////        echo '<pre>';
////        print_r($jsonPOST);
//        
//        foreach ($jsonPOST as $creative) {
//
//            $sort = $this->Extract_Menus($creative, $sort);
//        }
//
//        echo json_encode(array("success" => TRUE));
//    }
//
//    public function Extract_Menus($creative, $sort, $ParentID = 0) {
//        $FormData = array("sort" => $sort, "parent_id" => $ParentID);
//        $this->m_creative->creative_sort_and_update($FormData,$creative['id']);
//        $ParentID = $creative['id'];
//        $sort++;
//        if (!array_key_exists('children', $creative)) {
//            return $sort;
//        }
//        foreach ($creative['children'] as $Men) {
//            $sort = $this->Extract_Menus($Men, $sort, $ParentID);
//        }
//        return $sort;
//    }
}
