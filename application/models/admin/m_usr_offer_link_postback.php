<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_usr_offer_link_postback
 *
 * @author kuldeep
 */
class m_usr_offer_link_postback extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();

        //table 
        //usr_offer_postback
    }

    public function add_new_posback($postback = array()) {
        $this->db->insert("usr_offer_postback", $postback);
        return $this->db->insert_id();
//        $this->db->
    }

    public function delete_postback($filter = array()) {

        if (isset($filter['uid']) && $filter['uid'] != '') {
            $this->db->where("uid", $filter['uid']);
        }
        if (isset($filter['domain_id']) && $filter['domain_id'] != '') {
            $this->db->where("domain_id", $filter['domain_id']);
        }
        if (isset($filter['campaign_id']) && $filter['campaign_id'] != '') {
            $this->db->where("campaign_id", $filter['campaign_id']);
        }
        if (isset($filter['goal_id'])) {
            $this->db->where("goal_id", $filter['goal_id']);
        }
        $this->db->delete("usr_offer_postback");
        return $this->db->affected_rows();
    }

    public function get_postback($filter = array()) {
        $this->db->select("*")->from("usr_offer_postback");
        if (isset($filter['uid']) && $filter['uid'] != '') {
            $this->db->where("uid", $filter['uid']);
        }
        if (isset($filter['domain_id']) && $filter['domain_id'] != '') {
            $this->db->where("domain_id", $filter['domain_id']);
        }
        if (isset($filter['campaign_id']) && $filter['campaign_id'] != '') {
            $this->db->where("campaign_id", $filter['campaign_id']);
        }
        if (isset($filter['goal_id'])) {
            $this->db->where("goal_id", $filter['goal_id']);
        }
        $this->db->order_by("goal_id", "ASC");
        return $this->db->get()->result_array();
    }

    public function getOfferGoals($filter = array()) {
        $this->db->select("campaign_id,offer_goal_id,name")->from("offer_goal");
        if (isset($filter['campaign_id']) && $filter['campaign_id'] != '') {
            $this->db->where("campaign_id", $filter['campaign_id']);
        }
        return $this->db->get()->result_array();
    }
    
    public function getAffiliatesPostbacks($filter = array()) {
        
        $this->db->select("uop.*,u.uid,u.name,u.company")->from("usr_offer_postback uop");
        $this->db->join("users as u","u.uid=uop.uid","LEFT");
        if (isset($filter['uid']) && $filter['uid'] != '') {
            $this->db->where("uid", $filter['uid']);
        }
        if (isset($filter['domain_id']) && $filter['domain_id'] != '') {
            $this->db->where("domain_id", $filter['domain_id']);
        }
        
        if (isset($filter['search']) && $filter['search'] != '') {
            
            $this->db->like("u.name",$filter['search'],"both");
            $this->db->or_like("u.company",$filter['search'],"both");
            $this->db->or_like("uop.campaign_id",$filter['search'],"both");
        }
        
        
        if (isset($filter['campaign_id']) && $filter['campaign_id'] != '') {
            $this->db->where("campaign_id", $filter['campaign_id']);
        }
        if (isset($filter['goal_id'])) {
            $this->db->where("goal_id", $filter['goal_id']);
        }
        
        if (isset($filter['limit']) && $filter['limit'] != '') {
            $filter['limit'] = ($filter['limit'] - 1) * 20;
            $this->db->limit(20, (int) $filter['limit']);
        } else {
//            $this->db->limit(10, 0);
        }
        
        
        $this->db->order_by("goal_id", "ASC");
        return $this->db->get()->result_array();
        
        
    }

}
