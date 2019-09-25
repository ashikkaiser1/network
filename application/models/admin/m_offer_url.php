<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_offer_url
 *
 * @author NexGen
 */
class m_offer_url extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function getOfferUrl($filters = array()) {
        $offerUrl = array();
        $this->db->select("oh.*")->from("offer_urls oh");
        if (isset($filters['url_id']) && $filters['url_id'] != 0) {
            $this->db->where("url_id", $filters['url_id']);
            return $this->db->get()->row_array();
        }
        if (isset($filters['campaign_id']) && $filters['campaign_id'] != 0) {
            $this->db->where("campaign_id", $filters['campaign_id']);
        
        }
        $offerUrl = $this->db->get()->result_array();
        return $offerUrl;
    }

    public function CreateOfferUrl($offerUrl) {

        $this->db->insert("offer_urls", $offerUrl);
        return $this->db->insert_id();
    }

    public function UpdateOfferUrl($offerUrl = array(), $url_id = 0) {
        $this->db->where("url_id", $url_id);
        $this->db->update("offer_urls", $offerUrl);
        return $this->db->affected_rows();
    }

    public function deleteOfferUrl($url_id = 0) {
        $this->db->where("url_id", $url_id);
        $this->db->delete("offer_urls");

        return $this->db->affected_rows();
    }

    public function getOfferUrlList() {
        $offerUrl = array();
        $this->db->select("oh.*")->from("offer_urls oh");
        $this->db->where("status", 1);
        $offerUrl = $this->db->get()->result_array();

        $list = array();
        if (!empty($offerUrl)) {
            foreach ($offerUrl as $web) {

                $list[$web['url_id']] = $web['url'];
            }
        }

        return $list;
    }

}
