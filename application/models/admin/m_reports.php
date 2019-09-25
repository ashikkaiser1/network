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
    private $clickFormula = '';

    public function __construct() {
        parent::__construct();

        $this->db_reader = $this->load->database("db_reader", TRUE);
        $this->clickFormula = "sum(CASE WHEN (ct.track_type=0 and ct.valid=1 and (trr.goal=0 or trr.goal IS NULL)) THEN 1 ELSE 0 END)";
    }

    public function getAdvanceReport($filters = array()) {
        $report = array();
        $select = "";

        // print_r($filters);
//        $select.=",p.post_id";
//        $this->db_reader->join("posts p", "p.post_id=ct.post_id");
//return group elements and extra select elemens;
        $col_group_by = $this->group_by_return($filters);
        $select .= isset($col_group_by['select']) ? $col_group_by['select'] :'';
        if(isset($col_group_by['groupby']))
            $this->db_reader->group_by($col_group_by['groupby']);


        //please chnage groupby to select in futre
        if (isset($filters['groupby']['payout_type'])) {
            $select .= ",ptyp.name as Pay_Type";
        }

        if (isset($filters['groupby']['revenue_type'])) {
            $select .= ",ptyp_rev.name as Revenue_Type";
        }

//        if (isset($col_group_by['groupby']['payout_type'])) {
//            $select.=",ptyp.name as Pay_Type";
//        }
        if (isset($filters['groupby']['cpa'])) {
            $select .= ",ct.payout_cost as CPA";
        }
//        $select.=",ct.payout_cost as Pay_out";
        if (isset($filters['groupby']['rpa'])) {
            $select .= ",cmp.revenue_cost as RPA";
        }


        //

        $convesFormula = "sum(CASE WHEN trr.goal=0 and trr.c_valid=1 THEN 1 ELSE 0 END)";

        if (!(isset($filters['goal_id']) || isset($filters['goal_name'])))
            $convesFormula = "sum(CASE WHEN trr.goal >=0 and trr.c_valid=1 THEN 1 ELSE 0 END)";


        //
        //end
        // $select.=",cmp.revenue_cost as Revenue_Cost";
        $this->db_reader->join("transactions trr", "ct.transaction_id=trr.transaction_id","LEFT");
        $this->db_reader->join("campaign cmp", "ct.campaign_id=cmp.campaign_id");
        
        $this->db_reader->join("offer_goal offg", "offg.offer_goal_id=trr.goal", "LEFT");
        $this->db_reader->join("pay_type ptyp", "ptyp.pay_type_id=ct.payout_type","LEFT");
        $this->db_reader->join("offer_urls ou", "ou.url_id=ct.url_id", "LEFT");
        
        $this->db_reader->join("device_master dm", "ct.device_id=dm.device_id","LEFT");
        $this->db_reader->join("os_master osm", "ct.os_name=osm.os_name","LEFT");
        
        $this->db_reader->join("pay_type ptyp_rev", "ptyp_rev.pay_type_id = cmp.revenue_type");
        $this->db_reader->join("users u", "u.uid=ct.uid");
        $this->db_reader->join("users advertiser", "advertiser.uid=cmp.advertiser_id","LEFT");


        if (isset($filters['select']['clicks'])) {
            $select .= ",  $this->clickFormula as Clicks ";
        }

        // $select.=",  count(ct.link_id) as Clicks ";
        if (isset($filters['select']['conversion'])) {
            $select .= ", $convesFormula as Conversion";
        }
        if (isset($filters['select']['CR'])) {
            $select .= ", ROUND( ($convesFormula / $this->clickFormula) * 100,2 ) as CR   ";
        }
        if (isset($filters['select']['impression'])) {
            $select .= ",  sum(CASE WHEN ct.track_type=1 THEN 1 ELSE 0 END) as Impression ";
        }
//  }
        //$this->db_reader->join("transactions tr", "tr.transaction_id=ct.transaction_id");
//        if (isset($filters['goals'])) {
//
//            //$this->db_reader->join("offer_goal offg","offg.offer_goal_id=trr.goal","LEFT");
//            //print_r($filters['goals']);
//            if (!empty($filters['goals'])) {
//                foreach ($filters['goals'] as $key => $goal) {
//                    $select.=" , sum(CASE WHEN trr.goal=offg.offer_goal_id and offg.goal_id = {$goal} THEN 1 ELSE 0 END) as $key";
//                }
//            }
//        }
//        4 : CPA,
//        5 :CPC
        //When '5' sum clicks 
        //*ct.payout_cost
        $cost = '';
        if (isset($filters['groupby']['goal_id']) || isset($filters['groupby']['goal_name'])) {
            $cost = "CASE  
                WHEN ( (ct.payout_type =4 OR ct.payout_type=8 OR ct.payout_type=11 OR ct.payout_type=12) AND trr.goal=0)  THEN ROUND(sum(CASE WHEN trr.goal=0 AND trr.c_valid=1 THEN 1 ELSE 0 END) * ct.payout_cost ,2)
                WHEN ((ct.payout_type =4 OR ct.payout_type=8 OR ct.payout_type=11 OR ct.payout_type=12) AND trr.goal>0)  THEN ROUND(sum(CASE WHEN trr.goal>0 AND trr.c_valid=1 THEN 1 ELSE 0 END) * offg.payout_cost ,2)
                WHEN ct.payout_type=5 THEN ROUND($this->clickFormula *ct.payout_cost,2)
                ELSE '0'
                END";
            if (isset($filters['select']['cost'])) {
                $select .= "," . $cost . " as Cost";
            }
            //Payout 
        } elseif (!isset($filters['groupby']['goal_id']) || isset($filters['groupby']['goal_name'])) {
            $cost = "CASE  
                WHEN ((ct.payout_type =4 OR ct.payout_type=8 OR ct.payout_type=11 OR ct.payout_type=12) OR offg.payout_type=4)  THEN ROUND(sum(CASE WHEN trr.goal =0 AND trr.c_valid=1 THEN ct.payout_cost WHEN trr.goal > 0 AND trr.c_valid=1 THEN offg.payout_cost  ELSE 0 END) ,2)
                WHEN ct.payout_type=5 THEN ROUND($this->clickFormula *ct.payout_cost,2)
                ELSE '0'
                END";
            if (isset($filters['select']['cost'])) {
                $select .= "," . $cost . " as Cost";
            }
        }

// that is earned by affiliate 
//ROUND(sum(ct.payout_cost),2) as Payout1 
        //When 5 sum clicks 
        $revenue = "";
        if (isset($filters['groupby']['goal_id']) || isset($filters['groupby']['goal_name'])) {
            $revenue = "CASE  
                WHEN ((cmp.revenue_type=1 OR cmp.revenue_type=7 OR cmp.revenue_type=9 OR cmp.revenue_type=10) AND trr.goal=0)  THEN ROUND(sum(CASE WHEN trr.goal=0 AND trr.c_valid=1 THEN 1 ELSE 0 END) * cmp.revenue_cost ,2)
                WHEN ((cmp.revenue_type=1 OR cmp.revenue_type=7 OR cmp.revenue_type=9 OR cmp.revenue_type=10) AND trr.goal>0)  THEN ROUND(sum(CASE WHEN trr.goal>0 AND trr.c_valid=1 THEN 1 ELSE 0 END) * offg.revenue_cost ,2)
                WHEN cmp.revenue_type =2 THEN ROUND($this->clickFormula *cmp.revenue_cost,2)
                ELSE '0'
                END";
            if (isset($filters['select']['revenue'])) {
                $select .= "," . $revenue . " as Revenue";
            }
            //revenue
        } elseif (!isset($filters['groupby']['goal_id']) || isset($filters['groupby']['goal_name'])) {
            $revenue = "CASE  
                WHEN ((cmp.revenue_type=1 OR cmp.revenue_type=7 OR cmp.revenue_type=9 OR cmp.revenue_type=10) OR offg.revenue_type=1)  THEN ROUND(sum(CASE WHEN trr.goal =0 AND trr.c_valid=1 THEN cmp.revenue_cost WHEN trr.goal > 0 AND trr.c_valid=1 THEN offg.revenue_cost  ELSE 0 END) ,2)
                WHEN cmp.revenue_type=2 THEN ROUND($this->clickFormula *cmp.revenue_cost,2)
                ELSE '0'
                END";
            if (isset($filters['select']['revenue'])) {
                $select .= "," . $revenue . " as Revenue";
            }
        }

// pay to admin by advertiser
//ROUND((SELECT Revenu) - (SELECT Payout)  ,2)
        //clicks sums
        if (isset($filters['select']['profit'])) {
            $select .= " , ROUND($revenue - $cost,2) as Profit ";
        }


        //if (isset($filters['goals'])) {
        //}
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
            $this->db_reader->where("ct.dateTime BETWEEN '{$filters['startDate']} 00:00:00' AND '{$filters['endDate']} 23:59:59'", NULL, FALSE);
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

        if (isset($filters['orderby']) && $filters['orderby'] == 'conversion') {
            $sort = '';
            if (isset($filters['sort']) && $filters['sort'] != '') {
                $sort = $filters['sort'];
            }
            //sort by Conversion high to low DESC;
            $this->db_reader->order_by("Conversion", $sort);
        }





//,Date(ct.dateTime) as date
//        ct.clicktracker_id,
        $this->db_reader->select("$select", FALSE)->from("click_tracker ct");

//        $this->db_reader->group_by("ct.transaction_id");
        $this->db_reader->where("ct.valid", 1);

        if (isset($filters['limit']) && $filters['limit'] != '') {
            //code not use yet
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db_reader->limit(10, (int) $filters['limit']);
        } else {
             if (isset($filters['all']) && $filters['all'] != '')
             {
                 
             }else
             {
                 $this->db_reader->limit(100, 0);
             }
            
        }

        $report = $this->db_reader->get()->result_array();
//        echo $this->db_reader->last_query();

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

                $group_by .= "Date(ct.dateTime),";
                $select .= ",Date(ct.dateTime) as Date";
                //  $this->db_reader->group_by("ct.country");
            }





            if (isset($val) && $val == 'offer_id') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by .= "ct.campaign_id,";
                $select .= ",ct.campaign_id as Offer_ID";
            }

            if (isset($val) && $val == 'aff_id') {
                // $this->db_reader->group_by("ct.campaign_id");
                $select .= ",u.uid as Aff_id";
                $group_by .= "u.uid,";
//                $group_by.=",u.uid";
            }
            if (isset($val) && $val == 'aff_name') {
                // $this->db_reader->group_by("ct.campaign_id");
                $select .= ",u.uid as RR_Aff_id";
                $select .= ",u.name as Aff_Name";
                $group_by .= "u.uid,";
            }

            if (isset($val) && $val == 'advertiser_id') {
                // $this->db_reader->group_by("ct.campaign_id");
                $select .= ",advertiser.uid as Adv_ID";
                $group_by .= "advertiser.uid,";
            }

            if (isset($val) && $val == 'country') {
                // $this->db_reader->group_by("ct.campaign_id");
                $select .= ",ct.country as Country";
                $group_by .= "ct.country,";
            }
           
             if (isset($val) && $val == 'device') {
                // $this->db_reader->group_by("ct.campaign_id");
                $select .= ",dm.name as Device";
                $group_by .= "ct.device_id,";
            }
            
            if (isset($val) && $val == 'platform') {
                // $this->db_reader->group_by("ct.campaign_id");
                $select .= ",osm.os_fullname as Platform";
                $group_by .= "ct.os_name,";
            }

            if (isset($val) && $val == 'advertiser') {
                // $this->db_reader->group_by("ct.campaign_id");
                $select .= ",advertiser.name as Adv_Name";
                $group_by .= "advertiser.uid,";
            }

            if (isset($val) && $val == 'offer') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by .= "ct.campaign_id,";
                $select .= ",ct.campaign_id as RR_Offer_ID";
                $select .= ",cmp.campaign_name as Offer_Name ";
            }

            if (isset($val) && $val == 'url_id') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by .= "ct.url_id,";
                $select .= ",ou.url_id as Url_ID";
            }
            if (isset($val) && $val == 'url_name') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by .= "ct.url_id,";
                $select .= ",ou.name as Url_Name ";
            }
            if (isset($val) && $val == 'refer_page') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by .= "ct.reffer_page,";
                $select .= ",ct.reffer_page as Referrer_Page ";
            }
             if (isset($val) && $val == 'aff_sub') {
                 // $this->db_reader->group_by("ct.subid");
                $select .= ",ct.aff_sub as aff_sub";
                $group_by .= "ct.aff_sub,";
            }
            if (isset($val) && $val == 'aff_sub2') {
                 // $this->db_reader->group_by("ct.subid");
                $select .= ",ct.aff_sub2 as aff_sub2";
                $group_by .= "ct.aff_sub2,";
            }
             if (isset($val) && $val == 'aff_sub3') {
                 // $this->db_reader->group_by("ct.subid");
                $select .= ",ct.aff_sub3 as aff_sub3";
                $group_by .= "ct.aff_sub3,";
            }
            if (isset($val) && $val == 'subid1') {
                 // $this->db_reader->group_by("ct.subid");
                $select .= ",ct.subid as aff_sub2";
                $group_by .= "ct.subid,";
            }
            if (isset($val) && $val == 'goal_id') {
                //sum(CASE WHEN trr.goal=offg.offer_goal_id and offg.goal_id = {$goal} THEN 1 ELSE 0 END)
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by .= "trr.goal,";
                $select .= ",trr.goal as Goal_ID ";
            }
            if (isset($val) && $val == 'goal_name') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by .= "trr.goal,";
                $select .= ",offg.name as Goal_Name ";
                // . "sum(CASE WHEN trr.goal=offg.offer_goal_id and offg.campaign_id = ct.campaign_id THEN 1 ELSE 0 END) as Total_Unit";
            }


            if (isset($val) && $val == 'hour') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by .= "HOUR(ct.dateTime),";
                $select .= ",HOUR(ct.dateTime) as Hour";
            }

            if (isset($val) && $val == 'week') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by .= "WEEK(ct.dateTime),";
                $select .= ",WEEK(ct.dateTime) as Week";
            }

            if (isset($val) && $val == 'month') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by .= "MONTH(ct.dateTime),";
                $select .= ",MONTH(ct.dateTime) as Month";
            }

            if (isset($val) && $val == 'year') {
                // $this->db_reader->group_by("ct.campaign_id");
                $group_by .= "YEAR(ct.dateTime),";
                $select .= ",YEAR(ct.dateTime) as Year";
            }




            if (isset($val) && $val == 'uid') {
//                $this->db_reader->group_by("ct.uid");
                $group_by .= "ct.uid,";
                $select .= ",ct.uid as aff_id";
            }

            if (isset($val) && $val == 'cpc') {
//                $this->db_reader->group_by("ct.uid");
                // $group_by.="ct.uid,";
                $select .= ",ROUND((sum(CASE WHEN trr.goal IS NOT NULL  THEN ";
                $select .= " (CASE WHEN trr.goal =0 AND trr.c_valid=1 THEN ct.payout_cost  WHEN trr.goal > 0 AND trr.c_valid=1 THEN offg.payout_cost ELSE 0 END ) ELSE 0 END) )/($this->clickFormula) ,2) AS CPC";
            }

            if (isset($val) && $val == 'rpc') {
//                $this->db_reader->group_by("ct.uid");
                // $group_by.="ct.uid,";
                $select .= ",ROUND((sum(CASE WHEN trr.goal IS NOT NULL  THEN ";
                $select .= " (CASE WHEN trr.goal =0 AND trr.c_valid=1 THEN cmp.revenue_cost  WHEN trr.goal > 0 AND trr.c_valid=1 THEN offg.revenue_cost ELSE 0 END ) ELSE 0 END))/($this->clickFormula) ,2) as RPC";
            }

            //
        }

        return array("select" => $select, "groupby" => $group_by);
    }

    public function getReport($filters = array()) {
        $report = array();
        $select = "";
//        if (isset($filters['groupby']) && $filters['groupby'] == 'post') {
//            $this->db_reader->group_by("ct.post_id");
//            $select.=",p.*";
//            $this->db_reader->join("posts p", "p.post_id=ct.post_id");
//        }


        if (isset($filters['uid']) && $filters['uid'] != '') {
            $this->db_reader->where("ct.uid", $filters['uid']);
        }

        if (isset($filters['startDate']) && $filters['startDate'] != '' && isset($filters['endDate']) && $filters['endDate'] != '') {
            $this->db_reader->where("ct.dateTime BETWEEN '{$filters['startDate']} 00:00:00' AND '{$filters['endDate']} 23:59:59'", NULL, FALSE);
        }

        
         $qry1 = "(CASE WHEN trr.goal>=0 AND trr.c_valid=1 THEN 1 ELSE 0 END ) * ct.payout_cost";
        $qry2 = "(CASE WHEN trr.goal >=0 AND trr.c_valid=1 THEN 1 ELSE 0 END) * cmp.revenue_cost ";
        $select .= ",ROUND(SUM(CASE  
WHEN (ct.payout_type =4 OR ct.payout_type=8 OR ct.payout_type=11 OR ct.payout_type=12) THEN ($qry2 - $qry1)
WHEN ct.payout_type=5 THEN (cmp.revenue_cost) - (ct.payout_cost)
ELSE '0'
END),2) as earn";
        
        $this->db_reader->select($select,false);
