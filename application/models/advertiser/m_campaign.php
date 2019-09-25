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

    public function getCampaign($filters = array()) {

        $this->db->select("c.*,c.status as c_status,u.*");
        $this->db->from("campaign c");
        $this->db->join("users u", "u.uid = c.advertiser_id");

        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '') {
            $this->db->where("c.campaign_id", $filters['campaign_id']);
            return $this->db->get()->row_array();
        }

        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db->where("u.uid", $filters['uid']);
        }
        if (isset($filters['status']) && $filters['status'] != '') {
            $this->db->where("c.status", $filters['status']);
        }

        if (isset($filters['Featured']) && $filters['Featured'] != '') {
            $this->db->where("c.featured", 1);
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

        return $this->db->get()->result_array();
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
        //get offer country or get tragets
        $this->db->select("c.iso,c.name")->from("offer_country oc");
        $this->db->join("country c", "c.id=oc.country_id", "RIGHT");

        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '')
            $this->db->where("oc.campaign_id", $filters['campaign_id']);
        return $this->db->get()->result_array();
        //end
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

    public function offerApprovedForUser($campaign_id = 0, $uid = 0, $filter = array()) {
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

    public function getpayout_cost_type($campaign_id = 0) {
        $this->db->select("payout_cost,payout_type")->from("campaign");
        $this->db->where("campaign_id", $campaign_id);
        $revenue = $this->db->get()->row_array();
        if (!empty($revenue))
            return $revenue;
        return 0;
    }

    public function affiliate_apply_for_offer($offerRequest = array()) {
        //Affiliate fill form for request to admin for offer approval
        $this->db->insert("usr_offerApprovalRequest", $offerRequest);
        return $this->db->insert_id();
    }

    public function is_pending_request($campaign_id = 0, $uid = 0) {

        $this->db->select("req_status")->from("usr_offerApprovalRequest");
        $this->db->where(array("campaign_id" => $campaign_id, "uid" => $uid));
        $req = $this->db->get()->row_array();
        if (!empty($req) && $req['req_status'] == 0)
            return TRUE;
        return FALSE;
    }

    public function get_post_camp($filters = array()) {

//        echo '<pre>';
//        print_r($filters);
        $select = "";

        if (isset($filters['category_id']) && $filters['category_id'] != '' && $filters['category_id'] != 0) {
            $this->db->where("ctop.category_id", $filters['category_id']);
        }

        if (isset($filters['type']) && $filters['type'] != '') {

            $this->db->where("c.ctype", $filters['type']);
        }
        
         if (isset($filters['advertiser_id']) && $filters['advertiser_id'] != '') {

            $this->db->where("c.advertiser_id", $filters['advertiser_id']);
        }
        

        if (isset($filters['search']) && $filters['search'] != '') {
            $this->db->like("p.title", $filters['search']);
        }

        if (isset($filters['approvalReq']) && $filters['approvalReq']) {

//             $this->db->join("usr_offerApproval uoap", "uoap.campaign_id = c.campaign_id","LEFT");
//             $select =",uoap.uora_id as approved";
        }


//        $this->db->select("p.*,ctp.campaign_id,c.status,c.req_approval,c.revenue_cost as payout_cost,ptype.name as payout_type, group_concat(cont.iso) as countries " . $select);
//        $this->db->from("posts p");
//        $this->db->join("campaign_to_post ctp", "ctp.post_id = p.post_id");
//        $this->db->join("campaign c", "c.campaign_id = ctp.campaign_id");
//        $this->db->join("pay_type ptype", "ptype.pay_type_id = c.payout_type", "LEFT");
//        $this->db->join("category_to_post ctop", "ctop.post_id = p.post_id");
        
         $this->db->select("p.*,ctp.campaign_id,c.status,c.req_approval,c.revenue_cost as paycost,ptype.name as payout_type, group_concat(DISTINCT(cont.iso)) as countries, group_concat(DISTINCT(categ.category_name)) as catName " . $select);
        $this->db->from("posts p");
        $this->db->join("campaign_to_post ctp", "ctp.post_id = p.post_id");
        $this->db->join("campaign c", "c.campaign_id = ctp.campaign_id");
        $this->db->join("pay_type ptype", "ptype.pay_type_id = c.payout_type", "LEFT");
        $this->db->join("category_to_post ctop", "ctop.post_id = p.post_id");
        $this->db->join("category categ", "categ.category_id = ctop.category_id","LEFT");


//        , group_concat(cont.iso separator ',') as countries" 
        $this->db->join("offer_country oc", "oc.campaign_id = c.campaign_id", "LEFT");
        $this->db->join("country cont", "oc.country_id = cont.id", "LEFT");

        if (isset($filters['country_id']) && is_array($filters['country_id']) && !empty($filters['country_id'])) {
          
            $this->db->where_in("oc.country_id", $filters['country_id']);
        }
        
        if (isset($filters['status']) && $filters['status'] != '') {
            $this->db->where("c.status", $filters['status']);
            $this->db->where("p.status", 1);
        }
//        $this->db->where("c.status", 1);
        


        if (isset($filters['onlyMe']) && $filters['onlyMe'] != '') {
            $this->db->join("link lk", "lk.post_id = p.post_id", "RIGHT");
            $this->db->where("lk.uid", $filters['onlyMe']);
        }
        $this->db->order_by("p.post_id", "DESC");
        $this->db->group_by("p.post_id");

        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;

            if (isset($filters['url_nos']) && $filters['url_nos'] != '') {
                $this->db->limit($filters['url_nos'], 0);
            } else {
                $this->db->limit(10, (int) $filters['limit']);
            }
        } else {
            $this->db->limit(10, 0);
        }
        $post = $this->db->get()->result_array();
        //    echo $this->db->last_query();
        return $post;
    }

}
