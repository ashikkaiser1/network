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
    private $db_reader;

    public function __construct() {
        parent::__construct();

        $this->db_reader = $this->load->database("db_reader", TRUE);
    }

    public function getAdvanceReport($filters = array()) {
        $report = array();
        $select = "";

        // print_r($filters);
//        $select.=",p.post_id";
//        $this->db_reader->join("posts p", "p.post_id=ct.post_id");
//return group elements and extra select elemens;
        $col_group_by = $this->group_by_return($filters);
        $select.= $col_group_by['select'];
        $this->db_reader->group_by($col_group_by['groupby']);


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
        $this->db_reader->join("pay_type ptyp", "ptyp.pay_type_id=ct.payout_type", "LEFT");
        $this->db_reader->join("offer_urls ou", "ou.url_id=ct.url_id", "LEFT");

        $this->db_reader->join("campaign cmp", "cmp.campaign_id=ct.campaign_id");

        $this->db_reader->join("pay_type ptyp_rev", "ptyp_rev.pay_type_id = cmp.revenue_type", "LEFT");
        if (isset($filters['select']['clicks'])) {
            $select.=",  sum(CASE WHEN ct.track_type=0 THEN 1 ELSE 0 END) as Clicks ";
        }

        // $select.=",  count(ct.link_id) as Clicks ";
        if (isset($filters['select']['conversion'])) {
            $select.=", sum(CASE WHEN trr.goal=0 and trr.c_valid=1 THEN 1 ELSE 0 END) as Conversion";
        }
        
        if (isset($filters['select']['CR'])) {
            $select.=", ROUND( (sum(CASE WHEN trr.goal=0 and trr.c_valid=1 THEN 1 ELSE 0 END) / sum(CASE WHEN ct.track_type=0 THEN 1 ELSE 0 END)) * 100,2 ) as CR   ";
        }

        if (isset($filters['select']['impression'])) {
            $select.=",  sum(CASE WHEN ct.track_type=1 THEN 1 ELSE 0 END) as Impression ";
        }
        
        
//  }
        //$this->db_reader->join("transactions tr", "tr.transaction_id=ct.transaction_id");

        if (isset($filters['goals'])) {

            //$this->db_reader->join("offer_goal offg","offg.offer_goal_id=trr.goal","LEFT");
            //print_r($filters['goals']);
            if (!empty($filters['goals'])) {
                foreach ($filters['goals'] as $key => $goal) {
                    $select.=", sum(CASE WHEN trr.goal=offg.offer_goal_id and offg.goal_id = {$goal} THEN 1 ELSE 0 END) as $key";
                }
            }
        }


//        4 : CPA,
//        5 :CPC

        if (isset($filters['select']['payout'])) {
            $select.=",CASE ct.payout_type 
WHEN '4' THEN ROUND(sum(CASE WHEN trr.goal=0 THEN 1 ELSE 0 END) * ct.payout_cost ,2)
WHEN '5' THEN ROUND(count(ct.link_id)*ct.payout_cost,2)
ELSE '0'
END as Payout";
            //Payout
        }
// that is earned by affiliate 
//ROUND(sum(ct.payout_cost),2) as Payout1 

        if (isset($filters['select']['revenue'])) {
            $select.=",CASE ct.payout_type 
WHEN '4' THEN ROUND(sum(CASE WHEN trr.goal=0 THEN 1 ELSE 0 END) * cmp.revenue_cost ,2)
WHEN '5' THEN ROUND(sum(cmp.revenue_cost),2)
ELSE '0'
END as Revenue";
        }

// pay to admin by advertiser
//ROUND((SELECT Revenu) - (SELECT Payout)  ,2)
        if (isset($filters['select']['profit'])) {
            $qry1 = "sum(CASE WHEN trr.goal=0 THEN 1 ELSE 0 END ) * ct.payout_cost";
            $qry2 = "sum(CASE WHEN trr.goal=0 THEN 1 ELSE 0 END) * cmp.revenue_cost ";
            $select.=",CASE ct.payout_type 
WHEN '4' THEN ROUND(($qry2 - $qry1),2)
WHEN '5' THEN ROUND(sum(cmp.revenue_cost) - sum(ct.payout_cost),2)
ELSE '0'
END as Profit";
        }
//
//}//earned by admin
        // $select.=", ROUND(sum(cmp.revenue_cost),2) as Revenue , ROUND((sum(cmp.revenue_cost) - sum(ct.payout_cost)),2) as Profit ";







        $this->db_reader->join("users u", "u.uid=ct.uid", "LEFT");
        $this->db_reader->join("users advertiser", "advertiser.uid=cmp.advertiser_id", "LEFT");
        $this->db_reader->join("transactions trr", "trr.transaction_id=ct.transaction_id", "LEFT");
        if (isset($filters['goals'])) {

            $this->db_reader->join("offer_goal offg", "offg.offer_goal_id=trr.goal", "LEFT");
        }


//        $this->db_reader->join("users adver", "adver.uid=ct.uid","LEFT");
//        if (isset($filters['groupby']) && $filters['groupby'] == 'post') {
//            $this->db_reader->group_by("ct.post_id");
//        }




        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db_reader->where_in("ct.uid", $filters['uid']);
        }

        if (isset($filters['campaign_id']) && $filters['campaign_id'] != '') {
            $this->db_reader->where_in("ct.campaign_id", $filters['campaign_id']);
        }

        if (isset($filters['startDate']) && $filters['startDate'] != '' && isset($filters['endDate']) && $filters['endDate'] != '') {
            $this->db_reader->where("ct.dateTime BETWEEN '{$filters['startDate']} 00:00:00' AND '{$filters['endDate']} 23:59:00'", NULL, FALSE);
        }


