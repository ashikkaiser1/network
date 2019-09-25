<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of price_history
 *
 * @author Nexgen
 */
class p_history {

    public $CI;

    public function __construct(CI_Controller &$CI) {
        // parent::__construct();
        $this->CI = $CI;
        $this->CI->load->model("modules/m_pricehistory", "history");
    }

    public function index() {
        $request = $this->CI->input->get();
        $data = array();
        $data['history'] = $this->CI->history->getPriceHistory($request['product_id']);
        $data['date'] = array_column($data['history'], 'his_date');
        $data['price'] = array_column($data['history'], 'price');
        return $this->CI->load->view("modules/price_history/price_history", $data, TRUE);
    }

}
