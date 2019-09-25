<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_product
 *
 * @author kuldeep
 */
class m_product extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function getProduct($filter = array(), $store_id = 1) {

        $this->db->select("*")->from("aff_products");
        if (isset($filter['category_id'])) {
            $this->db->where(array("category_id" => $filter['category_id']));
        }
        if (isset($filter['product_id'])) {
            $this->db->where(array("aff_product_id" => $filter['product_id']));
        }

        return $this->db->get()->row_array();
    }

    public function get_similar($product_id) {

        $pre_qry = "SELECT ap.* "
                . "FROM aff_products ap "
                . "WHERE ap.aff_product_id = " . (int) $product_id;

        // echo $pre_qry; die();

        $product_data = $this->db->query($pre_qry)->row_array();

        //$match_title = $product_data['title'];
       $match_title = preg_replace('/[^a-zA-Z0-9_,.]/', ' ', $product_data['title']);
       $match_title= substr($match_title, 0,12); 
       $match_brand = $product_data['brand'];
        $match_brand = preg_replace('/[^a-zA-Z0-9_,.]/', ' ', $match_brand);
 
        $match_price = $product_data['mrp'];
        $price_var = $match_price * (1.5 / 100);
        $upper_price = $match_price + $price_var;
        $lower_price = $match_price - $price_var;
 
//
//        $meta_title = str_replace("(", "", $match_title);
//        $meta_title = str_replace(")", "", $meta_title);
//        $meta_title = str_replace("/", "%", $meta_title);
//        $meta_title = str_replace("'", "", $meta_title);
        $meta_title = str_replace(" ", "%", $match_title);
//        $meta_title = preg_replace('/%/', ' ', $meta_title, 1);
        
        $meta_title="%".$meta_title."%";
        
        
        $match_brand = str_replace(" ", "%", $match_brand);
//        $meta_title = preg_replace('/%/', ' ', $meta_title, 1);
        
        $match_brand="%".$match_brand."%";
        

//       // $title_words_arr = explode(' ', $match_title);
//        //$title_words = implode(' +', $title_words_arr);
//        
//        //$title_words = " ap.title LIKE '%". str_replace(" ", "%", $match_title) ."%'";
//                $title_words = " ap.title LIKE '+". str_replace(" ", "+", $match_title) ."'";
//
////        $title_words = '(';
////        
////        //following code to generate like query for each word in title
////        foreach ($title_words_arr as $key => $words) {
////            if ($key != 0) {
////                $title_words.='AND ';
////            }
////            $title_words.= "ap.title LIKE '%" . $words . "%' ";
////        }
////        $title_words.=')';
 
        
        $qry = "SELECT DISTINCT(ap.`market`) as mar,ap.* FROM `aff_products` as `ap` 
                  WHERE  `ap`.`title` like '$meta_title' and `ap`.`effectivePrice` >1 and ap.mrp = $match_price    "
                . " and "
                . " (ap.brand like '" . $match_brand . "' OR ap.brand = '') "
                . " group by `ap`.`market` ORDER BY ap.effectivePrice ASC";

        // echo $qry;

        $main_uery = "SELECT *,similarity_measure('ap.name','$match_title') as score ";
        $main_uery .= "from ($qry) AS likeMatches  order by score DESC LIMIT 10";

        $main_uery= $qry;


        //abinav uery
//            $qry = "SELECT ap.*, MATCH(ap.title) AGAINST ('$match_title' IN BOOLEAN MODE) as similarity "
//                    . "FROM aff_products ap "
//                    //. "WHERE ((ap.title LIKE '%" . $product . "%')) AND ap.category_id = " . $cat_id . " "
//                    //. "WHERE (ap.title LIKE '%" . $match_title . "%' OR $title_words) AND "
//                    . "WHERE MATCH(ap.title) AGAINST ('$match_title' IN BOOLEAN MODE) > 1 AND "
//                    . "(ap.mrp <= " . $upper_price ." AND ap.mrp >=". $lower_price.") AND "
//                    . "(ap.brand = '" . $match_brand . "' OR ap.brand = '') "
//                    . "GROUP BY ap.market "
//                    . "ORDER BY ap.effectivePrice ASC";
       $similarProducts= $this->db->query($main_uery)->result_array();
   // echo   $this->db->last_query();
        return $similarProducts;
    }

