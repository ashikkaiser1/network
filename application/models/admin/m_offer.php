<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_Campaign
 *
 * @author NexGen
 */
class m_offer extends CI_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function CreateCampaign($Campaign = array()) {
        $this->db->insert("campaign", $Campaign);
        return $this->db->insert_id();
    }

    public function UpdateCampaign($Campaign = array(), $campaign_id = 0) {
        $this->db->where("campaign_id", $campaign_id);
        $this->db->update("campaign", $Campaign);
        return $this->db->affected_rows();
    }

    public function deleteCampaign($campaign_id = 0) {
        $this->db->where("campaign_id", $campaign_id);
        $this->db->delete("campaign");

        return $this->db->affected_rows();
    }

    public function addpostToCampaign($campaign_id = 0, $post_id = 0) {
        if ($campaign_id) {
            $this->db->insert('campaign_to_post', array("campaign_id" => $campaign_id, "post_id" => $post_id));
            //  echo $this->db->last_query();
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function updatepostTocampaign($campaign_id = 0, $post_id = 0) {
        if ($campaign_id) {
            $this->db->where("post_id", $post_id);
            $this->db->update('campaign_to_post', array("campaign_id" => $campaign_id, "post_id" => $post_id));
            //  echo $this->db->last_query();
            return $this->db->affected_rows();
        }
        return FALSE;
    }

    public function getCampaign($filters = array()) {

        $this->db->select("c.*,c.status as c_status,payt_pot.name as payOutTypeName ,paytr.name as RevenueTypeName");
        $this->db->from("campaign c");
        $this->db->join("pay_type payt_pot ", "c.payout_type = payt_pot.pay_type_id ", "LEFT");
        $this->db->join("pay_type paytr", "c.revenue_type=paytr.pay_type_id ", "LEFT");
//        $this->db->join("users u", "u.uid = c.advertiser_id","LEFT");

        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '' && !is_array($filters['campaign_id'])) {
            $this->db->where("c.campaign_id", $filters['campaign_id']);
            return $this->db->get()->row_array();
        }
        
        if (isset($filters['campaign_id']) && is_array($filters['campaign_id'])) {
            $this->db->where_in("c.campaign_id", $filters['campaign_id']);
            
        }

        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db->where("u.uid", $filters['uid']);
        }
        if (isset($filters['status']) && $filters['status'] != '') {
            $this->db->where("c.status", $filters['status']);
        }


        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db->limit(10, (int) $filters['limit']);
        } else {
            if(isset($filters['all']) && $filters['all'] !='')
            {
                //all
            }
            else
            {
                 $this->db->limit(10, 0);
            }
           
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

    public function get_post_camp($filters = array()) {


        $this->db->select("p.*,ctp.campaign_id");
        $this->db->from("posts p");
        if (isset($filters['getPostNonCampaign']) && $filters['getPostNonCampaign'] != '') {
            $this->db->join("campaign_to_post ctp", "ctp.post_id != p.post_id");

            $this->db->where("p.post_id not in (SELECT post_id from campaign_to_post)", NULL, FALSE);
        }
        
        if (isset($filters['web_id']) && $filters['web_id'] != '') {
            $this->db->where("p.web_id",$filters['web_id']);
        }
         if (isset($filters['title']) && $filters['title'] != '') {
            $this->db->like("p.title",$filters['title'],"both");
        }
        
          if (isset($filters['category_id']) && $filters['category_id'] != '') {
              $this->db->join("category_to_post ctpo","ctpo.post_id=p.post_id");
            $this->db->where("ctpo.category_id",$filters['category_id']);
        }
        
        
        
        
//        $this->db->join("campaign c", "c.campaign_id = ctp.campaign_id", "LEFT");
//        $this->db->join("users u", "u.uid = c.advertiser_id", "LEFT");

        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '') {
            $this->db->join("campaign_to_post ctp", "ctp.post_id = p.post_id");
            $this->db->where("ctp.campaign_id = {$filters['campaign_id']} ", NULL, FALSE);
            //return $this->db->get()->row_array();
        }
        $this->db->order_by("p.post_id", "DESC");

        $this->db->group_by("p.post_id");


//        
        $post = $this->db->get()->result_array();


        //  echo $this->db->last_query();

        return $post;
    }

    public function delPostFromCamp($filters = array()) {

        $this->db->where($filters);
        $this->db->delete("campaign_to_post");
        return $this->db->affected_rows();
    }

}
