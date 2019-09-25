<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of seo
 *
 * @author kuldeep
 */
class seo {
        //put your code here
    //put your code here
    public $CI;

    public function __construct(CI_Controller &$CI) {
        // parent::__construct();
        $this->CI = $CI;
        $this->CI->load->model("modules/m_seo", "m_seo");
    }
    public function index() {
        $request = $this->CI->input->get();
        $data=array();
        if(!empty($request) && isset($request['category_id']))
        {
            $data['metaSeo'] = $this->CI->m_seo->getCategoryMeta($request['category_id']);
            return $this->CI->load->view("modules/seo/meta",$data,true);
        }
        
        return FALSE;
    }
}
