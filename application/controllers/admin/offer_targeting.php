<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of offer_targeting
 *
 * @author kuldeep
 */
class offer_targeting extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();

        //check the login for user
        $this->load->library("common/com");
        $this->load->model("admin/m_campaign");
    }

    public function getTrageting() {

        $request = $this->input->post();
        $json = array("success" => FALSE);
        $json['devices'] = array();
        $json['platforms'] = array();
        if ($request) {
            $campaign_id = isset($request['campaign_id']) ? $request['campaign_id'] : 0;

            $filter = array("campaign_id" => $campaign_id);
            $devices = $this->m_campaign->getOfferDevices($filter);
            $AllDevices = $this->config->item('deviceType');
            if (!empty($devices)) {
                foreach ($devices as $val) {
                    $json['devices'][] = $AllDevices[$val['device_id']];
                }
            }



            $OfferOS = $this->m_campaign->getOfferOS($filter);
            $AllPlatforms = $this->config->item('PlatformType');
            if (!empty($OfferOS)) {
                foreach ($OfferOS as $os) {
                    $json['platforms'][] = $AllPlatforms[$os['os_name']];
                }
            }
        }
        
        echo json_encode($json);
    }

}
