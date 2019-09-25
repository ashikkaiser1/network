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

    //function to save new faq_master
    public function save_faq($faq_data) {

        $faq_data['add_date'] = date('Y-m-d H:i:s', time());
        if ($this->db->insert("faq_master", $faq_data)) {
            return TRUE;
        }
        return FALSE;
    }

    public function update_faq($faq, $faq_id) {

        $this->db->where('faq_id', $faq_id);

        $qry = $this->db->update("faq_master", $faq);
        if ($qry) {
            return TRUE;
        }
        return FALSE;
    }

     public function get_all_faqs($filters = array()) {
        $this->db->from("faq_master");
        $this->db->order_by('faq_order', 'ASC');
        $qry = $this->db->get();
        
       
        return $qry->result_array();
    }
    

    public function get_faq_by_id($faq_id) {

        $qry = $this->db->get_where("faq_master", array("faq_id" => $faq_id));
        return $qry->row_array();
    }

    public function delete_faq($faq_id) {

        $this->db->delete("faq_master", array('faq_id' => $faq_id));

        return $this->db->affected_rows();
    }

    public function faq_change_status($faq_id, $status) {
        //echo $faq_id." ".$status; die();
        $this->db->where('faq_id', (int) $faq_id);
        $this->db->update("faq_master", array('status' => $status));
        if ($this->db->affected_rows()) {
            return TRUE;
        }
        return FALSE;
    }

}
