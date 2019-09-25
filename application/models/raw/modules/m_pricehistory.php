<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pricehistory
 *
 * @author Nexgen
 */
class m_pricehistory extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function getPriceHistory($product_id) {

        $qry = "SELECT pph_id,product_id,id,price,DATE_FORMAT(his_date,'%d-%m-%y')as his_date FROM product_price_history WHERE product_id = " . $product_id;

        $rs = $this->db->query($qry);

        return $rs->result_array();
    }

}
