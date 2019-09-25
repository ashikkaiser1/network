<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_macros
 *
 * @author NexGen
 */
class m_macros  extends CI_Model{
    //put your code here
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getMacros($filters = array()) {
        
        $this->db->select("*")->from("macros");
        $this->db->order_by("sort","ASC");
        return $this->db->get()->result_array();
    }
    
    
    public function CreateMacro($macro) {

        $this->db->insert("macros", $macro);
        return $this->db->insert_id();
    }

    public function macro_sort_and_update($macro = array(), $macro_id = 0) {
        $this->db->where("macro_id", $macro_id);
        $this->db->update("macros", $macro);

        return $this->db->affected_rows();
    }

    public function deleteMacros($macro_id = 0) {
        $this->db->where("macro_id", $macro_id);
        $this->db->delete("macros");

        return $this->db->affected_rows();
    }
}
