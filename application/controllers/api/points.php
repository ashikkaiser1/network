<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of points
 *
 * @author kuldeep
 */
class points extends CI_Controller {
    //put your code here
    
    //put your code here
    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com_api");
        $this->load->model("api/m_reports");
        
        //end
    }
    
    public function get_points() {
        
        $request = $this->input->get();
        if($request){
            
            
            $data['points']=$this->m_reports->get_app_user_points($request);
            
            echo json_encode($data);
            
            
        }
        
    }
}