//        $this->db_reader->where("");
        //  $this->group_by_return($filters);
        //$this->db_reader->group_by("ct.date");
        if (isset($filters['orderby']) && $filters['orderby'] == 'date') {
            $sort = '';
            if (isset($filters['sort']) && $filters['sort'] != '') {
                $sort = $filters['sort'];
            }

            $this->db_reader->order_by("ct.dateTime", $sort);
        }


        if (isset($filters['orderby']) && $filters['orderby'] == 'uid') {
            $sort = '';
            if (isset($filters['sort']) && $filters['sort'] != '') {
                $sort = $filters['sort'];
            }

            $this->db_reader->order_by("ct.uid", $sort);
        }

        if (isset($filters['orderby']) && $filters['orderby'] == 'campaign') {
            $sort = '';
            if (isset($filters['sort']) && $filters['sort'] != '') {
                $sort = $filters['sort'];
            }

            $this->db_reader->order_by("ct.campaign_id", $sort);
        }


//,Date(ct.dateTime) as date
//        ct.clicktracker_id,
        $this->db_reader->select("$select", FALSE)->from("click_tracker ct");

        //$this->db_reader->group_by("ct.transaction_id");
        $this->db_reader->where("ct.valid", 1);
        $this->db_reader->limit(100, 0);
        $report = $this->db_reader->get()->result_array();
        // echo $this->db_reader->last_query();

        return $report;
    }

    private function group_by_return($group_by_array) {

        if (!isset($group_by_array['groupby']))
            return '';
        $group_by = '';
        $select = '';


        foreach ($group_by_array['groupby'] as $val) {

            if (isset($val) && $val == 'date') {
                //$this->db_reader->group_by("Date(ct.dateTime)");

                $group_by.="Date(ct.dateTime),";
                $select.= ",Date(ct.dateTime) as Date";
                //  $this->db_reader->group_by("ct.country");
            }





            if (isset($val) && $val == 'offer_id') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by.="ct.campaign_id,";
                $select.= ",ct.campaign_id as Offer_ID";
            }

            if (isset($val) && $val == 'aff_id') {
                // $this->db_reader->group_by("ct.campaign_id");
                $select.=",u.uid as Aff_id";
                $group_by.="u.uid,";
//                $group_by.=",u.uid";
            }
            if (isset($val) && $val == 'aff_name') {
                // $this->db_reader->group_by("ct.campaign_id");
                $select.=",u.name as Aff_Name";
                $group_by.="u.uid,";
            }

            if (isset($val) && $val == 'advertiser_id') {
                // $this->db_reader->group_by("ct.campaign_id");
                $select.=",advertiser.uid as Adv_ID";
                $group_by.="advertiser.uid,";
            }

            if (isset($val) && $val == 'country') {
                // $this->db_reader->group_by("ct.campaign_id");
                $select.=",ct.country as Country";
                $group_by.="ct.country,";
            }

            if (isset($val) && $val == 'advertiser') {
                // $this->db_reader->group_by("ct.campaign_id");
                $select.=",advertiser.name as Adv_Name";
                $group_by.="advertiser.uid,";
            }

            if (isset($val) && $val == 'offer') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by.="ct.campaign_id,";
                $select.=",cmp.campaign_name as Offer_Name ";
            }
            
               if (isset($val) && $val == 'url_id') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by.="ct.url_id,";
                $select.= ",ou.url_id as Url_ID";
            }
            if (isset($val) && $val == 'url_name') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by.="ct.url_id,";
                $select.=",ou.name as Url_Name ";
            }
            if (isset($val) && $val == 'refer_page') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by.="ct.reffer_page,";
                $select.=",ct.reffer_page as Referrer_Page ";
            }


            if (isset($val) && $val == 'hour') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by.="HOUR(ct.dateTime),";
                $select.= ",HOUR(ct.dateTime) as Hour";
            }

            if (isset($val) && $val == 'week') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by.="WEEK(ct.dateTime),";
                $select.= ",WEEK(ct.dateTime) as Week";
            }

            if (isset($val) && $val == 'month') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by.="MONTH(ct.dateTime),";
                $select.= ",MONTH(ct.dateTime) as Month";
            }

            if (isset($val) && $val == 'year') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by.="YEAR(ct.dateTime),";
                $select.= ",YEAR(ct.dateTime) as Year";
            }




            if (isset($val) && $val == 'uid') {
//                $this->db_reader->group_by("ct.uid");
                $group_by.="ct.uid,";
                $select.= ",ct.uid as aff_id";
            }

            if (isset($val) && $val == 'cpc') {
//                $this->db_reader->group_by("ct.uid");
                // $group_by.="ct.uid,";
                $select.= ",ROUND((sum(CASE WHEN trr.goal IS NOT NULL  THEN 1 ELSE 0 END) * ct.payout_cost )/count(ct.link_id) ,2) AS CPC";
            }

            if (isset($val) && $val == 'rpc') {
//                $this->db_reader->group_by("ct.uid");
                // $group_by.="ct.uid,";
                $select.= ",ROUND((sum(CASE WHEN trr.goal IS NOT NULL  THEN 1 ELSE 0 END) * cmp.revenue_cost)/count(ct.link_id) ,2) as RPC";
            }

            //
        }

        return array("select" => $select, "groupby" => $group_by);
    }

    public function getReport($filters = array()) {
        $report = array();
        $select = "";
        if (isset($filters['groupby']) && $filters['groupby'] == 'post') {
            $this->db_reader->group_by("ct.post_id");
            $select.=",p.*";
            $this->db_reader->join("posts p", "p.post_id=ct.post_id");
        }


        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db_reader->where("ct.uid", $filters['uid']);
        }

        if (isset($filters['startDate']) && $filters['startDate'] != '' && isset($filters['endDate']) && $filters['endDate'] != '') {
            $this->db_reader->where("ct.dateTime BETWEEN '{$filters['startDate']} 00:00:00' AND '{$filters['endDate']} 23:59:00'", NULL, FALSE);
        }

        $this->db_reader->select("sum(CASE WHEN ct.track_type=0 THEN 1 ELSE 0 END) as clicks ,ROUND(sum(CASE WHEN trr.goal >=0 THEN 1 ELSE 0 END) * ct.payout_cost ,2) as earn,Date(ct.dateTime) as date $select", FALSE)->from("click_tracker ct");
