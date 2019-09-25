<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_pay_type
 *
 * @author NexGen
 */
class m_pay_type extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function getPayType($filters = array()) {

        $this->db->select("*")->from("pay_type");
        if (isset($filters['type']) && $filters['type'])
            $this->db->where("type", $filters['type']);
        
        $this->db->order_by("sort","ASC");
        $list = $this->db->get()->result_array();
       // echo $this->db->last_query();

        if (isset($filters['formated']) && $filters['formated']) {
            $selectList = array();
            if (!empty($list)) {
                foreach ($list as $row) {

//                    $selectList[$row['pay_type_id']] = $row['desciption'] . "(" . $row['name'] . ")";
                    $selectList[$row['pay_type_id']] = $row['title'];
                }
            }

            return $selectList;
        }
        
        
        
        if (isset($filters['formated_api']) && $filters['formated_api']) {
            $selectList = array();
            if (!empty($list)) {
                foreach ($list as $row) {
                    $selectList[$row['name']] = $row['pay_type_id'];
                }
            }

            return $selectList;
        }
        


        return $list;
    }

}
