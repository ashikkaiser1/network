<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of module_search
 *
 * @author kuldeep
 */
class module_search {
   //put your code here
    public $CI;
    public function __construct(CI_Controller &$CI) {
       // parent::__construct();
        $this->CI=$CI;
        $this->CI->load->model("modules/m_search");
    }
    
    public function index() {
        
        $request= $this->CI->input->get();
        //print_r($request);
        $data=array();
        $data['products']=$this->CI->m_search->searchProduct($request,STORE_ID);
       $data['productView']= $this->CI->load_controller('modules/productbox/product_box','index',$data['products']);
        return $this->CI->load->view("modules/category",$data,TRUE);
    }
}