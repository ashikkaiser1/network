<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of category
 *
 * @author kuldeep
 */
class module_category {

    //put your code here
    public $CI;

    public function __construct(CI_Controller &$CI) {
        // parent::__construct();
        $this->CI = $CI;
        $this->CI->load->model("modules/m_category");
    }

    public function index() {

        $request = $this->CI->input->get();
        //print_r($request);

        $request['category_id'] = array($request['category_id']);
        $data['products'] = $this->CI->m_category->getProducts(STORE_ID, $request);

        $data['productView'] = $this->CI->load_controller('modules/productbox/product_box', 'index', $data['products']);
        return $this->CI->load->view("modules/category", $data, TRUE);
    }

    public function filter_products() {
        $request = $this->CI->input->post();
        $request['p'] = $request['p'] - 1;
        $data['products'] = $this->CI->m_category->getProducts(STORE_ID, $request);
        // print_r($data);
        echo $data['productView'] = $this->CI->load_controller('modules/productbox/product_box', 'index', $data['products']);
        //echo $this->CI->load->view("modules/category",$data,TRUE);
    }

    public function load_more_products() {
        $request = $this->CI->input->post();
        $json = array();
        $data['products'] = $this->CI->m_category->getProducts(STORE_ID, $request);
        // print_r($data);
        if (!empty($data['products'])) {
            $data['productView'] = $this->CI->load_controller('modules/productbox/product_box', 'index', $data['products']);

            $json['success'] = TRUE;
            $json['data'] = $data['productView'];
            $json['page'] = $request['p'] + 1;
            // $json['category_id']
        } else {
            $json['success'] = FALSE;
        }
        echo json_encode($json);

        //echo $this->CI->load->view("modules/category",$data,TRUE);
    }

    public function addToCompare() {

        $request = $this->CI->input->post();
        if (!empty($request)) {
            echo json_encode($this->CI->m_category->addToCompare($request));
        }
    }

    public function removeFromCompare() {

        $request = $this->CI->input->post();
        if (!empty($request)) {
            echo json_encode($this->CI->m_category->removeFromCompare($request));
        }
    }

    public function compare_check() {
        $SD = $this->CI->session->userdata;
        if (isset($SD['user_data']['CompareData']) && !empty($SD['user_data']['CompareData'])) {
            echo json_encode(array("succ" => TRUE, "data" => $SD['user_data']['CompareData']));
        } else {
            echo json_encode(array("succ" => FALSE));
        }
    }

    public function addTowishList() {

        $request = $this->CI->input->post();
        if (!empty($request)) {
            echo json_encode($this->CI->m_category->addToWishList($request));
        }
    }

    public function removeFromwishList() {

        $request = $this->CI->input->post();
        if (!empty($request)) {
            echo json_encode($this->CI->m_category->removeFromWishList($request));
        }
    }

    public function wish_check() {
        $SD = $this->CI->session->userdata;
        if (isset($SD['user_data']['WishListData']) && !empty($SD['user_data']['WishListData'])) {
            echo json_encode(array("succ" => TRUE, "data" => $SD['user_data']['WishListData']));
        } else {
            echo json_encode(array("succ" => FALSE));
        }
    }

    public function fetch_breadcrumb_data() {
        $request = $this->CI->input->post();
        if (!empty($request) && is_numeric($request['category_id'])) {
            echo json_encode($this->CI->m_category->fetch_breadcrumb_data($request));
        } else {
            echo json_encode(array("succ" => FALSE));
        }
    }

}
