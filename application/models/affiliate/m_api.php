<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_api
 *
 * @author NexGen
 */
class m_api extends CI_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function checkCodeExist($code) {
        $this->db->select("token")->from("usr_token");
        $this->db->where("token", $code);
        $row = $this->db->get()->row_array();
        if (!empty($row))
            return TRUE;

        return FALSE;
    }

    public function validateToken($code) {
        $this->db->select("token")->from("usr_token");
        $this->db->where("token", $code);
        $this->db->where("status", 1);
        $row = $this->db->get()->row_array();
        if (!empty($row))
            return TRUE;

        return FALSE;
    }

    public function getToken($UID = 0) {
        $this->db->select("token")->from("usr_token");
        $this->db->where("uid", $UID);
        $row = $this->db->get()->row_array();
        if (!empty($row))
            return $row['token'];

        return 'No Token Generated.';
    }

    public function getTokenInfo($UID = 0) {
        $this->db->select("*")->from("usr_token");
        $this->db->where("uid", $UID);
        $row = $this->db->get()->row_array();
        return $row;
    }

    public function setToken($usrToken = array()) {
        if (!$this->getUserToken($usrToken['uid'])) {
            $this->db->insert("usr_token", $usrToken);
            return $this->db->insert_id();
        } else {
            $this->db->where("uid", $usrToken['uid']);
            $this->db->update("usr_token", $usrToken);
            return $this->db->affected_rows();
        }
    }

    public function getUserToken($uid = 0) {
        $this->db->select("token")->from("usr_token");
        $this->db->where("uid", $uid);
        $row = $this->db->get()->row_array();
        if (!empty($row))
            return $row['token'];

        return FALSE;
    }

}
