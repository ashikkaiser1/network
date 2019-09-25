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


    public function getCategory($parent_id = 0, $filters = array()) {
        $category = array();
        
     
        $this->db->select("c.*")->from("category c");
        $this->db->where("c.parent_id", $parent_id);


        if (isset($filters['category_id']) && $filters['category_id'] != '')
            $this->db->where("c.category_id", $filters['category_id']);
        
        if (isset($filters['cat_type']))
             $this->db->where("c.cat_type", $filters['cat_type']);
        

        $this->db->where("c.status", 1);
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
//echo $this->db->last_query();

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

   

}
