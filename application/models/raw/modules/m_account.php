<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_account
 *
 * @author Nexgen
 */
class m_account extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function new_user_account($userData) {
        $email = $this->db->select("email")->from("customer")->where(array("email" => $userData['email']))->get()->row_array();
        if (!empty($email) && isset($email['email'])) {
            return FALSE;
        }

        $this->db->insert("customer", $userData);
        return $this->db->insert_id();
    }

    public function CheckUser($userData) {

        return $this->db->select("*")->from("customer")->where($userData)->get()->row_array();
    }

    public function check_recovery_email($formdata) {
        
        
        $data = array('email' => $formdata['recovery_email']);

        
        $qry = $this->db->get_where('customer', $data);

        if ($qry->num_rows()) {

            $password = uniqid();

            $this->db->update("customer", array("password" => $password), $data);

            if ($this->db->affected_rows() > 0) {
                return $password;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

}
