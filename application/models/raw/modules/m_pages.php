<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_pages
 *
 * @author Naughty Dog
 */
class m_pages extends CI_Model {

    public function get_footer_menus($store_id) {

        $this->db->select('page_id,menuTitle')->from('pages');
        $this->db->where(array('store_id' => $store_id, 'status' => 1));
        $this->db->order_by('sort', 'asc');

        $qry = $this->db->get();

        return $qry->result_array();
    }

    public function get_page_content($store_id, $page_id) {
        
        $this->db->select('pageContent,module_name')->from('pages');
        $this->db->where(array('store_id' => $store_id, 'page_id' => $page_id));
        
        $qry = $this->db->get();
        return $qry->row_array();
    }

}
