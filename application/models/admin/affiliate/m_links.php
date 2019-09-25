<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_links
 *
 * @author NexGen
 */
class m_links extends CI_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function getLinks($filters = array()) {
        $link = array();
        $this->db->select("p.title,lk.gen_link,lk.post_back,lk.link_id,lk.uid")->from("link lk");
        $this->db->join("posts p", "p.post_id = lk.post_id");

        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db->where('lk.uid', $filters['uid']);
        }

        if (isset($filters['post_ids']) && $filters['post_ids'] != '') {
            $this->db->where_in('lk.post_id', $filters['post_ids']);
        }

        if (isset($filters['short_url']) && $filters['short_url'] != '') {
            $this->db->where_in('lk.short_url', $filters['short_url']);
            return $this->db->get()->row_array();
        }



        $link = $this->db->get()->result_array();

        //  echo $this->db->last_query();
        return $link;
    }

    public function update_link($link = array(), $link_id = 0) {

        $this->db->where("link_id", $link_id);
        $this->db->update("link", $link);

        return $this->db->affected_rows();
    }

    public function setExtraPramLink($LinkExtra = array(), $link_id = 0) {
        $this->deleteExtraPram($link_id);
        $this->db->insert_batch("link_extra", $LinkExtra);
    }

    public function deleteExtraPram($link_id = 0) {
        $this->db->where("link_id", $link_id);
        $this->db->delete("link_extra");
    }

    //event callback
    public function setLinkEvents($LinkEvent = array(), $link_id = 0) {
        $this->deleteLinkEvent($link_id);
        $this->db->insert_batch("link_event_post", $LinkEvent);
    }

    public function deleteLinkEvent($link_id = 0) {
        $this->db->where("link_id", $link_id);
        $this->db->delete("link_event_post");
    }

    //end of event call back

    public function getLinkExtraParam($filter = array()) {

        $this->db->select("*")->from("link_extra");
        if (isset($filter['link_id']) && $filter['link_id'] != '') {
            $this->db->where("link_id", $filter['link_id']);
            $this->db->order_by("link_extra_id", "ASC");
            return $this->db->get()->result_array();
        }

        return array();
    }

    public function getLinkEvents($filter = array()) {

//        echo '<pre>';
//        print_r($filter);
        $conditon = '';
        if (isset($filter['link_id']) && $filter['link_id'] != '') {
            $conditon = " and le.link_id = {$filter['link_id']}";
        }

        $this->db->select("og.name as eventName,og.offer_goal_id,og.offer_goal_id,le.callback,le.p_type");
        $this->db->from("offer_goal og");
        $this->db->join("link_event_post le", "le.offer_goal_id=og.offer_goal_id $conditon", "LEFT");
        if (isset($filter['campaign_id']) && $filter['campaign_id'] != '') {
            $this->db->where("og.campaign_id", $filter['campaign_id']);
            return $this->db->get()->result_array();
        }
        if (isset($filter['link_id']) && $filter['link_id'] != '') {
            $this->db->where("le.link_id", $filter['link_id']);
            return $this->db->get()->result_array();
        }


//        $select = "";
//        if (isset($filter['campaign_id']) && $filter['campaign_id'] != '') {
//           $select =",(SELECT name from offer_goal where campaign_id={$filter['campaign_id']}) as eventName";
//        }
//        
//        $this->db->select("lep.*$select",FALSE)->from("link_event_post lep");
//        if (isset($filter['link_id']) && $filter['link_id'] != '') {
//            $this->db->where("link_id", $filter['link_id']);
//            return $this->db->get()->result_array();
//        }

        return array();
    }

}
