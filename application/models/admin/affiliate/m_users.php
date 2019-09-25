<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_users
 *
 * @author NexGen
 */
class m_users extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function UpdateUser($user = array(), $uid = 0) {
        $this->db->where("uid", $uid);
        $this->db->update("users", $user);
        return $this->db->affected_rows();
    }

    public function getUsers($filters = array()) {
        $users = array();
        $this->db->select("u.*,ut.*,u.status as u_status")->from("users u");
        $this->db->join("usertype ut", "ut.UTID=u.UTID");
        if (isset($filters['UTID']) && $filters['UTID'] != '')
            $this->db->where("u.UTID", $filters['UTID']);

        if (isset($filters['username']) && $filters['username'] != '') {
            $this->db->where("u.username", $filters['username']);
        }

        if (isset($filters['aff_id']) && $filters['aff_id'] != '') {
            $this->db->where("u.aff_id", $filters['aff_id']);
        }

        if (isset($filters['status']) && $filters['status'] != '') {
            $this->db->where("u.status", $filters['status']);
        }

        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db->where("u.uid", $filters['uid']);
            $users = $this->db->get()->row_array();
            return $users;
        }
        if (isset($filters['listFormated']) && $filters['listFormated'] != '') {
            $list = array();
            $users = $this->db->get()->result_array();

            $list[''] = "All";
            if (!empty($users)) {
                foreach ($users as $user) {
                    $list[$user['uid']] = $user['name'];
                }
            }

            return $list;
        }
        $users = $this->db->get()->result_array();
        return $users;
    }
    
    

}
