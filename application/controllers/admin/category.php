<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of category
 *
 * @author NexGen
 */
class category extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
         //check the login for user
        $this->load->library("common/com"); $this->com->is_admin();
        //end
        $this->load->model("admin/m_category");
        
        $this->load->helper("form");
        
        
        
    }

    public function CreateCategory() {
        //create a user 

        $request = $this->input->post();

        if ($request) {
            $json = array();
            if ($this->m_category->CreateCategory($request)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your new category is added.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your new category can be added.";
            }

            echo json_encode($json);
            return;
        }


        $data = array();
        $data['category'] = $this->m_category->getCategory(0,array("allchild"=>true));
        $data['cat_type'] = array(OFFER => "OFFER", NORMALCAMP => "CAMPAIGN");
        
        $data['Submiting'] ="Creating..";
        $data['allCategory'] = $this->load->view("admin/category/all-category", $data, TRUE);
        $data['PageContent'] = $this->load->view("admin/category/add-category", $data, TRUE);
        $this->load->view("admin/template", $data);
    }
    
    
      public function deleteCategory($category_id=0) {
        //create a user 

        $request = $this->input->post();

        if ($request) {
            $json = array();
            $category_id = $request['category_id'];
           // $request['status'] = isset($request['status']) ? 1 : 0;
            if ($this->m_category->deleteCategory($category_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your new category is Deleted.";
                
                $json['data'] = $request;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your new category canot be Deleted.";
            }

            echo json_encode($json);
            return;
        }


    }
    
     public function UpdateCategory($category_id=0) {
        //create a user 

        $request = $this->input->post();

        if ($request) {
            $json = array();
            $category_id = $request['category_id'];
           
            if ($this->m_category->category_sort_and_update($request,$category_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your new category is updated.";
                
                $json['data'] = $request;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your new category canot be updated.";
            }

            echo json_encode($json);
            return;
        }


    }
   

    public function category_sort() {
        //$jsonPOST = json_decode(file_get_contents("php://input"));
        $sort = 0;
        $request = $this->input->post();
        
        $jsonPOST =  json_decode($request["data"],TRUE);

//        
//        echo '<pre>';
//        print_r($jsonPOST);
        
        foreach ($jsonPOST as $category) {

            $sort = $this->Extract_Menus($category, $sort);
        }

        echo json_encode(array("success" => TRUE)); 
        
        //
    }

    public function Extract_Menus($category, $sort, $ParentID = 0) {
        $FormData = array("sort" => $sort, "parent_id" => $ParentID);
        $this->m_category->category_sort_and_update($FormData,$category['id']);
        $ParentID = $category['id'];
        $sort++;
        if (!array_key_exists('children', $category)) {
            return $sort;
        }
        foreach ($category['children'] as $Men) {
            $sort = $this->Extract_Menus($Men, $sort, $ParentID);
        }
        return $sort;
    }

}
