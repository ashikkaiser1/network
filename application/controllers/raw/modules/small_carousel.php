<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of carousel
 *
 * @author kuldeep
 */
class small_carousel {

    //put your code here
    //put your code here
    public $CI;

    public function __construct(CI_Controller &$CI) {
        // parent::__construct();
        $this->CI = $CI;
        $this->CI->load->model('modules/m_category');
    }

    public function index($carousel_info = array()) {

        $response = "";
        $data = array();

        if (!empty($carousel_info) && isset($carousel_info['module_setting']) && $carousel_info['module_setting'] != '') {
            
            $carousel_info_setting = unserialize($carousel_info['module_setting']);
            $data['moduleTitle'] = $carousel_info_setting['carousel_name'];
            //multiple products
            if (isset($carousel_info_setting['carousel_products']) && !empty($carousel_info_setting['carousel_products'])) {
                $request = array("product_ids" => $carousel_info_setting['carousel_products']);

                $data['products'] = $this->CI->m_category->getProducts(STORE_ID, $request);
            }
        }

        return $this->CI->load->view("modules/small_carousel", $data, TRUE);
    }

}
