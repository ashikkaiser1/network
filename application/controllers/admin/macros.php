<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of macros
 *
 * @author NexGen
 */
class macros extends CI_Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
         //check the login for user
        $this->load->library("common/com"); $this->com->is_admin();
        //end
        $this->load->model("admin/m_macros");
        
        $this->load->helper("form");
    }
    
    public function CreateMacro() {
        //create a user 

        $request = $this->input->post();

        if ($request) {
            $json = array();
            if ($this->m_macros->CreateMacro($request)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your new macro is added.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your new macro can be added.";
            }

            echo json_encode($json);
            return;
        }


        $data = array();
        $data['macro'] = $this->m_macros->getMacros(0,array("allchild"=>true));
        $data['cat_type'] = array(OFFER => "OFFER", NORMALCAMP => "CAMPAIGN");
        
        $data['Submiting'] ="Creating..";
        $data['allMacros'] = $this->load->view("admin/macro/all-macro", $data, TRUE);
        $data['PageContent'] = $this->load->view("admin/macro/add-macro", $data, TRUE);
        $this->load->view("admin/template", $data);
    }
    
    public function getMacros() {
        
         $data = array();
         $data['macros'] = $this->m_macros->getMacros(0,array("allchild"=>true));
         echo json_encode($data);
    }
    
    
      public function deleteMacros($macro_id=0) {
        //create a user 

        $request = $this->input->post();

        if ($request) {
            $json = array();
            $macro_id = $request['macro_id'];
           // $request['status'] = isset($request['status']) ? 1 : 0;
            if ($this->m_macros->deleteMacros($macro_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your new macro is Deleted.";
                
                $json['data'] = $request;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your new macro canot be Deleted.";
            }

            echo json_encode($json);
            return;
        }


    }
    
     public function UpdateMacros($macro_id=0) {
        //create a user 

        $request = $this->input->post();

        if ($request) {
            $json = array();
            $macro_id = $request['macro_id'];
           
            if ($this->m_macros->macro_sort_and_update($request,$macro_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your macro is updated.";
                
                $json['data'] = $request;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your macro canot be updated.";
            }

            echo json_encode($json);
            return;
        }


    }
   

    public function macro_sort() {
        //$jsonPOST = json_decode(file_get_contents("php://input"));
        $sort = 0;
        $request = $this->input->post();
        $jsonPOST =  json_decode($request["data"],TRUE);
//        
//        echo '<pre>';
//        print_r($jsonPOST);
        
        foreach ($jsonPOST as $macro) {

            $sort = $this->Extract_Macro($macro, $sort);
        }

        echo json_encode(array("success" => TRUE));
    }

    public function Extract_Macro($macro, $sort, $ParentID = 0) {
        $FormData = array("sort" => $sort);
        $this->m_macros->macro_sort_and_update($FormData,$macro['id']);
        $ParentID = $macro['id'];
        $sort++;
        if (!array_key_exists('children', $macro)) {
            return $sort;
        }
        foreach ($macro['children'] as $Men) {
            $sort = $this->Extract_Macro($Men, $sort, $ParentID);
        }
        return $sort;
    }
}
