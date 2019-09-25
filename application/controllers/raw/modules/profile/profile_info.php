<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of profile_info
 *
 * @author Nexgen
 */
class profile_info {

    //put your code here
    public function __construct(CI_Controller &$CI) {
        // parent::__construct();
        $this->CI = $CI;
        $this->CI->load->model("modules/m_profile");
    }

    public function index($info = array()) {

        $data = array();
        $response = "";

        $customer_id = $this->CI->session->userdata('customer_id');
        //foreach ($products as $product) {
        $data['customer_details'] = $this->CI->m_profile->get_customer_info($customer_id);

        $response.= $this->CI->load->view("modules/profile/profile_info", $data, TRUE);
        // }
        return $response;
    }

    public function edit_profile() {

        $this->CI->load->helper("url");

        $formdata = $this->CI->input->post();

        $customer_id = $this->CI->session->userdata('customer_id');

        if ($formdata['info_type'] == 'personal') {

            if ($this->CI->m_profile->update_profile($formdata, $customer_id)) {
                echo json_encode(array('succ' => true, 'msg' => 'Profile Updated!'));
            }
        }
    }

}
