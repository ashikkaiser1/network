<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of offer_import
 *
 * @author NexGen
 */
class offer_import extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com");
        $this->load->model("utility/m_upload");
    }

    public function index() {

        $data = array();
        $data['PageContent'] = $this->load->view("admin/import/import-offers", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function upload_offers() {
        //$image = $this->m_upload->do_upload("file", "offers");

        if (!empty($_FILES)) {
            $handle = fopen($_FILES['file']['tmp_name'], "r");

            $count = 0;  // to skip first column name
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // to skip first column name
                if (!$count) {
                    $count++;
                    continue;
                }
                // to skip if any blank row between the data
                if (empty($row)) {
                    continue;
                }

//                echo '<pre>';
//                print_r($row);
                $campaign = array();
               
                $i = 0;
                $campaign['advertiser_id'] = isset($row[$i]) ? $row[$i++] : 0;
                $campaign['campaign_name'] = isset($row[$i]) ? $row[$i++] : '';
                $campaign['meta'] = isset($row[$i]) ? $row[$i++] : '';
                $campaign['preview_link'] = isset($row[$i]) ? $row[$i++] : '';
                $campaign['url_slug'] = isset($row[$i]) ? $row[$i++] : '';
                $campaign['start_date'] = isset($row[$i]) ? $row[$i++] : '';
                $campaign['end_date'] = isset($row[$i]) ? $row[$i++] : '';
                $campaign['revenue_type'] = (isset($row[$i]) && $row[$i] !='') ? $row[$i++] : 1;
                $campaign['revenue_cost'] = (isset($row[$i]) && $row[$i] !='') ? $row[$i++] : 0;
                $campaign['payout_type'] = (isset($row[$i]) && $row[$i] !='') ? $row[$i++] : 4;
                $campaign['payout_cost'] = (isset($row[$i]) && $row[$i] !='') ? $row[$i++] : 0;
                $campaign['status'] = isset($row[$i]) ? $row[$i++] : 0;
                $campaign['return'] = 1;
                
               
                $this->load_controller("admin/offer/", "CreateOffers", $campaign);
            }
        }
    }

    public function change_offers() {
        $data = array();
        $data['PageContent'] = $this->load->view("admin/import/delete-offers", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function chang_offers() {
        //$image = $this->m_upload->do_upload("file", "offers");

        if (!empty($_FILES)) {
            $handle = fopen($_FILES['file']['tmp_name'], "r");
            $count = 0;  // to skip first column name
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // to skip first column name
                if (!$count) {
                    $count++;
                    continue;
                }
                // to skip if any blank row between the data
                if (empty($row)) {
                    continue;
                }
//                echo '<pre>';
//                print_r($row);
                $campaign = array();
                $campaign['campaign_id'] = isset($row[0]) ? $row[0] : 0;
                $campaign['campaign_name'] = isset($row[1]) ? $row[1] : '';
                $campaign['status'] = isset($row[2]) ? $row[2] : 0;
                $campaign['return'] = 1;
                $_POST = $campaign;
                $this->load_controller("admin/offer/", "UpdateOffers", $campaign['campaign_id']);
            }
        }
    }

}
