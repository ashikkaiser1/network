<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_campaign_ip
 *
 * @author NexGen
 */
class m_campaign_ip extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function setipToCampaign($ipToCampaign = array()) {

        if (!empty($ipToCampaign)) {
            $this->db->insert_on_duplicate_update_batch("campaign_to_ip", $ipToCampaign, " camp_camp_ip_id=LAST_INSERT_ID(camp_camp_ip_id), ");
        }
        return TRUE;
    }

    public function getIps($filters = array()) {

        $this->db->select('*');
        $this->db->from("campaign_to_ip");
        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '') {
            $this->db->where("campaign_id", $filters['campaign_id']);
        }
        $ip_pool = $this->db->get()->result_array();
        return $ip_pool;
    }

    public function deleteip($filters = array()) {
        $this->db->where("camp_ip_id", isset($filters['camp_ip_id']) ? $filters['camp_ip_id'] : 0 );
        $this->db->delete("campaign_to_ip");
        return $this->db->affected_rows();
    }

}
