<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_offers_api_manager
 *
 * @author kuldeep
 */
class m_offers_api_manager extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function AddAPI($API = array()) {
        $this->db->insert("other_network_setting", $API);
        return $this->db->insert_id();
    }

    public function UpdateAPI($API = array(), $ons_id = 0) {
        $this->db->where("ons_id", $ons_id);
        $this->db->update("other_network_setting", $API);
        return $this->db->affected_rows();
    }

    public function DeleteAPI($ons_id = 0) {
        $this->db->where("ons_id", $ons_id);
        $this->db->delete("other_network_setting");
        return $this->db->affected_rows();
    }

    public function getNetworks($filters = array()) {

        $this->db->select("*")->from("other_network_master");
        return $this->db->get()->result_array();
    }

    public function getNetworkSetting($filters = array()) {

        $this->db->select("nm.*,ons.*")->from("other_network_setting ons ");
        $this->db->join("other_network_master nm  ", "ons.network_id=nm.network_id", "LEFT");
        if (isset($filters['ons_id']) && $filters['ons_id'] != '') {
            $this->db->where("ons_id", $filters['ons_id']);
            return $this->db->get()->row_array();
        }
        return $this->db->get()->result_array();
    }

}
