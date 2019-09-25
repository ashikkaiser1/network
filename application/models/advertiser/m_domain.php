<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_domain
 *
 * @author NexGen
 */
class m_domain extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function getDomain($filters = array()) {
        $domain = array();
        $this->db->select("d.*")->from("domains d");
        if (isset($filters['domain_id']) && $filters['domain_id'] != 0) {
            $this->db->where("d.domain_id", $filters['domain_id']);
            return $this->db->get()->row_array();
        }
        $domain = $this->db->get()->result_array();
        return $domain;
    }

    public function getDefaultDomain() {
        $domain = array();
        $this->db->select("d.domain_id")->from("domains d");
        $this->db->where("default",1);
        $domain = $this->db->get()->row_array();
        if (!empty($domain))
            return $domain['domain_id'];
        return 9;
    }

}
