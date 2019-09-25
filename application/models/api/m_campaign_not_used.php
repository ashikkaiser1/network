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
class m_campaign extends CI_Model {

//put your code here

    public function __construct() {
        parent::__construct();
    }

    public function CreateCampaign($Campaign = array()) {
        $this->db->insert("campaign", $Campaign);
        return $this->db->insert_id();
    }

    public function UpdateCampaign($Campaign = array(), $campaign_id = 0) {
        $this->db->where("campaign_id", $campaign_id);
        $this->db->update("campaign", $Campaign);
        return TRUE;
        //$this->db->affected_rows();
    }

    public function deleteCampaign($campaign_id = 0) {
        $this->db->where("campaign_id", $campaign_id);
        $this->db->delete("campaign");

        return $this->db->affected_rows();
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
        $this->db->select("c.*,p.*,ptyp.name as ptypeName")->from("campaign c");
        $this->db->join("campaign_to_post ctp", "c.campaign_id = ctp.campaign_id", "LEFT");
        $this->db->join("posts p", "ctp.post_id=p.post_id");
        $this->db->join("pay_type ptyp", "ptyp.pay_type_id=c.payout_type", "LEFT");
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


        //getCampaign used for api call getOffer 
        //
        
        $this->db->select("p.image,p.meta as offer_des,p.preview_link,c.campaign_id as offer_id ,c.campaign_name as offer_name,c.payout_cost as Payout ,c.geo ,c.status as status,c.start_date,c.end_date,c.cap,u.uid as advertiser_id,c.req_approval,payt_pot.name as payOutTypeName ");
        $this->db->from("campaign c");
        $this->db->join("campaign_to_post cmptop", "cmptop.campaign_id=c.campaign_id");
        $this->db->join("posts p", "p.post_id=cmptop.post_id");

        $this->db->join("users u", "u.uid = c.advertiser_id", "LEFT");

        $this->db->join("pay_type payt_pot ", "c.payout_type = payt_pot.pay_type_id ", "LEFT");
        $this->db->join("pay_type paytr", "c.revenue_type=paytr.pay_type_id ", "LEFT");
        if (isset($filters['campaign_id']) && is_array($filters['campaign_id'])) {

            $this->db->where_in("c.campaign_id", $filters['campaign_id']);

            //  return $this->db->get()->row_array();
        }

        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db->where("u.uid", $filters['uid']);
        }


        $this->db->where("c.ctype", OFFER);


        if (isset($filters['campaign_name']) && $filters['campaign_name'] != '') {
            $this->db->like("c.campaign_name", $filters['campaign_name']);
        }

        // if (isset($filters['status']) && $filters['status'] != '') {
        $this->db->where("c.status", 1);
        // }


        if (isset($filters['order_by']) && $filters['order_by'] == 'campaign_name') {
            $this->db->order_by("c.campaign_name", "ASC");
        }

        if (isset($filters['ctype']) && $filters['ctype'] != '') {
            $this->db->where("c.ctype", $filters['ctype']);
        }


        if (isset($filters['page']) && $filters['page'] != '') {
            $filters['page'] = ($filters['page'] - 1) * 10;
            if (isset($filters['limit']) && $filters['limit'] != '') {
                $this->db->limit($filters['limit'], (int) $filters['page']);
            } else {
                $this->db->limit(10, (int) $filters['page']);
            }
        } else {
//            $this->db->limit(10, 0);
        }


        return $this->db->get()->result_array();
    }

    //waste




    public function getOfferRequest($filters = array()) {

        // $this->db->select("c.*,c.status as c_status,u.*,payt_pot.name as payOutTypeName ,paytr.name as RevenueTypeName ");

        $this->db->select("offerReq.*,c.*,u.*")->from("usr_offerApprovalRequest offerReq ");
        $this->db->join("campaign c", "c.campaign_id=offerReq.campaign_id", "LEFT");
        $this->db->join("users u", "u.uid = offerReq.uid", "LEFT");
        $this->db->join("pay_type payt_pot ", "c.payout_type = payt_pot.pay_type_id ", "LEFT");
        $this->db->join("pay_type paytr", "c.revenue_type=paytr.pay_type_id ", "LEFT");
        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '') {
            $this->db->where("c.campaign_id", $filters['campaign_id']);
            // return $this->db->get()->row_array();
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

    public function changeOfferRequest($offerRequest = array()) {
        if (isset($offerRequest['request_id'])) {
            $this->db->where("request_id", $offerRequest['request_id']);
            $this->db->update("usr_offerApprovalRequest", $offerRequest);
            return $this->db->affected_rows();
        }
        return FALSE;
    }

    public function offerApprovedForUser($campaign_id = 0, $uid = 0) {
        $this->db->select("*")->from("usr_offerApproval");
        $this->db->where("uid", $uid);
        $this->db->where("campaign_id", $campaign_id);
        $app_off = $this->db->get()->row_array();

        if (!empty($app_off))
            return TRUE;
        return FALSE;
    }

}
