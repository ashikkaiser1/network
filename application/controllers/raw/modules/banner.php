<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of banner
 *
 * @author kuldeep
 */
class banner {

    //put your code here
    //put your code here
    public $CI;

    public function __construct(CI_Controller &$CI) {
        // parent::__construct();
        $this->CI = $CI;
        $this->CI->load->model("modules/m_banner", "m_banner");
    }

    public function index($bannerinfo = array()) {
    //    print_r($info);
        if (!empty($bannerinfo)) {
            $bannerinfo = $this->CI->m_banner->getBannerImages($bannerinfo['module_id']);
        }
        if(empty($bannerinfo))
            return '';

        return $this->CI->load->view("modules/banner", $bannerinfo, TRUE);
    }

}
