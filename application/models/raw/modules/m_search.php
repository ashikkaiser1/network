<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_search
 *
 * @author kuldeep
 */
class m_search extends CI_Model {
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    
     public function searchProduct($filter=array(),$store_id=1) {
        $this->db->select("*")->from("aff_products");
        if(isset($filter['category_id']))
        {
            $this->db->where(array("category_id"=>$filter['categoy_id']));
        }
        if(isset($filter['product_id']))
        {
            $this->db->where(array("aff_product_id"=>$filter['product_id']));
        }
        if(isset($filter['s']) && $filter['s'] !='')
        {
//            $s=str_replace(" ", "%", $filter['s']);
             $s=$filter['s'];
            $this->db->like("title", $s, "mid");
           // $this->db->where("MATCH (title) AGAINST ('{$s}')",NULL,FALSE);
        }
          $this->db->where("effectivePrice !=0");
          $this->db->order_by("availability","DESC"); 
        $this->db->limit(12, 0);
        
        $data=$this->db->get()->result_array();
       
  //echo $this->db->last_query();
        return $data;
        
        
    }
}
