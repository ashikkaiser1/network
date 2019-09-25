<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of market_redirect
 *
 * @author Naughty Dog
 */
class market_redirect extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model("modules/m_product");
        $this->load->helper('url');
    }

    public function product_redirect($product_id = '') {
        $SESSION = $this->session->all_userdata();

        $data = array();
        $product_data = $this->m_product->getProduct(array('product_id' => $product_id));

        if (isset($product_data['link'])) {
            $url = $product_data['link'];
        }

        ///
        $data['bg_image'] = DEFAULT_HOME_PAGE_IMG;
        $store_data = unserialize(STORE_SETTING);
        if (isset($store_data['store']['store_bg_img']) && $store_data['store']['store_bg_img'] != "" && file_exists($_SERVER['DOCUMENT_ROOT'] . "/affiliate/" . str_replace(AFFILATE_URL, "", $store_data['store']['store_bg_img']))) {
            $data['bg_image'] = $store_data['store']['store_bg_img'];
        }

        $data['skip_url'] = $this->build_product_url($url, '');
        $data['login_redirect'] = SITEURL . INDEX . 'market_redirect/product_redirect/' . $product_id;

        if (isset($SESSION['customer_id']) && $SESSION['customer_id'] != '') {

            $redirect_url = $this->build_product_url($url, $SESSION['customer_id']);

            redirect($redirect_url);
        } else {

            $data['affiliate_backkground'] = ASSETS . 'images/bg.jpg';
            $this->load->view('modules/customer_login', $data);
        }
    }

    public function slider_redirect() {
        
        $url = $this->input->get('href');
        
        $SESSION = $this->session->all_userdata();

        $data = array();

        $url = urldecode($url);

        $data['bg_image'] = DEFAULT_HOME_PAGE_IMG;
        $store_data = unserialize(STORE_SETTING);
        if (isset($store_data['store']['store_bg_img']) && $store_data['store']['store_bg_img'] != "" && file_exists($_SERVER['DOCUMENT_ROOT'] . "/affiliate/" . str_replace(AFFILATE_URL, "", $store_data['store']['store_bg_img']))) {
            $data['bg_image'] = $store_data['store']['store_bg_img'];
        }

        $data['skip_url'] = $this->build_product_url($url, '');

        $data['login_redirect'] = SITEURL . INDEX . 'market_redirect/slider_redirect?href=' . urlencode($url);

        if (isset($SESSION['customer_id']) && $SESSION['customer_id'] != '') {
            
            $redirect_url = $this->build_product_url($url, $SESSION['customer_id']);
            
            redirect($redirect_url);
        } else {

            $data['affiliate_backkground'] = ASSETS . 'images/bg.jpg';
            $this->load->view('modules/customer_login', $data);
        }
    }

    public function build_product_url($curr_url, $customer_id) {

        $Url = $curr_url;
        $user_id = USER_ID;
        $new_url = "";

        if (strstr($Url, "www.flipkart.com") || strstr($Url, "dl.flipkart.com/dl")) {

            $new_url = str_replace("www.flipkart.com", "dl.flipkart.com/dl", $Url);
            $new_url = $new_url . "&affid=tottamain&affExtParam1=$user_id";
            if ($customer_id != '') {
                $new_url.="&affExtParam2=$customer_id";
            }
        } else if (strstr($Url, "www.amazon.in") || strstr($Url, "www.amazon.com")) {
            if (strstr($Url, '?')) {
                $new_url = $Url . "&_encoding=UTF8&tag=httptottamaco-21";
            } else {
                $new_url = $Url . "?_encoding=UTF8&tag=httptottamaco-21";
            }
        } elseif (strstr($Url, "www.snapdeal.com")) {

            if (strstr($Url, '?')) {
                $new_url = $Url . "&utm_source=aff_prog&utm_campaign=afts&offer_id=17&aff_id=42784&aff_sub=$user_id";
            } else {
                $new_url = $Url . "?utm_source=aff_prog&utm_campaign=afts&offer_id=17&aff_id=42784&aff_sub=$user_id";
            }
            if ($customer_id != '') {
                $new_url.="&aff_sub2=$customer_id";
            }
        } else {
            $new_url = $Url;
        }

        return $new_url;
    }

}
