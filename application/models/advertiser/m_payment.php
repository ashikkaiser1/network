<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_payment
 *
 * @author kuldeep
 */
class m_payment extends CI_Model {
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function deposit_payment($payments = array()) {
        
        $this->db->insert("payment_ledger",$payments);
        return $this->db->insert_id();
    }
    
    public function my_paymenthistory($filters=  array()) {
        
        $this->db->select("*")->from("payment_ledger");
        $this->db->where("uid",$filters['uid']);
        $this->db->order_by("pay_id","DESC");
        return $this->db->get()->result_array();
    }
    
    public function getUserCurrentBalance($uid=0) {
        
        $this->db->select("*")->from("users_balance");
        $this->db->where("uid",$uid);
        return  $this->db->get()->row_array();
        
        
    }
}
