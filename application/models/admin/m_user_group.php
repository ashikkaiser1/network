<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_user_group
 *
 * @author NexGen
 */
class m_user_group extends CI_Model {

    //put your code here 
    public function __construct() {
        parent::__construct();
    }

    public function getUserGroup($filters = array()) {

        $this->db->select("*")->from("usr_group");
        if (isset($filters['group_id']) && $filters['group_id'] != '')
        {
            $this->db->where("group_id", $filters['group_id']);
            
            return $this->db->get()->row_array(); 
        }  
        if (isset($filters['status']))
            $this->db->where("gstatus", $filters['status']);
        
//        $this->db->order_by("gname", "ASC");

        if (isset($filters['listFormated']) && $filters['listFormated'] != '') {
            $list = array();
            $this->db->order_by("gname", "ASC");
            $usergroup = $this->db->get()->result_array();

//            $list[''] = "All";
            if (!empty($usergroup)) {
                foreach ($usergroup as $usergrp) {
                    $list[$usergrp['group_id']] = $usergrp['gname'];
                }
            }

            return $list;
        }
        $usergroup = $this->db->get()->result_array();
        return $usergroup;
    }

    public function CreateGroup($group_ids = array()) {
        $this->db->insert("usr_group", $group_ids);
        return $this->db->insert_id();
    }
    
    

    public function deleteGroup($filter = array()) {

        $this->db->where("group_id", $filter['group_id']);
        $this->db->delete("usr_group");
        return $this->db->affected_rows();
    }

    public function deleteGroupMember($filter = array()) {

        if (isset($filter['uid']) && $filter['uid'] != '')
            $this->db->where("uid", $filter['uid']);

        if (isset($filter['group_id']) && $filter['group_id'] != '')
            $this->db->where("group_id", $filter['group_id']);

        $this->db->delete("usr_group_details");
        return $this->db->affected_rows();
    }

    public function UpdateGroup($group = array(), $group_id = 0) {

        $this->db->where("group_id", $group_id);
        $this->db->update("usr_group", $group);
        return $this->db->affected_rows();
    }

    public function getGroupMembers($filters = array()) {

        $this->db->select("uid")->from("usr_group_details");
        if (isset($filters['group_id']) && $filters['group_id'] != '')
            $this->db->where("group_id", $filters['group_id']);
        return $this->db->get()->result_array();
    }

    public function setUserTogroup($uid = array(), $group_id = 0) {

        $InsertBatch = array();
//        if (!empty($uid) && isset($uid)) {
            $this->db->where("group_id", $group_id);
            $this->db->delete("usr_group_details");

            foreach ($uid as $val) {
                $InsertBatch[] = array("uid" => $val, "group_id" => $group_id);
            }
            if (!empty($InsertBatch)) {
                $this->db->insert_batch("usr_group_details", $InsertBatch);
            }
//        }
    }

}
