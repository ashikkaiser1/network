<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of header
 *
 * @author kuldeep
 */
class header {

    //put your code here
    public $CI;

    public function __construct(CI_Controller &$CI) {
        // parent::__construct();
        $this->CI = $CI;
        $this->CI->load->model("modules/m_category");
    }

    public function index() {
       // $this->CI->output->enable_profiler(TRUE);
        
        
         if (CACHE_STATUS == 1 && CACHE_TIME != '') {


            //cache store 
            $cachePath = APPPATH . 'cache/' . SITENAME;

            if (!file_exists($cachePath)) {
                mkdir($cachePath, 0700);
            }
            $this->CI->config->set_item('cache_path', $cachePath);
            //echo $this->config->item("cache_path");
            $this->CI->output->cache(CACHE_TIME);
            //end
        }
        
        
        $data = $this->CI->input->get();
        $data['category'] = $this->CI->m_category->getTopMenus(STORE_ID);

        $this->CI->config->set_item('logo', STORE_LOGO);
        $this->CI->config->set_item('category', $data['category']);

        $data['logo'] = $this->CI->config->item('logo');
        
       
//       echo "<pre>";
//       print_r($data['category']);
//       echo '</pre>';
//       die();
        $data['account'] = $this->CI->load_controller('modules/account/c_account', 'account_wrapper');
        return $this->CI->load->view("modules/header", $data, TRUE);
    }

    public function load_sub_menus() {

        $request = $this->CI->input->post();
        //print_r($request);
        if (!empty($request)) {
            $data['category'] = $this->CI->m_category->getMenus(STORE_ID, $request['category_id']);
            $this->CI->load->view("modules/nav/sub_menu", $data);
        }

        //return '';
    }
    
    public function load_footer_menus() {
        $request = $this->CI->input->post();
        if (!empty($request)) {
            $data['category'] = $this->CI->m_category->getTopMenus(STORE_ID, $request['category_id']);
             $this->CI->load->view("modules/nav/footer_menus", $data);
        }
    }

}
