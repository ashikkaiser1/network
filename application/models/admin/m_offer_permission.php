<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_offer_permission
 *
 * @author NexGen
 */
class m_offer_permission extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function getOfferUsers($filters = array()) {

        $this->db->select("*")->from("usr_offerApproval");
        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db->where("uid", $filters['uid']);
        }

        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '') {
            $this->db->where("campaign_id", $filters['campaign_id']);
        }
        if (isset($filters['status']) && is_array($filters['status'])) {
            $this->db->where_in("status", $filters['status']);
        }
        if (isset($filters['status']) && !is_array($filters['status']))
            $this->db->where("status", $filters['status']);
        $app_off = $this->db->get()->result_array();
        return $app_off;
    }

    public function setApprovePublisher($uids = array(), $campaign_id = 0, $status = 0) {

        if (!empty($uids)) {

//            $filters = array();
//            $filters['uids'] = $uids;
//            $filters['campaign_id'] = $campaign_id;
//            $this->delete_offer_approvalData($filters);
            if (TRUE) {

                $insert_data = array();
                foreach ($uids as $uid) {
                    $insert_data[] = array("uid" => $uid,
                        "campaign_id" => $campaign_id,
                        "status" => $status);
                }

                if (!empty($insert_data)) {

//                    echo '<pre>';
//                    
//                    print_r($insert_data);
//                    



                    $this->db->insert_on_duplicate_update_batch("usr_offerApproval", $insert_data, " uora_id=LAST_INSERT_ID(uora_id), ");

                    // $this->db->insert_batch("usr_offerApproval", $insert_data);
                    //insert new data
                }
                return TRUE;
            }

            return FALSE;
        }

        return FALSE;
    }

    public function delete_offer_approvalData($filters = array()) {

        if (isset($filters['uid']) && $filters['uid'] != '' && !is_array($filters['uid'])) {
            $this->db->where("uid", $filters['uid']);
        }
        if (isset($filters['uids']) && is_array($filters['uids'])) {
            $this->db->where_in("uid", $filters['uids']);
        }

        if (isset($filters['campaign_id']) && $filters['campaign_id']) {
            $this->db->where("campaign_id", $filters['campaign_id']);
        }

        $this->db->delete("usr_offerApproval");

        return $this->db->affected_rows();
    }

}
