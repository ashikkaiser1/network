<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gateway
 *
 * @author NexGen
 */
class gateway extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();

        //check the login for user
        $this->load->library("common/com"); $this->com->is_affiliate();
    }

    public function index($call = '') {

        switch ($call) {
            case "topearner": $this->load_controller("affiliate/modules/leaderboard", "getTopEarners");
                break;
            case "setGlobalpostback": $this->load_controller("affiliate/modules/globalpostback", "setGlobalPostBack");
                break;

            default:
                break;
        }
    }

}
