<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_ip_pool
 *
 * @author NexGen
 */
class m_ip_pool extends CI_Model {

    //put your code here

    public function CreateIp_pool($ip_pool) {

        $this->db->insert("ip_pool", $ip_pool);
        return $this->db->insert_id();
    }

    public function UpdateIp_pool($ip_pool = array(), $ip_id = 0) {
        $this->db->where("ip_id", $ip_id);
        $this->db->update("ip_pool", $ip_pool);
        return $this->db->affected_rows();
    }

    public function deleteIp($filters = array()) {
        $this->db->where("ip_id", isset($filters['ip_id']) ? $filters['ip_id'] : 0 );
        $this->db->delete("ip_pool");
        return $this->db->affected_rows();
    }

    public function getIPs($filters = array()) {
        $ip_pool = array();
        $this->db->select("*")->from("ip_pool ip");
        if (isset($filters['status']) && $filters['status'] != '') {
            $this->db->where("ip.status", $filters['status']);
        }

        if (isset($filters['ip_id']) && $filters['ip_id'] != '') {
            $this->db->where("ip.ip_id", $filters['ip_id']);
            $ip_pool = $this->db->get()->row_array();
            return $ip_pool;
        }

        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db->limit(10, (int) $filters['limit']);
        } else {
            // $this->db->limit(10, 0);
        }

        if (isset($filters['listFormated']) && $filters['listFormated'] != '') {
            $list = array();
            $this->db->order_by("ip.ip_id", "ASC");
            $ip_pool = $this->db->get()->result_array();

//            $list[''] = "All";
            if (!empty($ip_pool)) {
                foreach ($ip_pool as $ip_pool) {
                    $list[$ip_pool['ip_id']] = $ip_pool['ip_adderss'];
                }
            }

            return $list;
        }
        $ip_pool = $this->db->get()->result_array();
        return $ip_pool;
    }

}
