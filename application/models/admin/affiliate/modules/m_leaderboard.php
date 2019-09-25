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
    public function __construct() {
        parent::__construct();
    }

    public function getTopEarners($filters = array()) {

        $report = array();
        if (isset($filters['startDate']) && $filters['startDate'] != '' && isset($filters['endDate']) && $filters['endDate'] != '') {
            $this->db->where("Date(ct.dateTime) BETWEEN '{$filters['startDate']}' AND '{$filters['endDate']}'", NULL, FALSE);
        }

        $this->db->select("sum(ct.payout_cost) as earn")->from("click_tracker ct");
        if (isset($filters['groupby']) && $filters['groupby'] == 'uid') {

            $this->db->group_by("ct.uid");
        }
        
          if (isset($filters['limit']) && $filters['limit'] != '') {

            $this->db->limit(10);
        }
       // $this->db->having('sum(ct.payout_cost) >20', NULL, FALSE);
        //$this->db->where("earn <","50");
        
        $this->db->order_by("earn", "DESC");
        $report = $this->db->get()->result_array();
        //echo $this->db->last_query();
        $list = array();


        foreach ($report as $row) {

            $list[] = array("earn" => round($row['earn'], 2));
        }
        return $list;
    }

}
