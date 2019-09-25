<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descroction of m_offer_category
 *
 * @author NexGen
 */
class m_offer_category extends CI_Model {

    //put your code here

    public function Createoffer_category($offer_cat) {

        $this->db->insert("offer_category", $offer_cat);
        return $this->db->insert_id();
    }

    public function Updateoffer_category($offer_cat = array(), $offer_cat_id = 0) {
        $this->db->where("offer_cat_id", $offer_cat_id);
        $this->db->update("offer_category", $offer_cat);
        return $this->db->affected_rows();
    }

    public function deleteoffer_category($filters = array()) {
        $this->db->where("offer_cat_id", isset($filters['offer_cat_id']) ? $filters['offer_cat_id'] : 0 );
        $this->db->delete("offer_category");
        return $this->db->affected_rows();
    }

    public function getOfferCategory($filters = array()) {
        $offer_cat_id = array();
        $this->db->select("*")->from("offer_category oc");
        if (isset($filters['status']) && $filters['status'] != '') {
            $this->db->where("oc.status", $filters['status']);
        }
        
         if (isset($filters['title']) && $filters['title'] != '') {
            $this->db->like("oc.title", $filters['title']);
        }

        if (isset($filters['offer_cat_id']) && $filters['offer_cat_id'] != '') {
            $this->db->where("oc.offer_cat_id", $filters['offer_cat_id']);
            $offer_cat_id = $this->db->get()->row_array();
            return $offer_cat_id;
        }

        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db->limit(10, (int) $filters['limit']);
        } else {
            // $this->db->limit(10, 0);
        }

        if (isset($filters['listFormated']) && $filters['listFormated'] != '') {
            $list = array();
            $this->db->order_by("oc.offer_cat_id", "ASC");
            $offer_cat = $this->db->get()->result_array();

//            $list[''] = "All";
            if (!empty($offer_cat)) {
                foreach ($offer_cat as $offer_cat_id) {
                    $list[$offer_cat_id['offer_cat_id']] = $offer_cat_id['title'];
                }
            }

            return $list;
        }
        $offer_cat = $this->db->get()->result_array();
        return $offer_cat;
    }

}
