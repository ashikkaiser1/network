<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class mailer extends CI_Model {

    // constructor
    public function __construct() {
        // calling to parent constructor
        parent::__construct();
        $this->load->library('email');
    }

    // send mail
    public function send_mail($mailData = array()) {



        // $config['protocol'] = 'sendmail';
        //  $config['send_multipart'] = FALSE;
        //$config['protocol'] = 'smtp';
        // $config['useragent'] = "CodeIgniter";
        //$config['charset'] = 'iso-8859-1';
//        $config['smtp_host'] = 'smtp.mandrillapp.com';
//        $config['smtp_user'] = 'care@block5.in';
//        $config['smtp_pass'] = 'SvyeRYd-VFbIs4c2q1WRKw';
//        $config['smtp_port'] = '587';
        // $config['charset'] = 'utf-8';
        // $config['mailtype'] = 'html';
// $config = Array(
//            'protocol' => 'smtp',
//            'smtp_host' => 'email-smtp.eu-west-1.amazonaws.com',
//            'smtp_port' => 465,
//            'smtp_user' => 'AKIAJIVBQ7VITRNEZIDQ',
//            'smtp_pass' => 'ArXkKnBJktjtZF3ubrYeH5nWHyTiXdrTXCQBLhp8kKRA',
//            'mailtype' => 'html',
//            'charset' => 'utf-8'
//        );

        $config = Array(
            'protocol' => EMAIL_PROTOCOL,
            'smtp_host' => EMAIL_SMTP_HOST,
            'smtp_port' => EMAIL_SMTP_PORT,
            'smtp_user' => EMAIL_SMTP_USER,
            'smtp_pass' => EMAIL_SMTP_PASS,
            'mailtype' => 'html',
//            'charset' => 'utf-8',
            'smtp_crypto' => 'security',
            'smtp_timeout' => '4', //in seconds
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );


        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->from(EMAIL_ACC, SITENAME);
        $this->email->to($mailData['to']);



        if (isset($mailData['cc'])) {
            $this->email->cc($mailData['cc']);
        }
        if (isset($mailData['bcc'])) {
            $this->email->bcc($mailData['bcc']);
        }
        $this->email->subject($mailData['subject']);
        $this->email->message($mailData['message']);

//        echo '<pre>';
//        print_r($mailData);
//        echo '</pre>';


        if ($this->email->send()) {

//           echo $this->email->print_debugger();
//           die();
            return True;
        } else {
            // echo $this->email->print_debugger();
//           die();
            return False;
        }

        echo $this->email->print_debugger();
    }

}