//        $this->db_reader->where("");
//        if (isset($filters['groupby']) && $filters['groupby'] == 'date') {
//            $countyGroup = "";
//            $countyGroup = isset($filters['country']) ? ",ct.country" : "";
//            $this->db_reader->group_by("Date(ct.dateTime)$countyGroup");
//            //  $this->db_reader->group_by("ct.country");
//        }
        //$this->db_reader->group_by("ct.date");

        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db_reader->group_by("ct.uid");
        }

        $this->db_reader->join("transactions trr", "trr.transaction_id=ct.transaction_id", "LEFT");

        $this->db_reader->order_by("Date(ct.dateTime)", "ASC");
        $this->db_reader->where("ct.valid", 1);


        $report = $this->db_reader->get()->result_array();
        //  echo $this->db_reader->last_query();

        return $report;
    }

    public function getgraphData($filters = array()) {
        $this->db_reader->select("count(cltr.link_id) as clicks,cltr.country,Date(cltr.dateTime) as date");
        $this->db_reader->from("click_tracker cltr");
        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db_reader->where("cltr.uid", $filters['uid']);
        }

        if (isset($filters['startDate']) && $filters['startDate'] != '' && isset($filters['endDate']) && $filters['endDate'] != '') {

            $this->db_reader->where("Date(cltr.dateTime) BETWEEN '{$filters['startDate']}' AND '{$filters['endDate']}'", NULL, FALSE);
        }
        $this->db_reader->where("cltr.valid", 1);
        $this->db_reader->group_by("Date(cltr.dateTime),cltr.country");
        $this->db_reader->order_by("Date(cltr.dateTime)", "ASC");

        $list = $this->db_reader->get()->result_array();

        //  echo $this->db_reader->last_query();
        return $list;
    }

    public function getstats($filters = array()) {

        //reports or stats for dashboradd widgits
        $report = array();
        $select = "";
        // $select.=",  count(ct.link_id) as Clicks ";
        $select.="  sum(CASE WHEN ct.track_type=0  THEN 1 ELSE 0 END) as Clicks ";
        $select.=",sum(CASE WHEN trr.goal=0 THEN 1 ELSE 0 END) as Conversion";
        $select.=",  sum(CASE WHEN ct.track_type=1 THEN 1 ELSE 0 END) as Impression ";
//        4 : CPA,
//        5 :CPC
//
        $select.=",ROUND(SUM(CASE ct.payout_type 
WHEN '4' THEN (CASE WHEN trr.goal=0 THEN 1 ELSE 0 END) * ct.payout_cost 
WHEN '5' THEN  ct.payout_cost
ELSE '0'
END),2) as Cost";
         $select.=", ROUND( (sum(CASE WHEN trr.goal=0 THEN 1 ELSE 0 END) / sum(CASE WHEN ct.track_type=0 THEN 1 ELSE 0 END)) * 100,2 ) as CR   ";
        //Payout