//        $this->db_reader->select("sum(CASE WHEN (ct.track_type=0 and ct.valid=1 and (trr.goal=0 or trr.goal IS NULL)) THEN 1 ELSE 0 END) as clicks ,ROUND((sum(CASE WHEN trr.goal >=0 THEN 1 ELSE 0 END) *cmp.revenue_cost) - (sum(CASE WHEN trr.goal >=0 THEN 1 ELSE 0 END) * ct.payout_cost) ,2)   as earn,Date(ct.dateTime) as date $select", FALSE)->from("click_tracker ct");
        $this->db_reader->from("click_tracker ct");
        $this->db_reader->join("campaign cmp", "cmp.campaign_id=ct.campaign_id", "LEFT");

//        $this->db_reader->where("");
//        if (isset($filters['groupby']) && $filters['groupby'] == 'date') {
//            $countyGroup = "";
//            $countyGroup = isset($filters['country']) ? ",ct.country" : "";
//            $this->db_reader->group_by("Date(ct.dateTime)$countyGroup");
//            //  $this->db_reader->group_by("ct.country");
//        }
        //$this->db_reader->group_by("ct.date");
        //  if (isset($filters['uid']) && $filters['uid'] != '') {
        //     $this->db_reader->group_by("ct.uid");
        // }

        $this->db_reader->join("transactions trr", "trr.transaction_id=ct.transaction_id", "LEFT");

        $this->db_reader->order_by("Date(ct.dateTime)", "ASC");
        $this->db_reader->where("ct.valid", 1);


        $report = $this->db_reader->get()->result_array();
