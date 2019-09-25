<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_notify
 *
 * @author sandeep
 */
class m_faq extends CI_Model {

    //put your code here
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
    }

     public function get_all_faqs($filters = array()) {
        $this->db->from("faq_master");
        if(isset($filters['faq_status']) && $filters['faq_status']){
            $this->db->where("faq_status",$filters['faq_status']);
        }
        $this->db->order_by('faq_order', 'ASC');
        $qry = $this->db->get();
        
       
        return $qry->result_array();
    }
    

}
