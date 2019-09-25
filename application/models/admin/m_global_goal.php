<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_global_goal
 *
 * @author NexGen
 */
class m_global_goal extends CI_Model {

    //put your code here

    public function __construct() {
        parent::__construct();
    }

    public function getGoals($filters = array()) {

        $this->db->select("*")->from("global_goal");
        $global_goal = $this->db->get()->result_array();

        $list = array();
        if (isset($filters['Formated'])) {
            if (!empty($global_goal)) {
                foreach ($global_goal as $row) {

                    $list[$row['goal_id']] = $row['name'];
                }
            }

            return $list;
        }

        return $global_goal;
    }

}
