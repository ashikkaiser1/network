<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_reports
 *
 * @author NexGen
 */
class m_reports extends CI_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
    }
    
    public function get_app_user_points($filters= array()) {
        
        $this->db->select("count(tr.transaction_id)")->from("transactions");
        $this->db->join("publisher_trk_extra pbtre","pbtre.transaction_id=tr.transaction_id");
        
        $this->db->where("pbtre.app_user_id",$filters['app_user_id']);
        $this->db->where("tr.c_valid",1);
        $this->db->where("pbtre.col_name","app_user_id");
        return $this->db->get()->result_array();
        
        
    }

    public function getAdvanceReport($filters = array()) {
        $report = array();
        $select = "";

        // print_r($filters);
//        $select.=",p.post_id";
//        $this->db->join("posts p", "p.post_id=ct.post_id");
//return group elements and extra select elemens;
        $col_group_by = $this->group_by_return($filters);
        $select.= $col_group_by['select'];
        $this->db->group_by($col_group_by['groupby']);


        //please chnage groupby to select in futre
        if (isset($filters['groupby']['payout_type'])) {
            $select.=",ptyp.name as Pay_Type";
        }

        if (isset($filters['groupby']['revenue_type'])) {
            $select.=",ptyp_rev.name as Revenue_Type";
        }

//        if (isset($col_group_by['groupby']['payout_type'])) {
//            $select.=",ptyp.name as Pay_Type";
//        }
        if (isset($filters['groupby']['cpa'])) {
            $select.=",ct.payout_cost as CPA";
        }
//        $select.=",ct.payout_cost as Pay_out";
        if (isset($filters['groupby']['rpa'])) {
            $select.=",cmp.revenue_cost as RPA";
        }

        //end
        // $select.=",cmp.revenue_cost as Revenue_Cost";
        $this->db->join("pay_type ptyp", "ptyp.pay_type_id=ct.payout_type", "LEFT");


        $this->db->join("campaign cmp", "cmp.campaign_id=ct.campaign_id");

        $this->db->join("pay_type ptyp_rev", "ptyp_rev.pay_type_id = cmp.revenue_type", "LEFT");
        if (isset($filters['select']['clicks'])) {
            $select.=",  count(ct.link_id) as Clicks ";
        }

        // $select.=",  count(ct.link_id) as Clicks ";
        if (isset($filters['select']['conversion'])) {
            $select.=", sum((SELECT count(tr.transaction_id) from transactions tr where tr.transaction_id = ct.transaction_id and tr.goal =0 group by tr.transaction_id) ) as Conversion";
        }
//  }
        //$this->db->join("transactions tr", "tr.transaction_id=ct.transaction_id");

        if (isset($filters['goals'])) {
            //print_r($filters['goals']);
            if (!empty($filters['goals'])) {
                foreach ($filters['goals'] as $key => $goal) {
                    $select.=", sum((SELECT count(tr.transaction_id) from transactions tr JOIN offer_goal offg on offg.offer_goal_id=tr.goal and offg.goal_id = '{$goal}' where tr.transaction_id = ct.transaction_id group by tr.transaction_id )) as $key";
                }
            }
        }


//        4 : CPA,
//        5 :CPC

        if (isset($filters['select']['cost'])) {
            $select.=",CASE ct.payout_type 
WHEN '4' THEN ROUND(sum((SELECT count(tr.transaction_id) from transactions tr where tr.transaction_id = ct.transaction_id and tr.goal =0 group by tr.transaction_id )) * ct.payout_cost ,2)
WHEN '5' THEN ROUND(count(ct.link_id)*ct.payout_cost,2)
ELSE '0'
END as Cost";
            //Payout
        }
// that is earned by affiliate 
//ROUND(sum(ct.payout_cost),2) as Payout1 

        if (isset($filters['select']['revenue'])) {
            $select.=",CASE ct.payout_type 
WHEN '4' THEN ROUND(sum((SELECT count(tr.transaction_id) from transactions tr where tr.transaction_id = ct.transaction_id and tr.goal =0 group by tr.transaction_id )) * cmp.revenue_cost ,2)
WHEN '5' THEN ROUND(sum(cmp.revenue_cost),2)
ELSE '0'
END as Revenue";
        }

// pay to admin by advertiser
//ROUND((SELECT Revenu) - (SELECT Payout)  ,2)
        if (isset($filters['select']['profit'])) {
            $qry1 = "sum((SELECT count(tr.transaction_id) from transactions tr where tr.transaction_id = ct.transaction_id and tr.goal =0 group by tr.transaction_id) ) * ct.payout_cost";
            $qry2 = "sum((SELECT count(tr.transaction_id) from transactions tr where tr.transaction_id = ct.transaction_id and tr.goal =0 group by tr.transaction_id )) * cmp.revenue_cost ";
            $select.=",CASE ct.payout_type 
WHEN '4' THEN ROUND(($qry2 - $qry1),2)
WHEN '5' THEN ROUND(sum(cmp.revenue_cost) - sum(ct.payout_cost),2)
ELSE '0'
END as Profit";
        }
//
//}//earned by admin
        // $select.=", ROUND(sum(cmp.revenue_cost),2) as Revenue , ROUND((sum(cmp.revenue_cost) - sum(ct.payout_cost)),2) as Profit ";







        $this->db->join("users u", "u.uid=ct.uid", "LEFT");
        $this->db->join("users advertiser", "advertiser.uid=cmp.advertiser_id", "LEFT");

//        $this->db->join("users adver", "adver.uid=ct.uid","LEFT");
//        if (isset($filters['groupby']) && $filters['groupby'] == 'post') {
//            $this->db->group_by("ct.post_id");
//        }




        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db->where_in("ct.uid", $filters['uid']);
        }

        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '') {
            $this->db->where_in("ct.campaign_id", $filters['campaign_id']);
        }

        if (isset($filters['startDate']) && $filters['startDate'] != '' && isset($filters['endDate']) && $filters['endDate'] != '') {
            $this->db->where("Date(ct.dateTime) BETWEEN '{$filters['startDate']}' AND '{$filters['endDate']}'", NULL, FALSE);
        }


