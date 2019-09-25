<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of notify_mngr
 *
 * @author sandeep yadav    
 */
class notify_mngr extends CI_Controller  {
    
    public function __construct() {
        parent::__construct();

        $this->load->library("common/common");

        $this->load->helper("url");
        $this->load->helper('form');
        $this->load->model("publisher/utility", "util_model");
    }
    
    public function index() {
        
        $data['page_content'] = $this->load->view("admin/notification/analytics/v-graph", $data, TRUE);
        $this->load->view("admin/templete", $data);
    }
}
