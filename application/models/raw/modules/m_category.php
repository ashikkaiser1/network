<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_category
 *
 * @author kuldeep
 */
class m_category extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    private $block_category = array();

    public function getMenus($store_id = 1, $parent_id = 0) {
        //$this->db->cache_on();
        $list = array();
        $this->db->select("cat.*")->from("category as cat");
        // $this->db->join("b_category_store as bcat", "bcat.category_id !=cat.category_id and bcat.store_id = $store_id ","LEFT");
        $this->db->where(array("cat.status" => 1, "cat.parent_id" => $parent_id));
        //   $this->db->where_not_in("cat.category_id","" );
        $this->db->where("cat.category_id not in (SELECT category_id from b_category_store where store_id = $store_id )", NULL, FALSE);
        $this->db->order_by("cat.footer_sort_order", "ASC");
        $result = $this->db->get()->result_array();
        // echo $this->db->last_query();
        if (!empty($result)) {
            foreach ($result as $row) {
                $row['child'] = $this->getMenus($store_id, (int) $row['category_id']);
                $list[] = $row;
            }
        }
        // $this->db->cache_off();
//        
//        echo '<pre>';
//        print_r($list);
//        echo '</pre>';
//        echo die("SOrry");
        return $list;
    }

    public function getTopMenus($store_id = 1, $parent_id = 0) {
        //$this->db->cache_on();
        $list = array();
        $this->db->select("cat.*")->from("category as cat");
        // $this->db->join("b_category_store as bcat", "bcat.category_id !=cat.category_id and bcat.store_id = $store_id ","LEFT");
        $this->db->where(array("cat.status" => 1, "cat.parent_id" => $parent_id));
        //   $this->db->where_not_in("cat.category_id","" );
        $this->db->where("cat.category_id not in (SELECT category_id from b_category_store where store_id = $store_id )", NULL, FALSE);
        $this->db->order_by("cat.footer_sort_order", "ASC");
        $list = $this->db->get()->result_array();
        // echo $this->db->last_query();
//        if (!empty($result)) {
//            foreach ($result as $row) {
//                $row['child'] = $this->getMenus($store_id, (int) $row['category_id']);
//                $list[] = $row;
//            }
//        }
        // $this->db->cache_off();
//        
//        echo '<pre>';
//        print_r($list);
//        echo '</pre>';
//        echo die("SOrry");
        return $list;
    }

    public function getProducts($store_id = 1, $filter = array()) {
        //    die("welcome");
        $this->db->select("pro.*")->from("aff_products as pro");
        // $this->db->join("b_product_to_store as bps", "pro.aff_product_id != bps.product_id  and bps.store_id = $store_id","RIGHT" );

        if (isset($filter['category_id']) && $filter['category_id'] != '') {
            //condition for category specific
            $this->db->join("product_to_category ptc", "pro.aff_product_id= ptc.product_id", "LEFT");
            $this->db->where_in("ptc.category_id", $filter['category_id']);
        }
        if (isset($filter['filter']) && !empty($filter['filter'])) {
            //condition for specific filters like brand color, size price etc
            $this->db->join("oct_product_filter pf", "pro.aff_product_id= pf.product_id");
            $this->db->where_in("pf.filter_id", $filter['filter']);
        }

        if (isset($filter['product_ids']) && !empty($filter['product_ids'])) {
            //for show multiple products in modules like showcase
            $this->db->where_in("pro.aff_product_id", $filter['product_ids']);
        }




        if (isset($filter['s']) && $filter['s'] != '') {
            //condition for search 
            $this->db->like("pro.title", $filter['s'], "mid");
        }
        $this->db->where("pro.aff_product_id not in (SELECT product_id from b_product_to_store where store_id = $store_id )", NULL, FALSE);
        $this->db->where("pro.effectivePrice !=0");
        if (isset($filter['sortby']) && $filter['sortby'] != '') {
            switch ($filter['sortby']) {
                case "PLTH":   //Low to high
                    $this->db->order_by("pro.effectivePrice", "ASC");
                    break;
                case "PHTL": //High to low
                    $this->db->order_by("pro.effectivePrice", "DESC");
                    break;
                case "DIS": //Low to discount
                    $this->db->order_by("pro.discount", "DESC");
                    break;
                case "NEW": //Low to New 
                    $this->db->order_by("pro.update_date", "DESC");
                    break;




                default:
                    break;
            }
        } else {
            $this->db->order_by("pro.effectivePrice", "DESC");
        }


        $this->db->group_by("pro.aff_product_id,pro.title");
        if (isset($filter['limit']) && $filter['limit'] <= 12) {

            $p = 0;
            if (isset($filter['p'])) {
                $p = $filter['p'];
            }
            $this->db->limit($filter['limit'], $p * 12);
        } else {
            $this->db->limit(12, 0);
        }
        $result = $this->db->get()->result_array();
       //echo $this->db->last_query();

        return $result;
    }

    public function addToCompare($filter_data) {
        $this->db->select("*")->from("aff_products")->where(array("aff_product_id" => $filter_data['aff_product_id']));
        $result = $this->db->get()->row_array();
        $SD = $this->session->userdata;
        if (!empty($result) && $result['id'] != "") {
            $SD['user_data']['CompareData'][$result['aff_product_id']] = array(
                "effectivePrice" => $result['effectivePrice'],
                "discount" => $result['discount'],
                "imageLink" => $result['imageLink'],
                "link" => $result['link'],
                "title" => $result['title']);
            $this->session->set_userdata($SD);
            return array("succ" => TRUE, "data" => $SD['user_data']['CompareData'], "_err_codes" => "Added To Comapare List!!");
        } else {
            return array("succ" => FALSE, "_err_codes" => "Invalid Product Id!!");
        }
    }

    public function removeFromCompare($filter_data) {
        $this->db->select("*")->from("aff_products")->where(array("aff_product_id" => $filter_data['aff_product_id']));
        $result = $this->db->get()->row_array();
        $SD = $this->session->userdata;
        if (!empty($result) && $result['id'] != "") {
            if (isset($SD['user_data']['CompareData'][$result['aff_product_id']])) {
                unset($SD['user_data']['CompareData'][$result['aff_product_id']]);
            } else {
                return array("succ" => FALSE, "_err_codes" => "Product Not in Your Comapre List");
            }
            $this->session->set_userdata($SD);
            return array("succ" => TRUE, "_err_codes" => "Removed from Comapare List!!");
        } else {
            return array("succ" => FALSE, "_err_codes" => "Invalid Product Id!!");
        }
    }

    public function addToWishList($filter_data) {
        $this->db->select("*")->from("aff_products")->where(array("aff_product_id" => $filter_data['aff_product_id']));
        $result = $this->db->get()->row_array();
        $SD = $this->session->userdata;
        if (!empty($result) && $result['id'] != "") {
            $SD['user_data']['WishListData'][$result['aff_product_id']] = array(
                "effectivePrice" => $result['effectivePrice'],
                "discount" => $result['discount'],
                "imageLink" => $result['imageLink'],
                "link" => $result['link'],
                "title" => $result['title']);
            $this->session->set_userdata($SD);
            return array("succ" => TRUE, "data" => $SD['user_data']['WishListData'], "_err_codes" => "Added To Comapare List!!");
        } else {
            return array("succ" => FALSE, "_err_codes" => "Invalid Product Id!!");
        }
    }

    public function removeFromWishList($filter_data) {
        $this->db->select("*")->from("aff_products")->where(array("aff_product_id" => $filter_data['aff_product_id']));
        $result = $this->db->get()->row_array();
        $SD = $this->session->userdata;
        if (!empty($result) && $result['id'] != "") {
            if (isset($SD['user_data']['WishListData'][$result['aff_product_id']])) {
                unset($SD['user_data']['WishListData'][$result['aff_product_id']]);
            } else {
                return array("succ" => FALSE, "_err_codes" => "Product Not in Your Comapre List");
            }
            $this->session->set_userdata($SD);
            return array("succ" => TRUE, "_err_codes" => "Removed from Comapare List!!");
        } else {
            return array("succ" => FALSE, "_err_codes" => "Invalid Product Id!!");
        }
    }

    public function fetch_breadcrumb_data($filter_data) {
        $final_data = array();
        $status = $this->category_details($store_id = 1, $filter_data);
        if (!$status['succ']) {
            return array("succ" => FALSE, "_err_codes" => "Invalid Category ID");
        } else if ($status['succ']) {
            $final_data[] = array("link" => SITEURL . INDEX . "category/" . preg_replace('/[^a-zA-Z0-9_.]/', '-', $status['data']['name']) . "?category_id=" . $status['data']['category_id'], "cat_name" => $status['data']['name']);
            if ($status['data']['parent_id'] != 0) {
                do {
                    $status = $this->category_details($store_id = 1, array("category_id" => $status['data']['parent_id']));



                    $final_data[] = array("link" => SITEURL . INDEX . "category/" . preg_replace('/[^a-zA-Z0-9_.]/', '-', $status['data']['name']) . "?category_id=" . $status['data']['category_id'], "cat_name" => $status['data']['name']);
                } while ($status['data']['parent_id']);
            }
        }
        $final_data[] = array("link" => SITEURL, "cat_name" => "Home");
        return array("succ" => TRUE, "data" => $final_data);
    }

    public function category_details($store_id, $filter_data) {
        $this->db->select("cat.category_id,cat.parent_id,cat.name")->from("category as cat");
        $this->db->where(array("cat.status" => 1, "cat.category_id" => $filter_data['category_id']));
        $this->db->where("cat.category_id not in (SELECT category_id from b_category_store where store_id = $store_id )", NULL, FALSE);
        $result = $this->db->get()->row_array();
        if (!empty($result)) {
            return array("succ" => TRUE, "data" => $result);
        } else {
            return array("succ" => FALSE);
        }
    }

}