//        $this->db->where("");
        //  $this->group_by_return($filters);
        //$this->db->group_by("ct.date");
        if (isset($filters['orderby']) && $filters['orderby'] == 'date') {
            $sort = '';
            if (isset($filters['sort']) && $filters['sort'] != '') {
                $sort = $filters['sort'];
            }

            $this->db->order_by("Date(ct.dateTime)", $sort);
        }


        if (isset($filters['orderby']) && $filters['orderby'] == 'uid') {
            $sort = '';
            if (isset($filters['sort']) && $filters['sort'] != '') {
                $sort = $filters['sort'];
            }

            $this->db->order_by("ct.uid", $sort);
        }

        if (isset($filters['orderby']) && $filters['orderby'] == 'campaign') {
            $sort = '';
            if (isset($filters['sort']) && $filters['sort'] != '') {
                $sort = $filters['sort'];
            }

            $this->db->order_by("ct.campaign_id", $sort);
        }


//,Date(ct.dateTime) as date
//        ct.clicktracker_id,
        $this->db->select("$select", FALSE)->from("click_tracker ct");


        $this->db->where("ct.valid", 1);


        $report = $this->db->get()->result_array();
        // echo $this->db->last_query();

        return $report;
    }

    private function group_by_return($group_by_array) {

        if (!isset($group_by_array['groupby']))
            return '';
        $group_by = '';
        $select = '';


        foreach ($group_by_array['groupby'] as $val) {

            if (isset($val) && $val == 'date') {
                //$this->db->group_by("Date(ct.dateTime)");

                $group_by.="Date(ct.dateTime),";
                $select.= ",Date(ct.dateTime) as Date";
                //  $this->db->group_by("ct.country");
            }





            if (isset($val) && $val == 'offer_id') {
                // $this->db->group_by("ct.campaign_id");
                $group_by.="ct.campaign_id,";
                $select.= ",ct.campaign_id as Offer_ID";
            }

            if (isset($val) && $val == 'aff_id') {
                // $this->db->group_by("ct.campaign_id");
                $select.=",u.uid as Aff_id";
                $group_by.="u.uid,";
//                $group_by.=",u.uid";
            }
            if (isset($val) && $val == 'aff_name') {
                // $this->db->group_by("ct.campaign_id");
                $select.=",u.name as Aff_Name";
                $group_by.="u.uid,";
            }

            if (isset($val) && $val == 'advertiser_id') {
                // $this->db->group_by("ct.campaign_id");
                $select.=",advertiser.uid as Adv_ID";
                $group_by.="advertiser.uid,";
            }

            if (isset($val) && $val == 'country') {
                // $this->db->group_by("ct.campaign_id");
                $select.=",ct.country as Country";
                $group_by.="ct.country,";
            }

            if (isset($val) && $val == 'advertiser') {
                // $this->db->group_by("ct.campaign_id");
                $select.=",advertiser.name as Adv_Name";
                $group_by.="advertiser.uid,";
            }

            if (isset($val) && $val == 'offer') {
                // $this->db->group_by("ct.campaign_id");
                $group_by.="ct.campaign_id,";
                $select.=",cmp.campaign_name as Offer_Name ";
            }

            if (isset($val) && $val == 'hour') {
                // $this->db->group_by("ct.campaign_id");
                $group_by.="HOUR(ct.dateTime),";
                $select.= ",HOUR(ct.dateTime) as Hour";
            }

            if (isset($val) && $val == 'week') {
                // $this->db->group_by("ct.campaign_id");
                $group_by.="WEEK(ct.dateTime),";
                $select.= ",WEEK(ct.dateTime) as Week";
            }

            if (isset($val) && $val == 'month') {
                // $this->db->group_by("ct.campaign_id");
                $group_by.="MONTH(ct.dateTime),";
                $select.= ",MONTH(ct.dateTime) as Month";
            }

            if (isset($val) && $val == 'year') {
                // $this->db->group_by("ct.campaign_id");
                $group_by.="YEAR(ct.dateTime),";
                $select.= ",YEAR(ct.dateTime) as Year";
            }




            if (isset($val) && $val == 'uid') {
//                $this->db->group_by("ct.uid");
                $group_by.="ct.uid,";
                $select.= ",ct.uid as aff_id";
            }

            if (isset($val) && $val == 'cpc') {
//                $this->db->group_by("ct.uid");
                // $group_by.="ct.uid,";
                $select.= ",ROUND((sum((SELECT count(tr.transaction_id) from transactions tr where tr.transaction_id = ct.transaction_id group by tr.transaction_id)) * ct.payout_cost )/count(ct.link_id) ,2) AS CPC";
            }

            if (isset($val) && $val == 'rpc') {
//                $this->db->group_by("ct.uid");
                // $group_by.="ct.uid,";
                $select.= ",ROUND((sum((SELECT count(tr.transaction_id) from transactions tr where tr.transaction_id = ct.transaction_id group by tr.transaction_id)) * cmp.revenue_cost)/count(ct.link_id) ,2) as RPC";
            }

            //
        }

        return array("select" => $select, "groupby" => $group_by);
    }

    public function getReport($filters = array()) {
        $report = array();
        $select = "";
//        $select.=",CASE ct.payout_type 
//WHEN '4' THEN ROUND(sum((SELECT count(tr.transaction_id) from transactions tr where tr.transaction_id = ct.transaction_id and tr.goal =0 group by tr.transaction_id )) * ct.payout_cost ,2)
//WHEN '5' THEN ROUND(count(ct.link_id)*ct.payout_cost,2)
//ELSE '0'
//END as earn";
        if (isset($filters['groupby']) && $filters['groupby'] == 'post') {
            $this->db->group_by("ct.post_id");
            $select.=",p.*";
            $this->db->join("posts p", "p.post_id=ct.post_id");
        }


        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db->where("ct.uid", $filters['uid']);
        }

        if (isset($filters['startDate']) && $filters['startDate'] != '' && isset($filters['endDate']) && $filters['endDate'] != '') {
            $this->db->where("Date(ct.dateTime) BETWEEN '{$filters['startDate']}' AND '{$filters['endDate']}'", NULL, FALSE);
        }

        $this->db->select("ct.*,count(ct.link_id) as clicks ,Date(ct.dateTime) as date $select", FALSE)->from("click_tracker ct");





