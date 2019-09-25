<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_website
 *
 * @author NexGen
 */
class m_website extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function getWebsite($filters = array()) {
        $website = array();
        $this->db->select("w.*")->from("websites w");
        if (isset($filters['web_id']) && $filters['web_id'] != 0) {
            $this->db->where("w.web_id", $filters['web_id']);
            return $this->db->get()->row_array();
        }
        $website = $this->db->get()->result_array();
        return $website;
    }

   
    
    public function getWebsiteList() {
        $website = array();
        $this->db->select("w.*")->from("websites w");
        $this->db->where("w.status", 1);
        $website = $this->db->get()->result_array();

        $list = array();
        if (!empty($website)) {
            foreach ($website as $web) {

                $list[$web['web_id']] = $web['domain_name'];
            }
        }

        return $list;
    }

}