// that is earned by affiliate 
//ROUND(sum(ct.payout_cost),2) as Payout1 

//        $select.=",ROUND(SUM(CASE  ct.payout_type 
//WHEN '4' THEN (CASE WHEN trr.goal=0 THEN 1 ELSE 0 END) * cmp.revenue_cost
//WHEN '5' THEN cmp.revenue_cost
//ELSE '0'
//END ),2) as Revenue";

// pay to admin by advertiser
//ROUND((SELECT Revenu) - (SELECT Payout)  ,2)

//        $qry1 = "(CASE WHEN trr.goal=0 THEN 1 ELSE 0 END ) * ct.payout_cost";
//        $qry2 = "(CASE WHEN trr.goal=0 THEN 1 ELSE 0 END) * cmp.revenue_cost ";
//        $select.=",ROUND(SUM(CASE ct.payout_type 
//WHEN '4' THEN ($qry2 - $qry1)
//WHEN '5' THEN (cmp.revenue_cost) - (ct.payout_cost)
//ELSE '0'
//END),2) as Profit";
//      
        $this->db_reader->join("users u", "u.uid=ct.uid", "LEFT");
        $this->db_reader->join("campaign cmp", "ct.campaign_id=cmp.campaign_id");
        $this->db_reader->join("users advertiser", "advertiser.uid=cmp.advertiser_id", "LEFT");
        $this->db_reader->join("transactions trr", "ct.transaction_id=trr.transaction_id", "LEFT");

        if (isset($filters['startDate']) && $filters['startDate'] != '' && isset($filters['endDate']) && $filters['endDate'] != '') {
            $this->db_reader->where("ct.dateTime BETWEEN '{$filters['startDate']} 00:00:00' AND '{$filters['endDate']} 23:59:00'", NULL, FALSE);
        }




        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db_reader->where("ct.uid", $filters['uid']);
        }



//,Date(ct.dateTime) as date
//        ct.clicktracker_id,
        $this->db_reader->select("$select", FALSE)->from("click_tracker ct");

        //$this->db_reader->group_by("ct.transaction_id");
        $this->db_reader->where("ct.valid", 1);
        $report = $this->db_reader->get()->result_array();
        // echo $this->db_reader->last_query();

        return $report;
    }

}
