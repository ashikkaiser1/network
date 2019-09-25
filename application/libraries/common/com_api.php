<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of common
 *
 * @author kuldeepsingh
 */
class com_api {

    public $ci;

    public function __construct() {


        $this->ci = & get_instance();
        $this->ci->load->helper("url");
        $this->ci->load->model("api/m_api");
        $this->ci->load->model("admin/m_system");
        $system_options = $this->ci->m_system->getSettings(array("Formated" => 'TRUE'));
        $this->ci->m_system->init_system($system_options);

        header('Content-Type: application/json');

        $request = $this->ci->input->get();
        if ($request && isset($request['token_key'])) {
            if ($this->ci->m_api->validateToken($request['token_key'])) {
                //valida token

                define("UID", $this->ci->m_api->getUserID($request['token_key']));
                //define("ADVERTISER", 3);
//                define("ACC_MANAGER", 4);
            } else {
                $json['status'] = FALSE;
                $json['msg'] = "Permission denied.";
                $json['request'] = $request;
                $json['response'] = array("status" => "1.Token Invalid");
                echo json_encode($json);
                die();
            }
        } else {
            $json['status'] = TRUE;
            $json['msg'] = "Permission denied.";
            $json['request'] = $request;
            $json['response'] = array("status" => "2Token Invalid");
            echo json_encode($json);
            die();
        }
    }

}
