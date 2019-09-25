<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home
 *
 * @author kuldeep
 */
//require_once(FCPATH . APPPATH . 'controllers/loader.php');

class home extends CI_Controller {

    public $page = "home";

    //put your code here
    public function __construct() {
        parent::__construct();
        // $this->load->helper('load_controller');
    }

    public function index() {
//
//$this->load->driver('cache', array('memcached' => 'apc', 'backup' => 'file'));
//if ($this->cache->memcached->is_supported())
//{
//    echo 'hello'; 
//} 
        // $this->benchmark->mark('code_start');

        $data = array();
        $request = $this->input->get();
        $data['top'] = $this->load_controller('common/c_top');
        if (!empty($request) && isset($request['page_id'])) {
            $data['center'] = $this->load_controller('modules/pages/footer_pages');
            $data['left'] = '';
            $data['right'] = '';
        } else {
            $data['left'] = $this->load_controller('common/c_left');
            $data['right'] = $this->load_controller('common/c_right');
            $data['center'] = $this->load_controller('common/c_center');
        }

        $data['bottom'] = $this->load_controller('common/c_bottom');


        //print_r($data);
        $this->load->view("template", $data);

//        $this->benchmark->mark('code_end');
//
//        echo $this->benchmark->elapsed_time('code_start', 'code_end');
    }

    public function password_recovery() {

        $data['Extra'] = array('Msg' => "", 'style' => '');
        $data['msg_style'] = "";
        $formData = $this->input->post();
        $this->load->model("email/mailer");
        $this->load->model('modules/m_account');
        if (!empty($formData)) {

            $new_pass = $this->m_account->check_recovery_email($formData);
//            echo "<pre>";
//            print_r($formData);
//            echo '</pre>';
            if ($new_pass) {
                $mailData['to'] = $formData['recovery_email'];
                $mailData['from'] = EMAIL;
                $mailData['cc'] = EMAIL;
                $mailData['subject'] = "Password Recovery";
                $mailData['message'] = "Dear Customer,<br><br>You have successfully reset your Password.<br><br>Your New Password is: " . $new_pass;
                if ($this->mailer->send_mail($mailData)) {
                    $data['Extra'] = array("Msg" => "New Password has been sent to your Email ID.", 'style' => "font-size: 20px; color: green;");
                } else {
                    $data['Extra'] = array("Msg" => "Sorry cant connect to mail server...", 'style' => "font-size: 20px; color: red;");
                }
            } else {
                $data['Extra'] = array("Msg" => "Entered Email ID does not Exist", 'style' => "font-size: 20px; color: red;");
            }
        }
        $data['left'] = '';
        $data['right'] = '';

        $data['top'] = $this->load_controller('common/c_top');
        $data['center'] = $this->load->view('modules/account/password_recovery/forgot-password', $data, TRUE);
        $data['bottom'] = $this->load_controller('common/c_bottom');

        //print_r($data);
        $this->load->view("template", $data);
    }

}
