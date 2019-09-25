<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_Campaign
 *
 * @author NexGen
 */
class m_Campaign extends CI_Model {

//put your code here

    public function __construct() {
        parent::__construct();
    }

    public function CreateCampaign($Campaign = array()) {
        $this->db->insert("campaign", $Campaign);
        return $this->db->insert_id();
    }

    public function UpdateCampaign($Campaign = array(), $campaign_id = 0) {

        if (is_array($campaign_id)) {
            $this->db->where_in("campaign_id", $campaign_id);
        } else {
            $this->db->where("campaign_id", $campaign_id);
        }

        $this->db->update("campaign", $Campaign);
        return TRUE;
        //$this->db->affected_rows();
    }

    public function deleteCampaign($campaign_id = 0) {
        $this->db->where("campaign_id", $campaign_id);
        $this->db->delete("campaign");

        return $this->db->affected_rows();
    }

    public function offer_redirection_setup($offer_red = array()) {
        //delete first
        $this->delete_offer_redirection($offer_red);
        //function is used for set up the offer redirection 
        //param campaign_id and theer offer_id (campaign_id) that is attached to campaign
        $this->db->insert("offer_redirection", $offer_red);
        return $this->db->insert_id();
    }

    public function delete_offer_redirection($offer_red = array()) {

        if (!empty($offer_red)) {
            $this->db->where("campaign_id", $offer_red['campaign_id']);
            $this->db->delete("offer_redirection");
        }
    }

    public function getRedirectOffer($offer = array()) {

        if (!empty($offer) && isset($offer['campaign_id'])) {

            $this->db->select("r_campaign_id")->from("offer_redirection");
            $this->db->where("campaign_id", $offer['campaign_id']);
            $row = $this->db->get()->row_array();
            if (!empty($row))
                return $row['r_campaign_id'];
        }

        return 0;
    }

    public function addpostToCampaign($campaign_id = 0, $post_id = 0) {
        if ($campaign_id) {
            $this->db->insert('campaign_to_post', array("campaign_id" => $campaign_id, "post_id" => $post_id));
//  echo $this->db->last_query();
            return $this->db->insert_id();
        }
        return FALSE;
    }

    public function addOfferCountry($campaign_id = 0, $countries = array()) {
        //delete the old countries when insert and update
        $this->deleteOfferCountries($campaign_id);
        $insert_data = array();
        if (!empty($countries)) {
            foreach ($countries as $country) {
                $insert_data[] = array("campaign_id" => $campaign_id, "country_id" => $country);
            }

            if (!empty($insert_data)) {
                $this->db->insert_batch("offer_country", $insert_data);
            }
        }
    }

    public function deleteOfferCountries($campaign_id) {
        //delete tehe offer countries
        $this->db->where("campaign_id", $campaign_id);
        $this->db->delete("offer_country");
    }

    public function getOfferDetails($campaign_id = 0) {
        $this->db->select("c.*,p.*,c.status as c_status,ptyp.name as ptypeName,rtyp.name as rtypeName")->from("campaign c");
        $this->db->join("campaign_to_post ctp", "c.campaign_id = ctp.campaign_id", "LEFT");
        $this->db->join("posts p", "ctp.post_id=p.post_id");
        $this->db->join("pay_type ptyp", "ptyp.pay_type_id=c.payout_type", "LEFT");
        $this->db->join("pay_type rtyp", "rtyp.pay_type_id=c.revenue_type", "LEFT");
//        $this->db->join("users u","u.uid=c.advertiser")
        $this->db->where("c.campaign_id", $campaign_id);
        return $this->db->get()->row_array();
    }

