<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_post
 *
 * @author NexGen
 */
class m_post extends CI_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function CreatePost($post = array()) {

        $this->db->insert("posts", $post);
        return $this->db->insert_id();
    }

    public function UpdatePost($post = array(), $post_id = 0) {
        $this->db->where("post_id", $post_id);
        $this->db->update("posts", $post);
        // echo $this->db->last_query();
        return $this->db->affected_rows();
    }

    public function deletepost($post_id = 0) {
        $this->db->where("post_id", $post_id);
        $this->db->delete("posts");
        // echo $this->db->last_query();
        return $this->db->affected_rows();
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

    public function getPostForUpdate($post_id = 0) {

        $this->db->select("p.*,ctp.campaign_id")->from("posts p");
        $this->db->where("p.post_id", $post_id);
        $this->db->join("campaign_to_post as ctp", "ctp.post_id = p.post_id", "LEFT");
        $post = $this->db->get()->row_array();
        if (!empty($post)) {
            $post['category_id'] = $this->get_post_category($post_id);
        }

        return $post;
    }

    public function get_post_category($post_id = 0) {

        $this->db->select("ctp.category_id")->from("category_to_post ctp");
        $this->db->where("ctp.post_id", $post_id);
        $category_ids = $this->db->get()->result_array();
        $category_id = array();
        if (!empty($category_ids)) {
            foreach ($category_ids as $cat) {
                $category_id[] = $cat['category_id'];
            }
        }
        return $category_id;
    }

}
