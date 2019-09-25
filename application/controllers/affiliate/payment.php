<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of payment
 *
 * @author NexGen
 */
class payment extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
          //check the login for user
        $this->load->library("common/com"); $this->com->is_affiliate();
         $this->load->model("affiliate/m_payment");
        //end
    }

    public function index() {
        $data = array();
//        
//        echo '<pre>';
//        print_r($_SERVER);
//        die();
        $data['PageContent'] = $this->load->view("affiliate/payment/v-payment", $data, TRUE);
        $this->load->view("affiliate/template", $data);
    }
    
     public function my_payments() {
        $data = array();
        $data['user_balance'] = $this->m_payment->getUserCurrentBalance(UID);
        $data['PageContent'] = $this->load->view("affiliate/payment/my_payments", $data, TRUE);
        $this->load->view("affiliate/template", $data);
    }

//    public function deposit_mp_payment() {
//
//        $request = $this->input->post();
//        $json = array("success" => false, "msg" => "Something went wrong. Please process again !!!!");
//
//        if ($request) {
//
//            $payment_ladger = array();
//
//            if (isset($request['amt']) && $request['amt'] != '' && $request['amt'] > 0) {
//                $payment_ladger['amt'] = $request['amt'];
//                $payment_ladger['uid'] = UID;
//                $payment_ladger['status'] = 0;
//                $payment_ladger['dateTime'] = date("Y-m-d H:i:s", time());
//            }
//            if (isset($request['trn_no']) && $request['trn_no'] != '') {
//                $payment_ladger['trn_no'] = $request['trn_no'];
//            }
//
//
//
//
//            if (!empty($payment_ladger)) {
//
//                if ($this->m_payment->deposit_payment($payment_ladger)) {
//                    $json['success'] = true;
//                    $json['msg'] = "Thank you for deposit."
//                            . " You transaction is send to admin for verification.After verifcation it will reflect on your account.";
//                }
//            }
//        }
//
//        echo json_encode($json);
//    }

    public function my_paymenthistory() {

        $request['uid'] = UID;

        $json = array("success" => FALSE);

        $json['history'] = $this->m_payment->my_paymenthistory($request);
        
        if(!empty($json['history']))
            $json['success'] =TRUE;
        
        echo json_encode($json);
    
          ;
        
    }


}
