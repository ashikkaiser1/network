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

    public function get_post_camp($filters = array()) {



        if (isset($filters['category_id']) && $filters['category_id'] != '' && $filters['category_id'] != 0) {
            $this->db->where("ctop.category_id", $filters['category_id']);
        }

        if (isset($filters['type']) && $filters['type'] != '') {

            $this->db->where("c.ctype", $filters['type']);
        }

        $this->db->where("c.payout_cost !=", 0);
        if (isset($filters['search']) && $filters['search'] != '') {
            $this->db->like("p.title", $filters['search']);
        }

        if (isset($filters['approvalReq']) && $filters['approvalReq']) {

//             $this->db->join("usr_offerApproval uoap", "uoap.campaign_id = c.campaign_id","LEFT");
//             $select =",uoap.uora_id as approved";
        }


        $aff_payout = "(SELECT payout_cost from pay_group where uid = '{$filters['uid']}' and campaign_id=c.campaign_id) as custom_payout";

        $aff_group_payout = "(SELECT pg.payout_cost from pay_group as pg";
        $aff_group_payout .= " LEFT JOIN usr_group_details as ugd on ugd.group_id=pg.group_id ";
        $aff_group_payout .= "  where ugd.uid = '{$filters['uid']}' and pg.campaign_id=c.campaign_id) as group_payout";


        $select = ",uoapp.status as offer_approved, $aff_payout ,$aff_group_payout";

        $select .= " ,group_concat(DISTINCT(dev_m.name)) as targeted_devices";
        $select .= " ,group_concat(DISTINCT(os_m.os_fullname)) as targeted_os";
        $this->db->select("ctp.campaign_id as offer_id,p.title,p.meta as description,p.image,c.status,c.req_approval as required_approval,c.payout_cost,ptype.name as payout_type, group_concat(DISTINCT(cont.iso)) as countries, group_concat(DISTINCT(categ.category_name)) as category " . $select);
        $this->db->from("posts p");
        $this->db->join("campaign_to_post ctp", "ctp.post_id = p.post_id");

        $this->db->join("campaign c", "c.campaign_id = ctp.campaign_id");

        $this->db->join("offer_os off_os", "off_os.campaign_id=c.campaign_id", "LEFT");
        $this->db->join("os_master os_m", "off_os.os_name=os_m.os_name", "LEFT");
        $this->db->join("offer_devices off_dev", "off_dev.campaign_id=c.campaign_id ", "LEFT");
        $this->db->join("device_master dev_m", "off_dev.device_id=dev_m.device_id", "LEFT");
//        
        $this->db->join("pay_type ptype", "ptype.pay_type_id = c.payout_type", "LEFT");
        $this->db->join("category_to_post ctop", "ctop.post_id = p.post_id");
        $this->db->join("category categ", "categ.category_id = ctop.category_id", "LEFT");
        $this->db->join("usr_offerApproval uoapp", " c.campaign_id=uoapp.campaign_id AND uoapp.uid='{$filters['approved_offer_also']}'", "LEFT");


//        , group_concat(cont.iso separator ',') as countries" 
        $this->db->join("offer_country oc", "oc.campaign_id = c.campaign_id", "LEFT");
        $this->db->join("country cont", "oc.country_id = cont.id", "LEFT");

        if (isset($filters['country_id']) && is_array($filters['country_id']) && !empty($filters['country_id'])) {

            $this->db->where_in("oc.country_id", $filters['country_id']);
        }
        $this->db->where("c.status", 1);
        $this->db->where("p.status", 1);


        if (isset($filters['os']) && $filters['os'] != '' && !empty($filters['os']) && is_array($filters['os'])) {

            $this->db->where_in("off_os.os_name ", $filters['os']);
        }

        if (isset($filters['device']) && $filters['device'] != '' && !empty($filters['device']) && is_array($filters['device'])) {

            $this->db->where_in("off_dev.device_id ", $filters['device']);
        }

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
                if (isset($filters['limit_off']) && $filters['limit_off'] <= 2000) {
                    $this->db->limit($filters['limit_off'], (int) $filters['limit']);
                } else {
                    $this->db->limit(100, (int) $filters['limit']);
                }
            }
        } else {
            $this->db->limit(10, 0);
        }
        $post = $this->db->get()->result_array();
        //    echo $this->db->last_query();
        return $post;
    }

}