    public function getOfferCountry($filters = array()) {
        $this->db->select("country_id")->from("offer_country");
        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '')
            $this->db->where("campaign_id", $filters['campaign_id']);
        return $this->db->get()->result_array();
    }

    public function updatepostTocampaign($campaign_id = 0, $post_id = 0) {
        if ($campaign_id) {
            $this->db->where("post_id", $post_id);
            $this->db->update('campaign_to_post', array("campaign_id" => $campaign_id, "post_id" => $post_id));
//  echo $this->db->last_query();
            return $this->db->affected_rows();
        }
        return FALSE;
    }

    public function is_pending_request($campaign_id = 0, $uid = 0) {

        $this->db->select("req_status")->from("usr_offerApprovalRequest");
        $this->db->where(array("campaign_id" => $campaign_id, "uid" => $uid));
        $req = $this->db->get()->row_array();
        if (!empty($req) && $req['req_status'] == 0)
            return TRUE;
        return FALSE;
    }

    public function check_offerApproval($campaign_id = 0) {
        $this->db->select("req_approval")->from("campaign");
        $this->db->where("campaign_id", $campaign_id);
//        $this->db->where("req_approval",0);
        $req_app = $this->db->get()->row_array();
        // print_r($req_app);
        if (!empty($req_app) && (int) $req_app['req_approval'] == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public function getCampaign($filters = array()) {




        $select = ",GROUP_CONCAT(cat.category_name) as catName";
        $select.= ",GROUP_CONCAT(countri.iso3) as countryName";

        $select = "c.*,c.status as c_status,u.uid,u.name,payt_pot.name as payOutTypeName ,paytr.name as RevenueTypeName,p.preview_link $select ";


        $this->db->select($select);
        $this->db->from("campaign c");



        $this->db->join("users u", "u.uid = c.advertiser_id", "LEFT");
        $this->db->join("pay_type payt_pot ", "c.payout_type = payt_pot.pay_type_id ", "LEFT");
        $this->db->join("pay_type paytr", "c.revenue_type=paytr.pay_type_id ", "LEFT");


        $this->db->join("campaign_to_post camp_to_p", "camp_to_p.campaign_id = c.campaign_id", "LEFT");
        $this->db->join("posts p", "p.post_id = camp_to_p.post_id and camp_to_p.campaign_id= camp_to_p.campaign_id", "LEFT");


        $this->db->join("category_to_post cat_to_p", "cat_to_p.post_id = p.post_id", "LEFT");
        $this->db->join("category cat", "cat.category_id = cat_to_p.category_id", "LEFT");

        $this->db->join("offer_country oc", "oc.campaign_id = c.campaign_id", "LEFT");
        $this->db->join("country countri", "oc.country_id = countri.id", "LEFT");







        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '' && !is_array($filters['campaign_id'])) {
            $this->db->where("c.campaign_id", $filters['campaign_id']);
            return $this->db->get()->row_array();
        }

        if (isset($filters['campaign_id']) && is_array($filters['campaign_id'])) {
            $this->db->where_in("c.campaign_id", $filters['campaign_id']);
        }

        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db->where("u.uid", $filters['uid']);
        }

        if (isset($filters['campaign_name']) && $filters['campaign_name'] != '') {
            $this->db->like("c.campaign_name", $filters['campaign_name']);
        }

        if (isset($filters['status']) && $filters['status'] != '') {
            $this->db->where("c.status", $filters['status']);
        }

        if (isset($filters['group_by']) && $filters['group_by'] == 'campaign_id') {
            $this->db->group_by("c.campaign_id");
        }


        if (isset($filters['order_by']) && $filters['order_by'] == 'campaign_name') {
            $this->db->order_by("c.campaign_name", "ASC");
        }

        if (isset($filters['order_by']) && $filters['order_by'] == 'campaign_id') {
            $this->db->order_by("c.campaign_id", "DESC");
        }

        if (isset($filters['ctype']) && $filters['ctype'] != '') {
            $this->db->where("c.ctype", $filters['ctype']);
        }

        if (isset($filters['Featured']) && $filters['Featured'] != '') {
            $this->db->where("c.featured", 1);
        }






        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db->limit(10, (int) $filters['limit']);
        } else {
//            $this->db->limit(10, 0);
        }

        if (isset($filters['Formated']) && $filters['Formated'] != '') {

            $campaigns = $this->db->get()->result_array();
            $list = array();
            $list[0] = "Not Now";
            if (!empty($campaigns)) {
                foreach ($campaigns as $camp) {
                    $list[$camp['campaign_id']] = $camp['campaign_name'];
                }
            }

            return $list;
        }

        $result = $this->db->get()->result_array();
        //echo $this->db->last_query();
        return $result;
    }

    public function getOfferRequest($filters = array()) {

        // $this->db->select("c.*,c.status as c_status,u.*,payt_pot.name as payOutTypeName ,paytr.name as RevenueTypeName ");

        $this->db->select("offerReq.*,c.campaign_name,c.campaign_id,u.uid,u.name,uoap.uora_id")->from("usr_offerApprovalRequest offerReq ");
        $this->db->join("campaign c", "c.campaign_id=offerReq.campaign_id", "LEFT");
        $this->db->join("users u", "u.uid = offerReq.uid", "LEFT");
        $this->db->join("usr_offerApproval uoap", "uoap.uid = offerReq.uid and uoap.campaign_id=offerReq.campaign_id", "LEFT");
        $this->db->join("pay_type payt_pot ", "c.payout_type = payt_pot.pay_type_id ", "LEFT");
        $this->db->join("pay_type paytr", "c.revenue_type=paytr.pay_type_id ", "LEFT");
        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '') {
            $this->db->where("c.campaign_id", $filters['campaign_id']);
            // return $this->db->get()->row_array();
        }

        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db->where("u.uid", $filters['uid']);
        }


        if (isset($filters['request_id']) && $filters['request_id'] != '') {
            $this->db->where("offerReq.request_id", $filters['request_id']);
            return $this->db->get()->row_array();
        }

        if (isset($filters['campaign_name']) && $filters['campaign_name'] != '') {
            $this->db->like("c.campaign_name", $filters['campaign_name']);
        }

        if (isset($filters['status']) && $filters['status'] != '') {
            $this->db->where("c.status", $filters['status']);
        }

        if (isset($filters['ctype']) && $filters['ctype'] != '') {
            $this->db->where("c.ctype", $filters['ctype']);
        }


        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db->limit(10, (int) $filters['limit']);
        } else {
//            $this->db->limit(10, 0);
        }

        $this->db->order_by("offerReq.DateTiime", "DESC");

        if (isset($filters['Formated']) && $filters['Formated'] != '') {

            $campaigns = $this->db->get()->result_array();
            $list = array();
            $list[0] = "Not Now";
            if (!empty($campaigns)) {
                foreach ($campaigns as $camp) {
                    $list[$camp['campaign_id']] = $camp['campaign_name'];
                }
            }

            return $list;
        }

        return $this->db->get()->result_array();
    }

    public function get_post_camp($filters = array()) {


        $this->db->select("p.*,ctp.campaign_id");
        $this->db->from("posts p");
        if (isset($filters['getPostNonCampaign']) && $filters['getPostNonCampaign'] != '') {
            $this->db->join("campaign_to_post ctp", "ctp.post_id != p.post_id");

            $this->db->where("p.post_id not in (SELECT post_id from campaign_to_post)", NULL, FALSE);
        }

        if (isset($filters['web_id']) && $filters['web_id'] != '') {
            $this->db->where("p.web_id", $filters['web_id']);
        }
        if (isset($filters['title']) && $filters['title'] != '') {
            $this->db->like("p.title", $filters['title'], "both");
        }

        if (isset($filters['ctype']) && $filters['ctype'] != '') {
            $this->db->where("p.type", $filters['ctype']);
        }

        if (isset($filters['category_id']) && $filters['category_id'] != '') {
            $this->db->join("category_to_post ctpo", "ctpo.post_id=p.post_id");
            $this->db->where("ctpo.category_id", $filters['category_id']);
        }




//        $this->db->join("campaign c", "c.campaign_id = ctp.campaign_id", "LEFT");
//        $this->db->join("users u", "u.uid = c.advertiser_id", "LEFT");

        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '') {
            $this->db->join("campaign_to_post ctp", "ctp.post_id = p.post_id");
            $this->db->where("ctp.campaign_id = {$filters['campaign_id']} ", NULL, FALSE);
//return $this->db->get()->row_array();
        }
        $this->db->order_by("p.post_id", "DESC");

        $this->db->group_by("p.post_id");


