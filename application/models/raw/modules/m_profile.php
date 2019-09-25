<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_profile
 *
 * @author Nexgen
 */
class m_profile extends CI_Model{
    
    public function get_customer_info($customer_id){
        
        $qry = $this->db->get_where('customer',array('customer_id'=>$customer_id));
        return $qry->row_array();
    }
    
    public function update_profile($formdata,$customer_id){
        
        $update_data = array('firstname'=>$formdata['firstname'],'lastname'=>$formdata['lastname'],'email'=>$formdata['email'],'telephone'=>$formdata['telephone']);
        
        $this->db->where('customer_id',$customer_id);
        
        $this->db->update('customer',$update_data);
        
        return $this->db->affected_rows();
    }
    
}
