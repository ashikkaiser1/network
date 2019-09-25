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
        if (is_array($uid)) {
            $this->db->where_in("uid", $uid);
        } else {
            $this->db->where("uid", $uid);
        }

        $this->db->update("users", $user);
        return $this->db->affected_rows();
    }

    public function getUserCount($filters = array()) {
        $this->db->select("count(u.uid) as totalUser")->from("users u");
        if (isset($filters['UTID']) && $filters['UTID'] != '')
            $this->db->where("u.UTID", $filters['UTID']);
        if (isset($filters['status']) && $filters['status'] != '') {
            $this->db->where("u.status", $filters['status']);
        }

        $users = $this->db->get()->row_array();
        return $users;
    }

    public function getUsers($filters = array()) {
        $users = array();
        $this->db->select("u.*,ut.*,u.status as u_status")->from("users u");
        $this->db->join("usertype ut", "ut.UTID=u.UTID");
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
        if (defined("UTID") &&  @UTID != 1) {
            //when the user type id is admin (1) then it will show all users to admin
            //when UTID is not 1 then it means it is for other user type
           if (isset($filters['manager']) && $filters['manager'] != '')
           {
            //this is code for aff_manager page where affiliate get their manager/   
           }else
           {
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

        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db->limit(10, (int) $filters['limit']);
        } else {
            // $this->db->limit(10, 0);
        }

        $this->db->order_by("u.uid", "DESC");

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

    public function CreateUser($user) {

        $this->db->insert("users", $user);
        return $this->db->insert_id();
    }

    public function getUsrOfferCountry($uid = 0) {
        $this->db->select("*")->from("usr_offerCountry");
        $this->db->where("uid", $uid);
        $list = $this->db->get()->result_array();

        $options = array();
        if (!empty($list)) {
            foreach ($list as $val) {

                $options[] = $val['country_id'];
            }
        }

        return $options;
    }

    public function getUsrOfferInterest($uid = 0) {

        $this->db->select("*")->from("usr_offerInterest");
        $this->db->where("uid", $uid);
        $list = $this->db->get()->result_array();

        $options = array();
        if (!empty($list)) {
            foreach ($list as $val) {

                $options[] = $val['offer_cat_id'];
            }
        }

        return $options;
    }

    public function getUsrofferType($uid = 0) {

        $this->db->select("*")->from("usr_offerType");
        $this->db->where("uid", $uid);
        $list = $this->db->get()->result_array();

        $options = array();
        if (!empty($list)) {
            foreach ($list as $val) {
                $options[$val['offer_type_id']] = $val['offer_type_id'];
            }
        }

        return $options;
    }

    public function getUsrOfferVertical($uid = 0) {

        $this->db->select("*")->from("usr_offerVertical");
        $this->db->where("uid", $uid);
        $list = $this->db->get()->result_array();

        $options = array();
        if (!empty($list)) {
            foreach ($list as $val) {

                $options[] = $val['offer_cat_id'];
            }
        }

        return $options;
    }

    public function getUsrTraffictype($uid = 0) {

        $this->db->select("*")->from("usr_trafficType");
        $this->db->where("uid", $uid);
        $list = $this->db->get()->result_array();

        $options = array();
        if (!empty($list)) {
            foreach ($list as $val) {
                $options[$val['traffic_type']] = $val['traffic_type'];
            }
        }

        return $options;
    }

    public function setUsrOfferCountry($data = array(), $uid = 0) {
        $InsertBatch = array();
        if (!empty($data) && isset($data)) {
            $this->db->where("uid", $uid);
            $this->db->delete("usr_offerCountry");

            foreach ($data as $val) {

                $InsertBatch[] = array("uid" => $uid, "country_id" => $val);
            }

            if (!empty($InsertBatch)) {
                $this->db->insert_batch("usr_offerCountry", $InsertBatch);
            }
        }
    }

    public function setUsrOtherNetwork($data = array(), $uid = 0) {
        $data['uid'] = $uid;
        $this->db->insert("usr_otherNetwork", $data);
        return $this->db->insert_id();
    }

    public function updateUsrOtherNetwork($data = array(), $uid = 0) {
        $this->db->where("uid", $uid);
        $this->db->update("usr_otherNetwork", $data);
    }

    public function getUsrOtherNetwork($uid = 0) {

        $this->db->select("*")->from("usr_otherNetwork")->where("uid", $uid);
        return $this->db->get()->row_array();
    }

    public function setUsrOfferInterest($data = array(), $uid = 0) {

        $InsertBatch = array();
        if (!empty($data) && isset($data)) {

            $this->db->where("uid", $uid);
            $this->db->delete("usr_offerInterest");

            foreach ($data as $val) {

                $InsertBatch[] = array("uid" => $uid, "offer_cat_id" => $val);
            }

            if (!empty($InsertBatch)) {
                $this->db->insert_batch("usr_offerInterest", $InsertBatch);
            }
        }
    }

    public function setUsrofferType($data = array(), $uid = 0) {

        $InsertBatch = array();
        if (!empty($data) && isset($data)) {
            $this->db->where("uid", $uid);
            $this->db->delete("usr_offerType");
            foreach ($data as $val) {

                $InsertBatch[] = array("uid" => $uid, "offer_type_id" => $val);
            }

            if (!empty($InsertBatch)) {
                $this->db->insert_batch("usr_offerType", $InsertBatch);
            }
        }
    }

    public function setUsrOfferVertical($data = array(), $uid = 0) {

        $InsertBatch = array();
        if (!empty($data) && isset($data)) {
            $this->db->where("uid", $uid);
            $this->db->delete("usr_offerVertical");

            foreach ($data as $val) {

                $InsertBatch[] = array("uid" => $uid, "offer_cat_id" => $val);
            }

            if (!empty($InsertBatch)) {
                $this->db->insert_batch("usr_offerVertical", $InsertBatch);
            }
        }
    }

    public function setUsrTraffictype($data = array(), $uid = 0) {

        $InsertBatch = array();
        if (!empty($data) && isset($data)) {
            $this->db->where("uid", $uid);
            $this->db->delete("usr_trafficType");
            foreach ($data as $val) {

                $InsertBatch[] = array("uid" => $uid, "traffic_type" => $val);
            }

            if (!empty($InsertBatch)) {
                $this->db->insert_batch("usr_trafficType", $InsertBatch);
            }
        }
    }

}
