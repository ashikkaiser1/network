<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_devices
 *
 * @author kuldeep
 */
class m_devices extends CI_Model {
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function getDevices() {
        
        return $this->db->select("device_id,name")->from("device_master")->get()->result_array();
    }
    
    public function getOS() {
        
        return $this->db->select("os_name,os_fullname")->from("os_master")->get()->result_array();
    }
}
