<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of footer_pages
 *
 * @author Naughty Dog
 */
class contact_us {

    public $CI;

    public function contact_us(CI_Controller &$CI) {
        $this->CI = $CI;
        $this->CI->load->model('email/mailer');
    }

    public function index() {

        $request = $this->CI->input->post();
        $data = array();
        // return "hello";
        if (!empty($request)) {
            //send mail and retrun e


            $mailData['to'] = EMAIL;
            $mailData['from'] = $request['InputEmail'];
            $mailData['subject'] = "Customer Message - " . $request['InputName'];

            $message = "<b>Customer Details</b><br></br>";
            $message.="<b>Name:</b> {$request['InputName']}<br>";
            $message.="<b>Email:</b> {$request['InputEmail']}<br>";
            $message.="<b>Phone:</b> {$request['InputCno']}<br>";
            $message.="<b>Message: </b><br>";
            $message.="<p>{$request['InputMessage']}</p>";
            $message.="<br><br>";
            $message.="End of Message";
            $mailData['message'] = $message;

            if ($this->CI->mailer->send_mail($mailData)) {
                echo json_encode(array("msg" => "Message Sent.", 'style' => "font-size: 14px; color: green;"));
            } else {
                echo json_encode(array("msg" => "Try Again.", 'style' => "font-size: 14px; color: red;"));
            }

            //json response call by module gate
        } else {
            return $this->CI->load->view("modules/contactus/v-contactus", $data, TRUE);
        }
    }

}
