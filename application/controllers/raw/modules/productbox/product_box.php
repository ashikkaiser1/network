<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of product_box
 *
 * @author Nexgen
 */
class product_box {
     public $CI;
    public function __construct(CI_Controller &$CI) {
       // parent::__construct();
        $this->CI=$CI;
        //$this->CI->load->model("modules/m_category");
    }
    
    public function index($products) {
        $response="";
        
         $data['products']= $products;
           $response.= $this->CI->load->view("modules/productbox/v-product-box",$data,TRUE); 
        
        return $response;
    }
}
