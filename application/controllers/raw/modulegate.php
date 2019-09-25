<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of modulegate
 *
 * @author kuldeep
 */
class modulegate extends CI_Controller {

    //put your code here

    public function index($module = '') {
        ///  

        switch ($module) {
            case 'login' :$this->load_controller('modules/account/c_account', 'login');
                break;
            case 'signup' :$this->load_controller('modules/account/c_account', 'signup');
                break;
            case 'edit_profile' :$this->load_controller('modules/profile/profile_info', 'edit_profile');
                break;
            case 'account' : echo $this->load_controller('modules/account/c_account', 'index');
                break;
            case 'load_more_products' : $this->load_controller('modules/module_category', 'load_more_products');
                break;
            case 'filter_products': $this->load_controller('modules/module_category', 'filter_products');
                break;
            case 'logout' : $this->load_controller('modules/account/c_account', 'logout');
                break;
            case 'fetch_product_spec' : $this->load_controller('modules/module_product', 'fetch_product_spec');
                break;
            case 'load_sub_menus' : $this->load_controller('modules/header', 'load_sub_menus');
                break;
            case 'load_footer_menus' : $this->load_controller('modules/header', 'load_footer_menus');
                break;
            case 'compare_to_add' : $this->load_controller('modules/module_category', 'addToCompare');
                break;
            case 'compare_to_remove' : $this->load_controller('modules/module_category', 'removeFromCompare');
                break;
            case 'compare_check' : $this->load_controller('modules/module_category', 'compare_check');
                break;
            case 'wish_check' : $this->load_controller('modules/module_category', 'wish_check');
                break;
            case 'wishlist_add' : $this->load_controller('modules/module_category', 'addTowishList');
                break;
            case 'wishlist_remove' : $this->load_controller('modules/module_category', 'removeFromwishList');
                break;
            case 'fetch_breadcrumb_data' : $this->load_controller('modules/module_category', 'fetch_breadcrumb_data');
                break;
             case 'contactus' : $this->load_controller('modules/contactus/contact_us');
                break;
            case 'load_filters' : $this->load_controller('modules/filter','load_filters');
                break;
            
            default : break;
        }
    }

}
