<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_payment
 *
 * @author kuldeep
 */
class m_payment extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function deposit_payment($payments = array()) {

        $this->db->insert("payment_ledger", $payments);
        return $this->db->insert_id();
    }

    public function add_value_account($uid = 0, $amt = 0) {

        $this->db->query("INSERT INTO users_balance (uid,balance) VALUES ($uid,$amt)
                ON DUPLICATE KEY UPDATE balance=balance+$amt;");
    }

    public function minu_value_account($uid = 0, $amt = 0) {

        $this->db->query("INSERT INTO users_balance (uid,balance) VALUES ($uid,$amt)
                ON DUPLICATE KEY UPDATE balance=balance-$amt;");
    }

    public function updatePaymentLedger($paymentLedger = array(), $pay_id = 0) {

        $this->db->where("pay_id", $pay_id);
        $this->db->update("payment_ledger", $paymentLedger);
        return $this->db->affected_rows();
    }

    public function my_paymenthistory($filters = array()) {

        $this->db->select("pl.*,DATE_FORMAT(pl.dateTime,'%d-%m-%Y  %h:%i %p') as dateTimeFromated,u.uid,u.name", FALSE)->from("payment_ledger pl");
        $this->db->join("users u", "u.uid=pl.uid", "LEFT");
        if (isset($filters['uid'])) {
            $this->db->where("u.uid", $filters['uid']);
        }
        if (isset($filters['status']) && $filters['status'] != '') {
            $this->db->where("pl.status", $filters['status']);
        }
        if (isset($filters['UTID'])) {
            $this->db->where("u.UTID", $filters['UTID']);
        }
        if (isset($filters['username']) && $filters['username'] != '') {
            $this->db->or_like("u.username", $filters['username'], "both");
        }
        if (isset($filters['email']) && $filters['email'] != '') {
            $this->db->or_like("u.email", $filters['email'], "both");
        }

        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db->limit(10, (int) $filters['limit']);
        } else {
            // $this->db->limit(10, 0);
        }

        $this->db->order_by("pay_id", "DESC");
        return $this->db->get()->result_array();
    }

    public function getUserCurrentBalance($uid = 0) {

        $this->db->select("ub.*, SUM(ur.amt) as refereal_pay")->from("users_balance ub");
        $this->db->join("usr_referals ur", "ur.uid=ub.uid and ur.ur_status=1", "LEFT");
        $this->db->where("ub.uid", $uid);
        return $this->db->get()->row_array();
    }

    public function get_user_to_transaction($pay_id = 0) {
        //get user and current transaction information

        $this->db->select("pl.*,u.email,u.name")->from("payment_ledger pl");
        $this->db->join("users u", "u.uid=pl.uid", "LEFT");
        $this->db->where("pay_id", $pay_id);
        return $this->db->get()->row_array();
    }

}
