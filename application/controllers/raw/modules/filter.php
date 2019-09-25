<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of filter
 *
 * @author kuldeep
 */
class filter {

    //put your code here
    public $CI;

    public function __construct(CI_Controller &$CI) {
        // parent::__construct();
        $this->CI = $CI;
        $this->CI->load->model("modules/m_filters");
    }

    public function index_1() {
//         echo '<pre>';
//         print_r($this->CI->page);
//        echo '</pre>';
        $request = $this->CI->input->get();
        // print_r($request);
        $data['category_id'] = isset($request['category_id']) ? $request['category_id'] : '';
        $data['s'] = isset($request['s']) ? $request['s'] : '';
//        $data['filters'] = $this->CI->m_filters->getFilters($request);
        return $this->CI->load->view("modules/filter_mod/init_filter", $data, TRUE);
    }

    public function load_filters() {
        //     echo 'loding';
        //         echo '<pre>';
//         print_r($this->CI->page);
//        echo '</pre>';
        //  echo '<pre>';
        // print_r($request);
        $request = $this->CI->input->get();
        //   print_r($request);
        // print_r($request);

        if ($request['category_id'] == '') {
            unset($request['category_id']);
        }

        if ($request['s'] == '') {
            unset($request['s']);
        }

        $data['category_id'] = isset($request['category_id']) ? $request['category_id'] : '';
        $data['s'] = isset($request['s']) ? $request['s'] : '';



        $data['filters'] = $this->CI->m_filters->getFilters($request);
        $json = array();

        $json['filters'] = $this->CI->load->view("modules/filter", $data, TRUE);
        $json['success'] = TRUE;
        echo json_encode($json);
    }

    public function index() {

        //if load with out ajax then rename the function to index ..
        //It automatical load on without ajax in normal page request
        //         echo '<pre>';
//         print_r($this->CI->page);
//        echo '</pre>';
       // return '';
        $request = $this->CI->input->get();
        // print_r($request);
        $data['category_id'] = isset($request['category_id']) ? $request['category_id'] : '';
        $data['s'] = isset($request['s']) ? $request['s'] : '';
        $data['filters'] = $this->CI->m_filters->getFilters($request);
//        $json=array();
//        
//        $json['filters']= $this->CI->load->view("modules/filter", $data, TRUE);
//        $json['success']=TRUE;
//        echo json_encode($json);

        return $this->CI->load->view("modules/filter", $data, TRUE);
        ;
    }

}
