<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_group_payout
 *
 * @author kuldeep
 */
class m_group_payout extends CI_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function setPayoutForAffiliate($data = array(), $uids = array()) {

        $insertData = array();
        if (!empty($uids)) {
            foreach ($uids as $uid) {
                $insertData[] = array("uid" => $uid,
                    "group_id" => 0,
                    "pay_status" => 1,
                    "campaign_id" => $data['campaign_id'],
                    "payout_type" => $data['payout_type'],
                    "payout_cost" => $data['payout_cost']);
            }

            $this->db->insert_batch("pay_group", $insertData);
        }

        return TRUE;
    }

    public function setPayoutForGroup($data = array(), $groups = array()) {

        $insertData = array();
        if (!empty($groups)) {
            foreach ($groups as $group_id) {
                $insertData[] = array("uid" => 0,
                    "group_id" => $group_id,
                    "pay_status" => 1,
                    "campaign_id" => $data['campaign_id'],
                    "payout_type" => $data['payout_type'],
                    "payout_cost" => $data['payout_cost']);
            }

//            echo '<pre>';
//            print_r($insertData);

            $this->db->insert_batch("pay_group", $insertData);
        }
        return TRUE;
    }

    public function getAffiliatePayout($filters = array()) {

        $this->db->select("pg.*,ptype.*,ptype.name as payoutName,u.uid,u.UTID,u.name,u.company");
        $this->db->from("pay_group pg");
        $this->db->join("users as u", "u.uid=pg.uid", "LEFT");
        $this->db->join("pay_type as ptype", "ptype.pay_type_id=pg.payout_type", "LEFT");

        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '')
            $this->db->where("pg.campaign_id", $filters['campaign_id']);
        $this->db->where("pg.group_id", 0);

        return $this->db->get()->result_array();
    }

    public function getGroupPayout($filters = array()) {

        $this->db->select("pg.*,ptype.*,ptype.name as payoutName,ug.gname,ug.group_id");
        $this->db->from("pay_group pg");
        $this->db->join("usr_group as ug", "ug.group_id=pg.group_id", "LEFT");
        $this->db->join("pay_type as ptype", "ptype.pay_type_id=pg.payout_type", "LEFT");

        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '')
            $this->db->where("pg.campaign_id", $filters['campaign_id']);
        $this->db->where("pg.uid", 0);

        return $this->db->get()->result_array();
    }

    public function deletePayoutGroup($filters = array()) {
        if (isset($filters['pay_group_id']) && $filters['pay_group_id'] != '') {
            $this->db->where("pay_group_id", $filters['pay_group_id']);
            $this->db->delete("pay_group");

            return $this->db->affected_rows();
        }

        return FALSE;
    }

}
