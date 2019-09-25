<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_seo
 *
 * @author kuldeep
 */
class m_seo extends CI_Model {
    //put your code here
    
    public function getCategoryMeta($category_id=0) {
        
        $this->db->select("meta_title,meta_description,meta_keyword")->from("category")->where(array("category_id"=>$category_id));
        return $this->db->get()->row_array();
        
        
        
    }
}
