<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of payments
 *
 * @author kuldeep
 */
class payments extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();

        //check the login for user
        $this->load->library("common/com");
        $this->com->is_admin();
        //end
        $this->load->model("admin/m_users");
        $this->load->model("admin/m_payment");
        $this->load->helper("form");
    }

    //advertiser payments code

    public function index() {

        $this->show_deposit_payment_request();
    }
 public function sysinvoice (){
        //set ou uload new creatives to offers  
        $data = array();
        

        $data['PageContent'] = $this->load->view("admin/payment/sysinvoice", $data, TRUE);
        $this->load->view("admin/template", $data);

        //end of code
    }
    public function getUserPaymentInfo() {

        $request = $this->input->post();
        if ($request) {

            $json['userInfo'] = $this->m_users->getUsers($request);
            if (!empty($json['userInfo'])) {
                $UserInfo = $json['userInfo'];
                $payments = array();
                $payments['paypal_email'] = isset($UserInfo['paypal_email']) && $UserInfo['paypal_email'] != '' ? $UserInfo['paypal_email'] : 'NA';
                $payments['payoneer'] = isset($UserInfo['payoneer']) && $UserInfo['payoneer'] != '' ? $UserInfo['payoneer'] : 'NA';
                $payments['bank_name'] = isset($UserInfo['bank_name']) && $UserInfo['bank_name'] != '' ? $UserInfo['bank_name'] : 'NA';
                $payments['bank_account'] = isset($UserInfo['bank_account']) && $UserInfo['bank_account'] != '' ? $UserInfo['bank_account'] : 'NA';
                $payments['IFSC_code'] = isset($UserInfo['IFSC_code']) && $UserInfo['IFSC_code'] != '' ? $UserInfo['IFSC_code'] : 'NA';
                $payments['PAN'] = isset($UserInfo['PAN']) && $UserInfo['PAN'] != '' ? $UserInfo['PAN'] : 'NA';
                $json['userInfo'] = $payments;
            }
            echo json_encode($json);
        }
    }

    public function show_deposit_payment_request() {
        $data['title'] = "Advertisers Payment Deposit";
        $data['UTID'] = ADVERTISER;
        $data['status'] = array("" => "All", "0" => "Pending", "1" => "Verified");

        $data['PageContent'] = $this->load->view("admin/payment/deposit_payments", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function showpaymentHostory() {


        $request = $this->input->post();
        $json = array("success" => FALSE);
        if ($request) {
            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            $json['history'] = $this->m_payment->my_paymenthistory($request);
            if (!empty($json['history']))
                $json['success'] = TRUE;
        }

        echo json_encode($json);
    }

    public function change_status() {

        //chnage to sttau of payment request (pending,block,active ,deactive,);
        $request = $this->input->post();
        $data = array();
        if ($request) {
            $update = array();
            $update['status'] = isset($request['status']) ? $request['status'] : 0;
            $pay_id = isset($request['pay_id']) ? $request['pay_id'] : 0;
            if ($this->m_payment->updatePaymentLedger($update, $pay_id)) {

                if ($request['status'] == 1) {
                    //it means verified or add amount to account
                    $this->update_main_account($request['uid'], $request['amt'], 1);
                }if ($request['status'] == 0) {
                    //deduct the amount 
                    $this->update_main_account($request['uid'], $request['amt'], 0);
                }
                $data['success'] = TRUE;
                $data['msg'] = "Status is changed";
            } else {
                $data['success'] = FALSE;
                $data['msg'] = "Status can't changed";
            }
        } else {
            $data['success'] = FALSE;
            $data['msg'] = "Status can't changed";
        }

        echo json_encode($data);
    }

    public function update_main_account($uid = 0, $amt, $type) {

        switch ($type) {
            case 1: //Amt add to main balance

                $this->m_payment->add_value_account($uid, $amt);
                break;


            case 0:
                $this->m_payment->minu_value_account($uid, $amt);
                break;
//Amt minus to main baance break;

            default:
                break;
        }
    }

    //end of advertiser code
    //affiliate paymen coed


    public function aff_payments() {


        $request = $this->input->post();
        if ($request) {

            $this->load->model("admin/m_reports");

            $report = $this->m_reports->getAdvanceReport($request);


            //get the Cost report from the reporting moeule
            //show that admin can clear the pending payments
            if (!empty($report)) {

                foreach ($report as $key => $row) {

                    //this piece of code get the user balance from the user balance table/
                    //user_balance hold the total amout that admin already transfered
                    //or the actual ammount that affiliate receive
                    //
                    $report[$key]['user_balance'] = $this->m_payment->getUserCurrentBalance($row['RR_Aff_id']);

                    if (isset($report[$key]['user_balance']['balance']) && $report[$key]['user_balance']['balance'] != 0) {
                        //if account baance is not zero the this piece of code works
//                        $row['Cost'] +=;
                        // it will add the refereal income to the 
                        $report[$key]['balance'] = abs($report[$key]['user_balance']['balance'] - ($row['Cost'] + $report[$key]['user_balance']['refereal_pay']));

//                       $report[$key]['balance'] this is pending payment that the admin will pay
                    } else {

                        $report[$key]['balance'] = abs(($row['Cost'] + $report[$key]['user_balance']['refereal_pay']));
//                        $report[$key]['balance'] = 0.0;
                    }

                    $report[$key]['sum_of_offer_toal_n_referal'] = abs(($row['Cost'] + $report[$key]['user_balance']['refereal_pay']));
                }
            }
            $data['aff_payments'] = $report;

            $data['success'] = TRUE;
            echo json_encode($data);
            return;
        }

        $data['title'] = "Affiliate Payments";
        $data['PageContent'] = $this->load->view("admin/payment/aff_payment", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function getUsercurrentBalance() {

        $request = $this->input->post();
        $json['success'] = FALSE;
        if ($request) {
            $uid = isset($request['uid']) ? $request['uid'] : 0;
            $json['user_balance'] = $this->m_payment->getUserCurrentBalance($uid);
        }

        echo json_encode($json);
    }

    public function deposit_mp_payment() {

        $request = $this->input->post();
        $json = array("success" => false, "msg" => "Something went wrong. Please process again !!!!");

        if ($request) {

            $payment_ladger = array();

            if (isset($request['amt']) && $request['amt'] != '' && $request['amt'] > 0) {
                $payment_ladger['amt'] = $request['amt'];
                $payment_ladger['uid'] = $request['uid'];
                $payment_ladger['remark'] = isset($request['remark']) ? $request['remark'] : '';
                $payment_ladger['mode'] = isset($request['mode']) ? $request['mode'] : '';
                $payment_ladger['status'] = 1;
                $payment_ladger['dateTime'] = date("Y-m-d H:i:s", time());
            }
            if (isset($request['trn_no']) && $request['trn_no'] != '') {
                $payment_ladger['trn_no'] = $request['trn_no'];
            }




            if (!empty($payment_ladger)) {

                if ($this->m_payment->deposit_payment($payment_ladger)) {

                    $this->update_main_account($request['uid'], $request['amt'], 1);
                    $json['success'] = true;
                    $json['msg'] = "Thank you for deposit.";
                }
            }
        }

        echo json_encode($json);
    }

    public function send_invoice_to_affiliate() {

        $request = $this->input->post();
        $json = array("success" => FALSE);
        $json['msg'] = "Invoice can't sent to affiliate";
        if ($request) {

            $this->load->model("email/mailer");
            $pay_id = isset($request['pay_id']) ? $request['pay_id'] : 0;
            if ($pay_id) {
                $user_payment_info = $this->m_payment->get_user_to_transaction($pay_id);
                $email = array();
                $email['to'] = $user_payment_info['email'];
                $email['subject'] = SITENAME . " Payment";
                $email['message'] = $this->load->view("admin/email/payments/invoice", $user_payment_info, TRUE);

                if ($this->mailer->send_mail($email)) {
                    $json['success'] = TRUE;
                    $json['msg'] = "Invoice is sent to affiliate";
                } else {
                    $json['success'] = FALSE;
                    $json['msg'] = "Invoice can't sent to affiliate";
                }
            }
        }

        echo json_encode($json);
    }

}
