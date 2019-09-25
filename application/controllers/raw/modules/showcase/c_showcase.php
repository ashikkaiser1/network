<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of c_showcase
 *
 * @author kuldeep
 */
class c_showcase {

    public $CI;

    public function __construct(CI_Controller &$CI) {
        // parent::__construct();
        $this->CI = $CI;
        $this->CI->load->model("modules/m_category");
    }

    public function index($showcaseinfo = array()) {
        $response = "";
        $data = array();

        if (!empty($showcaseinfo) && isset($showcaseinfo['module_setting']) && $showcaseinfo['module_setting'] != '') {
            $showcaseinfo_setting = unserialize($showcaseinfo['module_setting']);
            $data['moduleTitle'] = $showcaseinfo_setting['showcase_name'];
            //multiple products
            if (isset($showcaseinfo_setting['showcase_products']) && !empty($showcaseinfo_setting['showcase_products'])) {
                $request = array("product_ids" => $showcaseinfo_setting['showcase_products']);
 
                $data['products'] = $this->CI->m_category->getProducts(STORE_ID, $request);
            }
        }

        if (isset($data['products'])) {
            $data['productView'] = $this->CI->load_controller('modules/productbox/product_box', 'index', $data['products']);
        }
        // return $this->CI->load->view("modules/category",$data,TRUE);
        //foreach ($products as $product) {
       $response.= $this->CI->load->view("modules/showcase/v-showcase", $data, TRUE);
        // }
        return $response;
    }

}