//        $this->db->where("");
        $this->db->where("ct.valid", 1);
        if (isset($filters['groupby']) && $filters['groupby'] == 'date') {
            $countyGroup = "";
            $countyGroup = isset($filters['country']) ? ",ct.country" : "";
            $this->db->group_by("Date(ct.dateTime)$countyGroup");
            //  $this->db->group_by("ct.country");
        }
        //$this->db->group_by("ct.date");
        $this->db->order_by("Date(ct.dateTime)", "ASC");



        $report = $this->db->get()->result_array();
        //  echo $this->db->last_query();

        return $report;
    }

    public function getgraphData($filters = array()) {
        $this->db->select("count(cltr.link_id) as clicks,cltr.country,Date(cltr.dateTime) as date");
        $this->db->from("click_tracker cltr");
        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db->where("cltr.uid", $filters['uid']);
        }

        if (isset($filters['startDate']) && $filters['startDate'] != '' && isset($filters['endDate']) && $filters['endDate'] != '') {

            $this->db->where("Date(cltr.dateTime) BETWEEN '{$filters['startDate']}' AND '{$filters['endDate']}'", NULL, FALSE);
        }
        $this->db->where("cltr.valid", 1);

        $this->db->group_by("Date(cltr.dateTime),cltr.country");
        $this->db->order_by("Date(cltr.dateTime)", "ASC");

        $list = $this->db->get()->result_array();

        //  echo $this->db->last_query();
        return $list;
    }

    public function getTotalClicks($filters = array()) {
        $this->db->select("count(link_id) as clicks");
        $this->db->from("click_tracker");
        $this->db->where("valid", 1);
        return $this->db->get()->row_array();
    }

    public function getTotalVisitors($filters = array()) {
        $this->db->select("count(Distinct ip_address) as visitors");
        $this->db->from("click_tracker");
//        $this->db->group_by("ip_address");
        return $this->db->get()->row_array();
    }

    public function getTotalUsers($filters = array()) {
        $this->db->select("count(case when status= 1 then 1 end) as active_user,count(case when status= 0 then 1 end) as deactive_user");
        $this->db->from("users");
        return $this->db->get()->row_array();
    }

    public function getTotalCampaign($filters = array()) {
        $this->db->select("count(case when status= 1 then 1 end) as active_camp,count(case when status= 0 then 1 end) as deactive_camp");
        $this->db->from("campaign");
        return $this->db->get()->row_array();
    }

}
