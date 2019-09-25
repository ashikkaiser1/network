<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_country
 *
 * @author NexGen
 */
class m_country extends CI_Model {
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function get_country($filter = array()) {
        
        $this->db->select("oc.campaign_id as offer_id,oc.country_id,c.name,c.iso")->from("offer_country oc");
        $this->db->join("country c","c.id= oc.country_id");
        if(isset($filter['campaign_id']) && $filter['campaign_id']!='')
        {
            $this->db->where("oc.campaign_id",$filter['campaign_id']);
        }
        else
        {
            return array();
        }
        
        return $this->db->get()->result_array();
    }
}
