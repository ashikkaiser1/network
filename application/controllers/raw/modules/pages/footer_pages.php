<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of footer_pages
 *
 * @author Naughty Dog
 */
class footer_pages {

    public $CI;

    public function footer_pages() {
        $this->CI = &get_instance();
        $this->CI->load->model('modules/m_pages');
    }

    public function index() {

        $request = $this->CI->input->get('page_id');
        $page_data = $this->CI->m_pages->get_page_content(STORE_ID, $request);


        $html = "";
        if (isset($page_data['module_name']) && $page_data['module_name'] != "") {
            if (file_exists(APPPATH . "controllers/modules/contactus/" . $page_data['module_name'] . ".php")) {
                
                $html = $this->CI->load_controller('modules/contactus/' . $page_data['module_name']);
            }
        }
        return $page_data['pageContent'] . $html;
    }

}
