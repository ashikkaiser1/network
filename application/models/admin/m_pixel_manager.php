<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_pixel_manager
 *
 * @author NexGen
 */
class m_pixel_manager extends CI_Model {

    //put your code here
    private $db_reader;

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->db_reader = $this->load->database("db_reader", TRUE);
    }

    public function getPixels($filters = array()) {

        $this->db_reader->select("l.link_id,u.uid,u.company,u.name as UserName,cmp.campaign_id,cmp.campaign_name,l.post_back,l.p_type,l.post_id");
        $this->db_reader->from("link as l");
        $this->db_reader->join("users as u", "u.uid=l.uid", "LEFT");
        $this->db_reader->join("campaign as cmp", "cmp.campaign_id=l.campaign_id", "LEFT");
        $this->db_reader->order_by("l.link_id", "DESC");

        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db_reader->where("l.uid", $filters['uid']);
        }
         if (isset($filters['company']) && $filters['company'] != '') {
              $this->db_reader->or_like("u.company", $filters['company']);
         }
         
         if (isset($filters['campaign_id']) && $filters['campaign_id'] != '') {
              $this->db_reader->or_like("cmp.campaign_id", $filters['campaign_id']);
         }
         
         if (isset($filters['campaign_name']) && $filters['campaign_name'] != '') {
              $this->db_reader->or_like("cmp.campaign_name", $filters['campaign_name']);
         }
         
         if (isset($filters['post_back']) && $filters['post_back'] != '') {
              $this->db_reader->or_like("l.post_back", $filters['post_back']);
         }

        if (isset($filters['post_id']) && $filters['post_id'] != '') {
            $this->db_reader->where("l.post_id", $filters['post_id']);
        }
        
        $this->db_reader->where("l.p_status",1);

        $this->db_reader->group_by("l.link_id");
        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db_reader->limit(10, (int) $filters['limit']);
        } else {
//            $this->db->limit(10, 0);
        }

        return $this->db_reader->get()->result_array();
    }
    
    public function delete_postback($filters = array(),$update = array()) {
        
        if(isset($filters['link_id']) && is_array($filters['link_id']) && !empty($filters['link_id']))
        {
            $this->db->where_in("link_id",$filters['link_id']);
            $this->db->update("link",$update);
        }
        
        
        
    }

}
