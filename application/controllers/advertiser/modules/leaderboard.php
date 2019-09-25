<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of leaderboard
 *
 * @author NexGen
 */
class leaderboard  {
    //put your code here
    public function __construct($CI) {
         $this->CI = $CI;
    }
    
    public function index() {
        
        return $this->CI->load->view("advertiser/modules/leaderboard/v-leaderboard",null,TRUE);
        ///return "Leader Borad";
    }
    
    public function getTopEarners() {
        $this->CI->load->model("advertiser/modules/m_leaderboard");
        $filters = array();
        $filters['groupby'] ="uid";
        $filters['limit'] =9;
        $data['topEarner'] = $this->CI->m_leaderboard->getTopEarners($filters);
        
        echo json_encode($data);
    }
}
