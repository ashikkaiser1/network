<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_globalpostback
 *
 * @author NexGen
 */
class m_globalpostback extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function set_globalpostback($data = array()) {
        if ($this->get_globalpostback($data['uid'])) {
            return $this->update_globalpostback($data, $data['uid']);
        }
        $this->db->insert("usr_globalPostback", $data);
        return $this->db->insert_id();
    }

    public function get_globalpostback($uid = '') {

        $this->db->select("post_back")->from("usr_globalPostback");
        $this->db->where("uid", $uid);
        $list = $this->db->get()->row_array();
        if (!empty($list))
            return $list;
        return FALSE;
    }

    public function update_globalpostback($data = array(), $uid = 0) {

        $this->db->where("uid", $uid);
        $this->db->update("usr_globalPostback", $data);
        return $this->db->affected_rows();
    }

}
