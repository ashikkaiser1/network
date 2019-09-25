<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_goals
 *
 * @author NexGen
 */
class m_goals extends CI_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function CreateOffer($goals = array()) {
        $this->db->insert("offer_goal", $goals);
        return $this->db->insert_id();
    }

    public function getGoals($filter = array()) {

        $this->db->select("og.*,payt_pot.name as payOutTypeName ,paytr.name as RevenueTypeName")->from("offer_goal og");
        $this->db->join("pay_type payt_pot ", "og.payout_type = payt_pot.pay_type_id ", "LEFT");
        $this->db->join("pay_type paytr", "og.revenue_type=paytr.pay_type_id ", "LEFT");
        if (isset($filter['campaign_id']) && $filter['campaign_id'] != '') {
            $this->db->where("og.campaign_id", $filter['campaign_id']);
        }
        if (isset($filter['offer_goal_id']) && $filter['offer_goal_id'] != '') {
            $this->db->where("og.offer_goal_id", $filter['offer_goal_id']);
            return $this->db->get()->row_array();
            
        }
        
        $this->db->order_by("offer_goal_id","DESC");

        $offer_goals = $this->db->get()->result_array();
        return $offer_goals;
    }

    public function deleteGoals($filter = array()) {

        $this->db->where("offer_goal_id", $filter['offer_goal_id']);
        $this->db->delete("offer_goal");
        return $this->db->affected_rows();
    }

    public function UpdateGoals($goal = array(), $offer_goal_id = 0) {

        $this->db->where("offer_goal_id", $offer_goal_id);
        $this->db->update("offer_goal", $goal);
        return $this->db->affected_rows();
    }

    //global goals

    public function getGlobalGoals($filter = array()) {

        $this->db->select("*")->from("global_goal");
        if (isset($filter['status']) && $filter['status'] != '')
            $this->db->where("status", $filter['status']);
        if (isset($filter['Formated']) && $filter['Formated'] != '') {

            $globalGoal = $this->db->get()->result_array();
            $list = array();

            if (!empty($globalGoal)) {
                foreach ($globalGoal as $goal) {
                    $list[$goal['goal_id']] = $goal['name'];
                }
            }

            return $list;
        }
    }

}
