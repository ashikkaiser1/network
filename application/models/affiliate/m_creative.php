<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_creative
 *
 * @author NexGen
 */
class m_creative extends CI_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function setCreative($creative = array()) {
        $this->db->insert("creatives", $creative);
        return $this->db->insert_id();
    }

    public function getCreative($filters = array()) {

        $this->db->select("cr.*,off_cr.campaign_id")->from("creatives cr");
        if (isset($filters['creative_name']) && $filters['creative_name'] != '') {
            $this->db->like("creative_name", $filters['creative_name'], "both");
        }
        $this->db->join("offer_creative off_cr", "off_cr.creative_id =cr.creative_id", "LEFT");

        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '') {
            $this->db->where("off_cr.campaign_id", $filters['campaign_id']);
        }

        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db->limit(10, (int) $filters['limit']);
        } else {
            // $this->db->limit(10, 0);
        }

        $this->db->order_by("cr.DateTime", "DESC");
        $this->db->group_by("cr.creative_id");
        $result = $this->db->get()->result_array();
        //echo $this->db->last_query();
        return $result;
    }

    public function getOfferCreative($filters = array()) {

        $this->db->select("cr.*,off_cr.*")->from("offer_creative off_cr ");
        if (isset($filters['creative_name']) && $filters['creative_name'] != '') {
            $this->db->like("creative_name", $filters['creative_name'], "both");
        }
        $this->db->join("creatives cr", "off_cr.creative_id = cr.creative_id", "RIGHT");

        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '') {
            $this->db->where("off_cr.campaign_id", $filters['campaign_id']);
        }

        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db->limit(10, (int) $filters['limit']);
        } else {
            // $this->db->limit(10, 0);
        }

        $this->db->order_by("cr.DateTime", "DESC");
        $this->db->group_by("off_cr.creative_id");
        $result = $this->db->get()->result_array();
        //echo $this->db->last_query();
        return $result;
    }

    public function setCreativeToOffer($camapign_ids = array(), $creative_id = 0, $uid = 0) {

        $this->deleteOffer_creative(array("creative_id" => $creative_id));

        if (!empty($camapign_ids)) {
            $OfferCreative = array();
            foreach ($camapign_ids as $campaign_id) {

                $OfferCreative[] = array("campaign_id" => $campaign_id,
                    "uid" => $uid,
                    "creative_id" => $creative_id,
                    "status" => 1);
            }

            if (!empty($OfferCreative)) {
                $this->db->insert_batch("offer_creative", $OfferCreative);
            }
        }
    }

    public function deleteOffer_creative($filters = array()) {

        $this->db->where("creative_id", $filters['creative_id']);
        $this->db->delete("offer_creative");
    }

    public function getCreativeOffers($filters = array()) {

        $this->db->select("*")->from("offer_creative");
        if (isset($filters['creative_id']) && $filters['creative_id'] != '') {
            $this->db->where("creative_id", $filters['creative_id']);
        }

        return $this->db->get()->result_array();
    }

    public function deleteCreative($creative_id = 0, $uid = 0) {
        $this->db->where("creative_id", $creative_id);
        if (!$uid) {
            $this->db->where("uid", $uid);
        }
        $this->db->delete("creatives");

        return $this->db->affected_rows();
    }

}
