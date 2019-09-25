<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_banner
 *
 * @author Nexgen
 */
class m_banner extends CI_Model {
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function getBannerImages($module_id) {
        $this->db->select("module_setting")->from("modules")->where(array("module_id"=>$module_id));
        return  $this->db->get()->row_array();
    }
}
