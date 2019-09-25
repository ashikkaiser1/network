<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of common_config
 *
 * @author Abhinav Chauhan
 */
class common_config extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('url');
    }

    public function index() {

//        // $url = $_SERVER['SERVER_NAME'];
//        $url = str_replace('www.', '', $_SERVER['SERVER_NAME']);
//        
//       //$url= $this->db->escape("http://".$url."/",TRUE);
//        $this->db->select('user_id,store_id,url,logo,store_setting,theme,social_media,name,cache_status,cache_time')->from('oct_store');
//        $this->db->like('url',  str_replace(".com", "", $url),"both" );
//
//        $qry = $this->db->get();
//        $store_data = $qry->row_array();
//        
////        echo $this->db->last_query();
////       print_r($store_data);
////        die();
//
//        if (!empty($store_data)) {
//            defined('STORE_ID') OR define('STORE_ID', $store_data['store_id']);
//
//            $logo = unserialize($store_data['logo']);
//
//            if (isset($logo['logo'])) {
//                defined('STORE_LOGO') OR define('STORE_LOGO', $logo['logo']);
//            } else {
//                defined('STORE_LOGO') OR define('STORE_LOGO', '');
//            }
//
//            define("SITEURL", "http://" . $url . '/');
//            define("SITENAME", $store_data['name']);
//            define("INDEX", "index.php/");
//            define("THEME", $store_data['user_id'] == 9721174 ? 'theme3/' : $store_data['theme'] . '/');
//            define("ASSETS", SITEURL . "assets/" . THEME);
//            defined('STORE_SETTING') OR define('STORE_SETTING', $store_data['store_setting']);
//            defined('SOCIAL_MEDIA') OR define('SOCIAL_MEDIA', $store_data['social_media']);
//            defined('USER_ID') OR define('USER_ID', $store_data['user_id']);
//            define("CACHE_STATUS", $store_data['cache_status']);
//            define("CACHE_TIME", $store_data['cache_time']);
//        } else {
//            redirect(SITEURL, 'refresh');
//        }
    }

}
