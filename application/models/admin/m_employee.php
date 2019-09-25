<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_employee
 *
 * @author NexGen
 */
class m_employee extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function UpdateEmployee($user = array(), $uid = 0) {
        $this->db->where("uid", $uid);
        $this->db->update("users", $user);
        return $this->db->affected_rows();
    }

    public function getEmployee($filters = array()) {
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
        if (UTID != 1) {
            //when the user type id is admin (1) then it will show all users to admin
            //when UTID is not 1 then it means it is for other user type
            
            
            $this->db->where("u.manager", UID);
        }




        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db->where("u.uid", $filters['uid']);
            $users = $this->db->get()->row_array();
            return $users;
        }

        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db->limit(10, (int) $filters['limit']);
        } else {
            // $this->db->limit(10, 0);
        }

        if (isset($filters['listFormated']) && $filters['listFormated'] != '') {
            $list = array();
            $this->db->order_by("name", "ASC");
            $users = $this->db->get()->result_array();

//            $list[''] = "All";
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

    public function CreateEmployee($user) {

        $this->db->insert("users", $user);
        return $this->db->insert_id();
    }
    
    public function set_employee_permission($batch = array(),$uid=0) {
        
        $this->delete_permission($uid);
        
        return $this->db->insert_batch("usr_permissions",$batch);
        
    }
    public function delete_permission($uid=0) {
        
        $this->db->where("uid",$uid);
        return $this->db->delete("usr_permissions");
    }

 


}