//    public function getSimilarProducts($meta_title) {
//        $catjoin = " ";
//        $con = " ";
////        if ($pcategory_id) {
////            $catjoin = " JOIN oct_product_to_category as cat on cat.product_id = op.product_id";
////            $con = " and cat.category_id = $pcategory_id";
////        }
//
//
//        $meta_title = str_replace("(", "", $meta_title);
//        $meta_title = str_replace(")", "", $meta_title);
//        $meta_title = str_replace("/", "%", $meta_title);
//        $meta_title = str_replace("'", "", $meta_title);
//        $meta_title = str_replace(",", "", $meta_title);
//        $meta_title = preg_replace('/%/', ' ', $meta_title, 1);
//        $meta_title = substr($meta_title, 0, 25) . "%";
//        $qry = "SELECT DISTINCT(`mt`.`market`), `opd`.`product_id` FROM `oct_product_description` as `opd` 
//                  JOIN `oct_product` as `op` on `op`.`product_id`=`opd`.`product_id`
//                  JOIN `multiscraper_tasks` as `mt` on `mt`.`product_id`= `op`.`product_id` $catjoin
//                  WHERE  `opd`.`meta_title` like '$meta_title' and `op`.`price` >1 $con  "
//                . " group by `mt`.`market`  order by `op`.`price` ASC";
//
//        // echo $qry;
//
//        $main_uery = "SELECT *,similarity_measure('opd.name','$main_keyword') as score ";
//        $main_uery .= "from ($qry) AS likeMatches  order by score DESC LIMIT 10";
//        // echo $main_uery;
//        $result = $this->db->query($main_uery);
//        //print_r($result->rows);
//        return $result->rows;
//    }

//     public function get_similar($product_id) {
//        
//        $pre_qry = "SELECT ap.* "
//                . "FROM aff_products ap "
//                . "WHERE ap.aff_product_id = " . (int) $product_id;
//
//        // echo $pre_qry; die();
//
//        $product_data = $this->db->query($pre_qry)->row_array();
//
//        $match_title = $product_data['title'];
//        $match_brand = $product_data['brand'];
//
//        $match_price = $product_data['mrp'];
//        $price_var = $match_price * (3.5 / 100);
//        $upper_price = $match_price + $price_var;
//        $lower_price = $match_price - $price_var;
//
//       // $title_words_arr = explode(' ', $match_title);
//        //$title_words = implode(' +', $title_words_arr);
//        
//        //$title_words = " ap.title LIKE '%". str_replace(" ", "%", $match_title) ."%'";
//                $title_words = " ap.title LIKE '+". str_replace(" ", "+", $match_title) ."'";
//
////        $title_words = '(';
////        
////        //following code to generate like query for each word in title
////        foreach ($title_words_arr as $key => $words) {
////            if ($key != 0) {
////                $title_words.='AND ';
////            }
////            $title_words.= "ap.title LIKE '%" . $words . "%' ";
////        }
////        $title_words.=')';
//
//            $qry = "SELECT ap.*, MATCH(ap.title) AGAINST ('$match_title' IN BOOLEAN MODE) as similarity "
//                    . "FROM aff_products ap "
//                    //. "WHERE ((ap.title LIKE '%" . $product . "%')) AND ap.category_id = " . $cat_id . " "
//                    //. "WHERE (ap.title LIKE '%" . $match_title . "%' OR $title_words) AND "
//                    . "WHERE MATCH(ap.title) AGAINST ('$match_title' IN BOOLEAN MODE) > 1 AND "
//                    . "(ap.mrp <= " . $upper_price ." AND ap.mrp >=". $lower_price.") AND "
//                    . "(ap.brand = '" . $match_brand . "' OR ap.brand = '') "
//                    . "GROUP BY ap.market "
//                    . "ORDER BY ap.effectivePrice ASC";
//        
//        return $this->db->query($qry)->result_array();
//        
//    }
}
