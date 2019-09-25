<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_offer_utility
 *
 * @author kuldeep
 */
class m_offer_utility extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function getCampaign($filters=array()) {
        $select = "c.campaign_id as id,c.campaign_name as text";
        $this->db->select($select);
        $this->db->from("campaign c");
        $this->db->where("c.status", 1);
        
        $this->db->where("c.ctype", OFFER);
        
        if (isset($filters['advertiser_id']) && $filters['advertiser_id'] != '') {
            $this->db->where("c.advertiser_id",$filters['advertiser_id']);
        }
        
        if (isset($filters['campaign_name']) && $filters['campaign_name'] != '') {
            $this->db->like("c.campaign_name",$filters['campaign_name'],"left");
        }
        
        $this->db->order_by("c.campaign_name", "ASC");
        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db->limit(10, (int) $filters['limit']);
        } else {
            $this->db->limit(100, 0);
        }
        $campaigns = $this->db->get()->result_array();
//        $list = array();
//        $list[0] = "Not Now";
//        if (!empty($campaigns)) {
//            foreach ($campaigns as $camp) {
//                $list[$camp['campaign_id']] = $camp['campaign_name'];
//            }
//        }
        
//        echo $this->db->last_query();

        return $campaigns;
    }

    
    public function getPost($filters=array()) {
        $select = "cp.post_id as id,c.campaign_name as text";
        $this->db->select($select);
        $this->db->from("campaign c");
        $this->db->join("campaign_to_post cp","cp.campaign_id=c.campaign_id");
        $this->db->where("c.status", 1);
        
        $this->db->where("c.ctype", OFFER);
        
         if (isset($filters['advertiser_id']) && $filters['advertiser_id'] != '') {
            $this->db->where("c.advertiser_id",$filters['advertiser_id']);
        }
        
        if (isset($filters['campaign_name']) && $filters['campaign_name'] != '') {
            $this->db->like("c.campaign_name",$filters['campaign_name'],"left");
        }
        $this->db->order_by("c.campaign_name", "ASC");
        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db->limit(10, (int) $filters['limit']);
        } else {
            $this->db->limit(100, 0);
        } 
        $campaigns = $this->db->get()->result_array();
        return $campaigns;
    }
}
