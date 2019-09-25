<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_country
 *
 * @author kuldeep
 */
class m_country extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function getCountry($filters = array()) {


        $this->db->select("*")->from("country");
        if (isset($filters['isos']) && is_array($filters['isos'])) {
            $this->db->where_in("iso", $filters['isos']);
        }
        
        

        $result = $this->db->get()->result_array();

         if (isset($filters['list']) && $filters['list'] == 'iso') {
            $country = array();
            if (!empty($result)) {
                foreach ($result as $row) {
                    $country[$row['iso']] = $row['id'];
                }
            }
            return $country;
        }
        
        if (isset($filters['list']) && $filters['list'] == 'True') {
            $country = array();
            if (!empty($result)) {
                foreach ($result as $row) {

                    $country[$row['id']] = "(" . $row['iso'] . ") " . $row['nicename'];
                }
            }
            return $country;
        }

        return $result;
    }

}
