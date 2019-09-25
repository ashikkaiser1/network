<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of load_module
 *
 * @author kuldeep
 */
class module extends CI_Model {
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function load($module_id,$page) {
        
         $this->db->select("*")->from("modules")->where(array("module_layout"=>$module_id,"status"=>1,"store_id"=>STORE_ID));
         $this->db->where("(page='$page' OR page='all')",NULL,FALSE);
        // $this->db->or_where("page","all");
         //where(array(""));
         $modules= $this->db->order_by("sort","ASC")->get()->result_array();
         //echo $this->db->last_query();
         return $modules;
        //return $this->db->result_array();
        
    }
}
