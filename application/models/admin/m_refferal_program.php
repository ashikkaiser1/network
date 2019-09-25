<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_refferal_program
 *
 * @author kuldeep
 */
class m_refferal_program extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function getUsers($filters = array()) {
        $users = array();
        $count = ",COUNT(ur.ref_uid) as total_referals";
        if (isset($filters['ref_by']) && $filters['ref_by'] != '') {
            $count = '';
        }
        
        $this->db->select("u.uid,u.name,u.email,u.contact,ut.*,u.status as u_status $count")->from("users u");
        $this->db->join("usertype ut", "ut.UTID=u.UTID");
        if (isset($filters['ref_by']) && $filters['ref_by'] != '') {
            $this->db->join("usr_referals ur", "ur.ref_uid=u.uid", "LEFT");
        }else
        {
            $this->db->join("usr_referals ur", "ur.uid=u.uid", "LEFT");
        }
        
        if (isset($filters['UTID']) && $filters['UTID'] != '')
            $this->db->where("u.UTID", $filters['UTID']);

        if (isset($filters['username']) && $filters['username'] != '') {
            $this->db->or_like("u.username", $filters['username'], "both");
        }
        if (isset($filters['email']) && $filters['email'] != '') {
            $this->db->or_like("u.email", $filters['email'], "both");
        }
        if (isset($filters['company']) && $filters['company'] != '') {
            $this->db->or_like("u.company", $filters['company'], "both");
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
            if (isset($filters['manager']) && $filters['manager'] != '') {
                //this is code for aff_manager page where affiliate get their manager/   
            } else {
                $this->db->where("u.manager", UID);
            }
        }




        if (isset($filters['uid']) && $filters['uid'] != '' && !is_array($filters['uid'])) {
            $this->db->where("u.uid", $filters['uid']);
            $users = $this->db->get()->row_array();
            return $users;
        }

        if (isset($filters['uid']) && is_array($filters['uid'])) {

            $this->db->where_in("u.uid", $filters['uid']);
        }

        if (isset($filters['in_uid']) && is_array($filters['in_uid']) && !empty($filters['in_uid'])) {
            $this->db->or_where_in("u.uid", $filters['in_uid']);
        }

        if (isset($filters['in_uids']) && is_array($filters['in_uids']) && !empty($filters['in_uids'])) {
            //updated or addded for offer permission modeule 

            $this->db->where_in("u.uid", $filters['in_uids']);
        }


        if (isset($filters['ex_uid']) && is_array($filters['ex_uid']) && !empty($filters['ex_uid'])) {

            //ex clude the uids 
            $this->db->where_not_in("u.uid", $filters['ex_uid']);
        }

        if (isset($filters['ref_by']) && $filters['ref_by'] != '') {
            $this->db->where("ur.uid", $filters['ref_by']);
        }

        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db->limit(10, (int) $filters['limit']);
        } else {
            // $this->db->limit(10, 0);
        }
        if (!isset($filters['ref_by'])) {
            $this->db->group_by("u.uid");
            $this->db->order_by("total_referals", "DESC");
        }


        if (isset($filters['listFormated']) && $filters['listFormated'] != '') {
            $list = array();
            $this->db->order_by("name", "ASC");
            $users = $this->db->get()->result_array();

//            $list[''] = "All";
            if (!empty($users)) {
                foreach ($users as $user) {
                    $list[$user['uid']] = $user['company'] . " (" . $user['name'] . ")";
                }
            }

            return $list;
        }
        $users = $this->db->get()->result_array();
        return $users;
    }

}