//          echo $this->db_reader->last_query();

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

    public function getTotalClicks($filters = array()) {
        //depriciated
        $this->db_reader->select("sum(CASE WHEN (ct.track_type=0 and (trr.goal=0 or trr.goal IS NULL)) THEN 1 ELSE 0 END) as clicks");
        $this->db_reader->from("click_tracker ct");
        $this->db_reader->where("valid", 1);
        return $this->db_reader->get()->row_array();
    }

    public function getTotalVisitors($filters = array()) {
        $this->db_reader->select("count(Distinct ip_address) as visitors");
        $this->db_reader->from("click_tracker");
//        $this->db_reader->group_by("ip_address");
        return $this->db_reader->get()->row_array();
    }

    public function getTotalUsers($filters = array()) {
        $this->db_reader->select("count(case when status= 1 then 1 end) as active_user,count(case when status= 0 then 1 end) as deactive_user");
        $this->db_reader->from("users");
        return $this->db_reader->get()->row_array();
    }

    public function getTotalCampaign($filters = array()) {
        $this->db_reader->select("count(case when status= 1 then 1 end) as active_camp,count(case when status= 0 then 1 end) as deactive_camp");
        $this->db_reader->from("campaign");
        return $this->db_reader->get()->row_array();
    }

//    public function getstats($filters = array()) {
//        $report = array();
//        $select = "";
//        // $select.=",  count(ct.link_id) as Clicks ";
//        $select .= "  sum(CASE WHEN (ct.track_type=0 and (trr.goal=0 or trr.goal IS NULL))  THEN 1 ELSE 0 END) as Clicks ";
//        $select .= ",sum(CASE WHEN trr.goal=0 and trr.c_valid=1 THEN 1 ELSE 0 END) as Conversion";
//        $select .= ",  sum(CASE WHEN ct.track_type=1 THEN 1 ELSE 0 END) as Impression ";
////        4 : CPA,
////        5 :CPC
////
//        $select .= ",ROUND(SUM(CASE ct.payout_type 
//WHEN '4' THEN (CASE WHEN trr.goal=0 THEN 1 ELSE 0 END) * ct.payout_cost 
//WHEN '5' THEN  ct.payout_cost
//ELSE '0'
//END),2) as Cost";
//        //Payout
//// that is earned by affiliate 
////ROUND(sum(ct.payout_cost),2) as Payout1 
//
//        $select .= ",ROUND(SUM(CASE  ct.payout_type 
//WHEN '4' THEN (CASE WHEN trr.goal=0 THEN 1 ELSE 0 END) * cmp.revenue_cost
//WHEN '5' THEN cmp.revenue_cost
//ELSE '0'
//END ),2) as Revenue";
//
//// pay to admin by advertiser
////ROUND((SELECT Revenu) - (SELECT Payout)  ,2)
//
//        $qry1 = "(CASE WHEN trr.goal=0 THEN 1 ELSE 0 END ) * ct.payout_cost";
//        $qry2 = "(CASE WHEN trr.goal=0 THEN 1 ELSE 0 END) * cmp.revenue_cost ";
//        $select .= ",ROUND(SUM(CASE ct.payout_type 
//WHEN '4' THEN ($qry2 - $qry1)
//WHEN '5' THEN (cmp.revenue_cost) - (ct.payout_cost)
//ELSE '0'
//END),2) as Profit";
////
//       
//        $this->db_reader->join("campaign cmp", "ct.campaign_id=cmp.campaign_id");
//         $this->db_reader->join("transactions trr", "ct.transaction_id=trr.transaction_id");
//         $this->db_reader->join("users u", "u.uid=ct.uid");
//        $this->db_reader->join("users advertiser", "advertiser.uid=cmp.advertiser_id");
//       
//
//        if (isset($filters['startDate']) && $filters['startDate'] != '' && isset($filters['endDate']) && $filters['endDate'] != '') {
//            $this->db_reader->where("ct.dateTime BETWEEN '{$filters['startDate']} 00:00:00' AND '{$filters['endDate']} 23:59:59'", NULL, FALSE);
//        }
//
//
//
//
//
//
////,Date(ct.dateTime) as date
////        ct.clicktracker_id,
//        $this->db_reader->select("$select", FALSE)->from("click_tracker ct");
//
//        //$this->db_reader->group_by("ct.transaction_id");
//        $this->db_reader->where("ct.valid", 1);
//        $report = $this->db_reader->get()->result_array();
//        // echo $this->db_reader->last_query();
//
//        return $report;
//    }

}
