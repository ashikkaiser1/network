<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_filters
 *
 * @author kuldeep
 */
class m_filters extends CI_Model {
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function getFilters($filter=array()) {
       
         $category_join = " ";
        if (isset($filter['category_id'])) {
            $category_join = "left join aff_products as afp on afp.category_id= {$filter['category_id']} and afp.aff_product_id = product_id  ";
        }
        
        
        $count_products= " (SELECT count(product_id) from oct_product_filter $category_join where filter_id=f.filter_id) as total_products ";
        
        
        $this->db->select("f.filter_id,f.name as filter_name,fg.name as filter_group_name,$count_products")->from("filters as f");
       
        $this->db->join("filters_group fg", "fg.filter_group_id=f.filter_group_id");
        if(isset($filter['category_id']))
        {
          $this->db->join("category_filter cf", "cf.filter_id=f.filter_id");
        $this->db->where(array("cf.category_id"=>$filter['category_id']));
        }
        
        $this->db->group_by("f.name");
        $this->db->order_by("fg.name","ASC");
        $this->db->limit(100); 
        
        $filters= $this->db->get()->result_array();
       // echo $this->db->last_query();
        return $filters;
        
    }
}
