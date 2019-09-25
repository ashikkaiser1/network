<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of footer
 *
 * @author kuldeep
 */
class footer {
    public $CI;
    public function __construct(CI_Controller &$CI) {
       // parent::__construct();
        $this->CI=$CI;
        $this->CI->load->model('modules/m_pages');
    }
    
    public function index($moduleInfo=array()) {
        
        $data['moduleInfo'] = $moduleInfo;
        
        $data['logo'] = $this->CI->config->item('logo');
        $data['category'] = $this->CI->config->item('category');
        
        $menus = $this->CI->m_pages->get_footer_menus(STORE_ID);
        
        $data['footer_menus'] = array_chunk($menus, 3);
        $data['social_media'] = unserialize(SOCIAL_MEDIA);
        
        //echo "<pre>"; print_r($data['footer_menus']); die();
        
        return $this->CI->load->view("modules/footer",$data,TRUE);
    }
}
