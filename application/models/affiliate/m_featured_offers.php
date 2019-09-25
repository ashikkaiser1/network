<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_featured_offers
 *
 * @author NexGen
 */
class m_featured_offers extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function getFeaturedOffers($filters = array()) {
          
        $this->db->select("c.*,p.image,c.status as c_status,u.uid");
        $this->db->from("campaign c");
        $this->db->join("users u", "u.uid = c.advertiser_id");
        $this->db->join("campaign_to_post ctp", "ctp.campaign_id = c.campaign_id");
//        campaign_to_post
        $this->db->join("posts p", "p.post_id = ctp.post_id");

        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '') {
            $this->db->where("c.campaign_id", $filters['campaign_id']);
            return $this->db->get()->row_array();
        }

        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db->where("u.uid", $filters['uid']);
        }
        if (isset($filters['status']) && $filters['status'] != '') {
            $this->db->where("c.status", $filters['status']);
        }

        if (isset($filters['Featured']) && $filters['Featured'] != '') {
            $this->db->where("c.featured", 1);
        }

        if (isset($filters['Formated']) && $filters['Formated'] != '') {

            $campaigns = $this->db->get()->result_array();
            $list = array();
            $list[0] = "Not Now";
            if (!empty($campaigns)) {
                foreach ($campaigns as $camp) {
                    $list[$camp['campaign_id']] = $camp['campaign_name'];
                }
            }

            return $list;
        }

        return $this->db->get()->result_array();
    }

}
