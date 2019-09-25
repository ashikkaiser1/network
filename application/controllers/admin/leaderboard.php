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
class leaderboard extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
//check the login for user
        $this->load->library("common/com"); $this->com->is_admin();
    }

    public function getTopEarners() {
        $this->load->model("admin/m_leaderboard");
        $filters = array();
        $filters['groupby'] = "uid";
        $filters['limit'] = 10;
        $data['topEarner'] = $this->m_leaderboard->getTopEarners($filters);

        echo json_encode($data);
    }

    public function getTopAdvertisers() {
        $this->load->model("admin/m_leaderboard");
        $filters = array();
        $filters['groupby'] = "advertiser_id";
        $filters['limit'] = 10;
        $data['topAdver'] = $this->m_leaderboard->getTopAdvertisers($filters);

        echo json_encode($data);
    }

}
