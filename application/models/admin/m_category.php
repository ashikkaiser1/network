<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_category
 *
 * @author NexGen
 */
class m_category extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function CreateCategory($category) {

        $this->db->insert("category", $category);
        return $this->db->insert_id();
    }

    public function category_sort_and_update($category = array(), $category_id = 0) {
        $this->db->where("category_id", $category_id);
        $this->db->update("category", $category);

        return $this->db->affected_rows();
    }

    public function deleteCategory($category_id = 0) {
        $this->db->where("category_id", $category_id);
        $this->db->delete("category");

        return $this->db->affected_rows();
    }

    public function getCategory($parent_id = 0, $filters = array()) {
        $category = array();
        $this->db->select("c.*")->from("category c");
        $this->db->where("c.parent_id", $parent_id);


        if (isset($filters['category_id']) && $filters['category_id'] != '')
            $this->db->where("c.category_id", $filters['category_id']);

        $this->db->order_by("c.sort","ASC");

        $category = $this->db->get()->result_array();
        if (isset($filters['allchild']) && $filters['allchild'] != '') {
            if (!empty($category)) {
                foreach ($category as $key => $cat) {

                    $cat['child'] = $this->getCategory($cat["category_id"], $filters);
                    $category[$key] = $cat;
                }
            }
        }


        return $category;
    }

    public function getCategoryList() {
        $category = array();
        $this->db->select("c.*")->from("category c");
        $this->db->where("c.status", 1);
        $category = $this->db->get()->result_array();

        $list = array();
        if (!empty($category)) {
            foreach ($category as $cat) {

                $list[$cat['category_id']] = $cat['category_name'];
            }
        }

        return $list;
    }

    public function category_to_post($category_ids, $post_id) {
        
        if(!empty($category_ids))
        {
            foreach ($category_ids as $keys => $category_id) {
                
                 $this->db->insert("category_to_post", array("category_id" => $category_id, "post_id" => $post_id));
            }
           
        }
        
        return $this->db->insert_id();
    }
    
    public function category_to_post_update($category_ids, $post_id=0) {
        
        $this->db->where("post_id",$post_id);
        $this->db->delete("category_to_post");
//        if($this->db->affected_rows())
//        {
            return $this->category_to_post($category_ids, $post_id);
//        }
        
        return FALSE;
    }

}