//        
        $post = $this->db->get()->result_array();


//  echo $this->db->last_query();

        return $post;
    }

    public function getPost_id($filters) {
        $this->db->select("post_id")->from("campaign_to_post");
        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '') {
            $this->db->where("campaign_id", $filters['campaign_id']);
        }
        $post = $this->db->get()->row_array();
        if (!empty($post))
            return $post['post_id'];
        return 0;
    }

    public function delPostFromCamp($filters = array()) {

        $this->db->where($filters);
        $this->db->delete("campaign_to_post");
        return $this->db->affected_rows();
    }

    public function setofferApprove($UserOffer = array()) {
        //offer is approvel by admin to affiliate
        //not use for Generate publisher Link from Admin
        //From Date 2 Feb 2017

        $filter = array();
        $filter['status'] = 1;
        if ($this->offerApprovedForUser($UserOffer['campaign_id'], $UserOffer['uid'], $filter)) {
            $this->db->where($UserOffer);
            $this->db->delete("usr_offerApproval");
        }
        $this->db->insert("usr_offerApproval", $UserOffer);
        return $this->db->insert_id();
        return FALSE;
    }

    public function deleteOferApproval($usr_offerAproval = array()) {
        //delete the offer approval by admin 
        //not use for Generate publisher Link from Admin
        //From Date 2 Feb 2017
        $this->db->where($usr_offerAproval);
        $this->db->delete("usr_offerApproval");
        return $this->db->affected_rows();
    }

    public function changeOfferRequest($offerRequest = array()) {
        if (isset($offerRequest['request_id'])) {
            $this->db->where("request_id", $offerRequest['request_id']);
            $this->db->update("usr_offerApprovalRequest", $offerRequest);
            return $this->db->affected_rows();
        }
        return FALSE;
    }

    public function offerApprovedForUser($campaign_id = 0, $uid = 0, $filters = array()) {
        $this->db->select("*")->from("usr_offerApproval");
        $this->db->where("uid", $uid);
        $this->db->where("campaign_id", $campaign_id);
        if (isset($filters['status']))
            $this->db->where("status", $filters['status']);
        $app_off = $this->db->get()->row_array();

        if (!empty($app_off))
            return TRUE;
        return FALSE;
    }

    public function getCountry($filters = array()) {

        $this->db->select("*")->from("country");
        if (isset($filters['countries']) && is_array($filters['countries']) && !empty($filters['countries']))
            $this->db->where_in("id", $filters['countries']);
        return $this->db->get()->result_array();
    }

    public function setCampaignToCaps($campToCap = array()) {
        //setting or insets the Daily Cap ,Daily Budget ,Monthly Cap ,Monthly Budget
        if (!empty($campToCap)) {
            $this->db->insert_on_duplicate_update_batch("campaign_to_cap", $campToCap, " ctc_id=LAST_INSERT_ID(ctc_id), ");
        }

        return TRUE;
    }
    
    public function getCampaignToCaps($filters = array()) {
        
        $this->db->select("*");
        $this->db->from("campaign_to_cap");
        if (isset($filters['campaign_id']) && $filters['campaign_id'] !='') {
            $this->db->where("campaign_id", $filters['campaign_id']);
        }
        
        return $this->db->get()->result_array();
    }

}
