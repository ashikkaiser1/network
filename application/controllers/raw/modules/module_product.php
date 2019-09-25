<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of product
 *
 * @author kuldeep
 */
class module_product {

    //put your code here
    public $CI;

    public function __construct(CI_Controller &$CI) {
        // parent::__construct();
        $this->CI = $CI;
        $this->CI->load->model("modules/m_product");
    }

    public function index() {

        $request = $this->CI->input->get();
        //print_r($request);
        $store_id = 1;

        $data['similar_products'] = $this->CI->m_product->get_similar($request['product_id']);

        $data['product'] = $this->CI->m_product->getProduct($request, STORE_ID);
//        echo '<pre>';
//       print_r($data);
//       echo '</pre>';
        return $this->CI->load->view("modules/product", $data, TRUE);
    }

    public function fetch_product_spec() {

        $params = $this->CI->input->post();
        $fields_string = '';
        $url = CRAWL_SPEC;
        
        //echo $this->get_http_response_code($params['link']); die();
        $resp_code = $this->get_http_response_code($params['link']);

        //flipkart links return 301 code so need to add it
        if ($resp_code == 200 || $resp_code == 301) {

            foreach ($params as $key => $val) {
                $fields_string .= $key . '=' . urlencode($val) . '&';
            }
            rtrim($fields_string, '&');

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, count($params));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

            $result = curl_exec($ch);
            curl_close($ch);

            echo $result;
        } else {
            echo "<div class='text-center'>Product specifications not available.</div>";
        }
    }

    //function to check url is valid 
    function get_http_response_code($url) {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }

}
