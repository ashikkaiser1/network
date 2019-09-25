<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_tracker
 *
 * @author NexGen
 */
class m_tracker extends CI_Model {

    //put your code here




    public function __construct() {
        parent::__construct();
    }

      public function getPost($filters = array()) {
        //notcomplete ,ctp.post_id as ctp_post_id ,ctp.campaign_id as ctp_campaign_id
        $this->db->select("p.*,cp.category_id ")->from("posts p");
        $this->db->join("category_to_post cp", "cp.post_id=p.post_id","LEFT");
        if (isset($filters['post_id']) && $filters['post_id'] != '') {
            $this->db->where("p.post_id", $filters['post_id']);
        }
        if (isset($filters['title']) && $filters['title'] != '') {
            $this->db->like("p.title", $filters['title'], "both");
        }

        if (isset($filters['web_id']) && $filters['web_id'] != '') {
            $this->db->where("p.web_id", $filters['web_id']);
        }

        if (isset($filters['category_id']) && $filters['category_id'] != '') {
            $this->db->where("cp.category_id", $filters['category_id']);
        }
        if (isset($filters['status']) && $filters['status'] != '') {
            $this->db->where("p.status", $filters['status']);
        }



        // $this->db->limit(10,0);
//        $this->db->join("campaign_to_post ctp", "ctp.campaign_id = " . $filters['campaign_id'] . " and  ctp.post_id = cp.post_id", "LEFT");
//        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '') {
//            $this->db->where("ctp.campaign_id", $filters['campaign_id']);
//        }
        $this->db->group_by("p.post_id");
        $this->db->order_by("p.AddDateTime","DESC");

        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit']-1) * 10;
            $this->db->limit(10, (int) $filters['limit']);
        } else {
            $this->db->limit(10, 0);
        }
        $post = $this->db->get()->result_array();
       // echo $this->db->last_query();
        return $post;
    }
    
    public function getLinkInfo($filter = array()) {

        $this->db->select("l.*")->from("link l");

        if (isset($filter['domain_id']) && $filter['domain_id'] != '') {
            $this->db->where("l.domain_id", $filter['domain_id']);
            // return $this->db->get()->row_array();
        }
        if (isset($filter['short_url']) && $filter['short_url'] != '') {
            $this->db->where("l.short_url", $filter['short_url']);
            return $this->db->get()->row_array();
        }

        return $this->db->get()->result_array();
    }
    
    public function pbtr($tr_data=array()) {
        //transation tracker with the type and date time
        
        $this->db->insert("transactions",$tr_data);
    }
    
    public function checkCampaing_status($link = array()) {
        
      //  $date = date("")
        $this->db->select("status")->from("campaign");
        $this->db->where("status",1);
        if(isset($link['campaign_id']) && $link['campaign_id'] !='')
        {
            $this->db->where("campaign_id",$link['campaign_id']);
        
            $list =$this->db->get()->row_array();
            if(!empty($list))
                return TRUE;
        }
        
                
                
        return  FALSE;
    }

    public function trackClick($link) {
        //insert into click_tracker// to tya
        $this->db->insert("click_tracker", $link);
        return $this->db->insert_id();
    }
    
    public function validClick($transaction_id=0) {
        $this->db->where("transaction_id",$transaction_id);
        $updateData = array();
        $updateData['valid'] =1;
        $this->db->update("click_tracker",$updateData);
        
    }

    public function create_short_url($link) {
        $this->db->insert("link", $link);
        return $this->db->insert_id();
    }

    public function allreadyExist($checkData = array()) {
        $this->db->select("*")->from("link");
        $this->db->where($checkData);
        $row = $this->db->get()->row_array();
//        echo '<pre>';
//        print_r($row);
//        echo $this->db->last_query();
        return $row;
    }

    public function checkCodeExist($code) {

        $this->db->select("short_url")->from("link");
        $this->db->where("short_url", $code);
        $row = $this->db->get()->row_array();
        if (!empty($row))
            return TRUE;

        return FALSE;
    }

}
