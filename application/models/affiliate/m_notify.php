<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of M_notify
 *
 * @author sandeep
 */
class m_notify extends CI_Model {

    //put your code here
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
    }

    //function to save new notification
    public function save_notification($notification_data) {

        $notification_data['add_date'] = date('Y-m-d H:i:s', time());
        if ($this->db->insert("notification", $notification_data)) {
            return TRUE;
        }
        return FALSE;
    }

    public function update_notification($notification, $noti_id) {

        $this->db->where('noti_id', $noti_id);

        $qry = $this->db->update("notification", $notification);
        if ($qry) {
            return TRUE;
        }
        return FALSE;
    }

     public function get_all_notifications($filters = array()) {
        $this->db->from("notification");
        $this->db->where("(noti_for={$filters['uid']} or noti_for=0)", NULL, FALSE);
        $this->db->order_by('add_date', 'DESC');
        $qry = $this->db->get();

        return $qry->result_array();
    }
    
    public function getNoNewNotifi($filters = array()) {

        $this->db->select("count(n.noti_id) as total_new_noti");
        $this->db->from("notification n");

        $this->db->where("(noti_for={$filters['uid']} or noti_for=0)", NULL, FALSE);
        $this->db->where("n.noti_id not in (SELECT noti_id from notify where uid = {$filters['uid']})");
        return $this->db->get()->row_array();
    }
    
    public function readNotification($filters = array()) {

        $query = "SELECT {$filters['uid']},noti_id from notification where (noti_for={$filters['uid']} or noti_for=0) and noti_id not in (SELECT noti_id from notify where uid = {$filters['uid']}) ";

        $insert_query = "INSERT INTO notify (uid,noti_id) ($query) ";

        $this->db->query($insert_query);
    }
    

    public function get_notification_by_id($notification_id) {

        $qry = $this->db->get_where("notification", array("noti_id" => $notification_id));
        return $qry->row_array();
    }

    public function delete_notification($notification_id) {

        $this->db->delete("notification", array('noti_id' => $notification_id));

        return $this->db->affected_rows();
    }

    public function noti_change_status($notification_id, $status) {
        //echo $notification_id." ".$status; die();
        $this->db->where('noti_id', (int) $notification_id);
        $this->db->update("notification", array('status' => $status));
        if ($this->db->affected_rows()) {
            return TRUE;
        }
        return FALSE;
    }

}
