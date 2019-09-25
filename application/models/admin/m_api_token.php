<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_api_token
 *
 * @author kuldeep
 */
class m_api_token extends CI_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function getTokenRequest($filters = array()) {

        $this->db->select("ut.*,u.company,u.name");
        $this->db->from("usr_token ut");
        $this->db->join("users u", "u.uid =ut.uid", "LEFT");
        if (isset($filters['status']) && $filters['status'] != '') {
            $this->db->where("ut.status", $filters['status']);
        }
        if (isset($filters['company']) && $filters['company'] != '') {
            $this->db->like("u.company", $filters['company']);
        }

        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db->limit(10, (int) $filters['limit']);
        } else {
            // $this->db->limit(10, 0);
        }
        return $this->db->get()->result_array();
    }

    public function ChangeStatus($filters = array(), $updateData = array()) {
        if (isset($filters['usr_token_id']) && $filters['usr_token_id'] != '') {
            $this->db->where("usr_token_id", $filters['usr_token_id']);
            $this->db->update("usr_token", $updateData);
            return $this->db->affected_rows();
        }

        return FALSE;
    }

}
