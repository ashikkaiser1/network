<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_leaderboard
 *
 * @author NexGen
 */
class m_leaderboard extends CI_Model {

    //put your code here
    private $db_reader;

    public function __construct() {
        parent::__construct();
        $this->db_reader = $this->load->database("db_reader", TRUE);
    }

    public function getTopEarners($filters = array()) {

        $report = array();
        if (isset($filters['startDate']) && $filters['startDate'] != '' && isset($filters['endDate']) && $filters['endDate'] != '') {
            $this->db_reader->where("ct.dateTime BETWEEN '{$filters['startDate']} 00:00:00' AND '{$filters['endDate']} 23:59:00'", NULL, FALSE);
        } 

        $this->db_reader->select("u.name,u.uid,sum(CASE WHEN trr.goal >=0 THEN ct.payout_cost ELSE 0 END) as earn")->from("click_tracker ct");

        $this->db_reader->join("users u", "u.uid=ct.uid", "LEFT");


        if (isset($filters['groupby']) && $filters['groupby'] == 'uid') {

            $this->db_reader->group_by("ct.uid");
        }

        $this->db_reader->join("transactions trr", "trr.transaction_id=ct.transaction_id", "LEFT");
        if (isset($filters['limit']) && $filters['limit'] != '') {

            $this->db_reader->limit(10);
        }
        // $this->db_reader->having('sum(ct.payout_cost) >20', NULL, FALSE);
        //$this->db_reader->where("earn <","50");

        $this->db_reader->order_by("earn", "DESC");
         $this->db_reader->where("ct.valid", 1);
        $report = $this->db_reader->get()->result_array();
        //echo $this->db_reader->last_query();
        $list = array();


        foreach ($report as $row) {

            $list[] = array("earn" => round($row['earn'], 2),
                "name" => $row['name'],
                "uid" => $row['uid']);
        }
        return $list;
    }
    
     public function getTopAdvertisers($filters = array()) {

        $report = array();
        if (isset($filters['startDate']) && $filters['startDate'] != '' && isset($filters['endDate']) && $filters['endDate'] != '') {
            $this->db_reader->where("ct.dateTime BETWEEN '{$filters['startDate']} 00:00:00' AND '{$filters['endDate']} 23:59:00'", NULL, FALSE);
        }

        $this->db_reader->select("u.name,u.uid,sum(CASE WHEN trr.goal >=0 THEN 1 ELSE 0 END)* cmp.revenue_cost as earn")->from("click_tracker ct");

        $this->db_reader->join("campaign cmp","cmp.campaign_id=ct.campaign_id","LEFT");
        $this->db_reader->join("users u", "u.uid=cmp.advertiser_id", "LEFT");


        if (isset($filters['groupby']) && $filters['groupby'] == 'advertiser_id') {

            $this->db_reader->group_by("cmp.advertiser_id");
        }

        $this->db_reader->join("transactions trr", "trr.transaction_id=ct.transaction_id", "LEFT");
        if (isset($filters['limit']) && $filters['limit'] != '') {

            $this->db_reader->limit(10);
        }
        // $this->db_reader->having('sum(ct.payout_cost) >20', NULL, FALSE);
        //$this->db_reader->where("earn <","50");

        $this->db_reader->order_by("earn", "DESC");
        $this->db_reader->where("ct.valid", 1);
        $report = $this->db_reader->get()->result_array();
        //echo $this->db_reader->last_query();
        $list = array();


        foreach ($report as $row) {

            $list[] = array("earn" => round($row['earn'], 2),
                "name" => $row['name'],
                "uid" => $row['uid']);
        }
        return $list;
    }

}
