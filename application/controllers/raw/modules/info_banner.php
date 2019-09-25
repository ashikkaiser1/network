<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of info_banner
 *
 * @author kuldeep
 */
class info_banner {
   //put your code here
    //put your code here
    public $CI;
    public function __construct(CI_Controller &$CI) {
       // parent::__construct();
        $this->CI=$CI;
         $this->CI->load->model("modules/m_info_banner", "m_info_banner");
    }
    
    public function index($info_banner=array()) {
        
         if (!empty($info_banner)) {
            $info_banner = $this->CI->m_info_banner->getInfoBanner($info_banner['module_id']);
        }
        if(empty($info_banner))
            return '';
        
        return $this->CI->load->view("modules/info_banner",$info_banner,TRUE);
    }
}
