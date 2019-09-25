<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adscendmedia
 *
 * @author kuldeep
 */
require_once APPPATH . "controllers/admin/offer.php";

class cpa_leads extends offer {

    //put your code here
//    private $apiKey = "1477325117";
    private $api_url = "https://www.cpalead.com/dashboard/reports/campaign_json_load_offers.php?id=";
    private $advertiserName = "cpaleads";
    private $company_name = "CPA Leads";
    private $advertiser_id = 0;
    private $user_id = 154885;
    private $admin_commission = 30; // it is in percentage
    private $tracking_urlExtension = "";
    private $category_to_post = array(55, 57, 58, 59, 60);
    private $payout_types = array();

    public function __construct() {
        parent::__construct();
        $this->load->model("admin/m_country");
    }

    public function pre_config_api() {

        $request = $this->input->post();
        if ($request) {
            //get the ons_id from admin request and fetch the api info fromo db
            $this->load->model('admin/m_offers_api_manager');
            $api_info = $this->m_offers_api_manager->getNetworkSetting($request);
            if (!empty($api_info)) {
                $this->apiKey = $api_info['apiKey'];
                $this->api_url = $api_info['apiUrl'];
                $this->admin_commission = $api_info['commission_cut'];
                $this->advertiserName = $api_info['advertiserName'];
                $this->company_name = $api_info['companyName'];
                $this->tracking_urlExtension = $api_info['trackingLinkExten'];
                $this->user_id = $api_info['affId'];
                return TRUE;
            }
        } else {
            $json = array("success" => TRUE, "offer_fetched" => 0);
            echo json_encode($json);
            return FALSE;
        }
    }

    public function index() {

        if (!$this->pre_config_api()) {
            return;
        }
        ini_set('memory_limit', '1024M');

        $json = array("success" => TRUE, "offer_fetched" => 0);
        $offer_fetched = 0;
        $this->setupAdvertiser();
        $this->payout_types = $this->m_pay_type->getPayType(array("formated_api" => "true"));
        $offers = $this->getOffers();
//        echo '<pre>';
//        print_r($offers);
//
//        die();

        if (isset($offers['offers'])) {
            $filters = array();
            $filters['list'] = "iso";
            $country_list = $this->m_country->getCountry($filters);
            if (!empty($offers['offers'])) {
                foreach ($offers['offers'] as $key => $row) {
                    $campaign = array();
                    $campaign['advertiser_id'] = $this->advertiser_id;
                    $campaign['campaign_name'] = $row['title'];
                    $campaign['cmp_id'] = $row['campid'];
                    $meta = stripslashes(trim("Description : " . trim(strip_tags($row['description'])) . "\n"));
                    $meta .= stripslashes(trim(strip_tags($row['conversion']) . "\n"));
                    $campaign['meta'] = trim($meta);
                    $campaign['preview_link'] = isset($row['preview_url']) ? $row['preview_url'] : '';
                    $campaign['url_slug'] = isset($row['link']) ? $row['link'] . $this->tracking_urlExtension : '';
                    $campaign['start_date'] = date(OFFER_DATE_FROMAT, time());
                    $campaign['category_id'] = $this->category_to_post;

                    $campaign['end_date'] = date(OFFER_DATE_FROMAT, strtotime("+30 day"));
                    $campaign['revenue_type'] = 1; //RPA

                    $campaign['revenue_cost'] = (float) preg_replace('/[^0-9.]+/', '', $row['amount']);
                    $getAveraageRevenueCost = $campaign['revenue_cost'] = number_format((float) $campaign['revenue_cost'], 2, '.', '');

                    $campaign['payout_type'] = isset($this->payout_types[$row['payout_type']]) ? $this->payout_types[$row['payout_type']] : 4;

                    $campaign['payout_cost'] = $getAveraageRevenueCost - (($getAveraageRevenueCost * $this->admin_commission) / 100);
                    $campaign['payout_cost'] = number_format((float) $campaign['payout_cost'], 2, '.', '');
                    $campaign['status'] = 1;
                    $campaign['return'] = 1;
                    $campaign['geo'] = 1;
                    $campaign['conv_status'] = 1;

                    if (isset($row['previews'][0]))
                        $campaign['image'] = $row['previews'][0]['url'];

                    $country = explode(":", $row['country']);
                    if (!empty($country)) {
                        $campaign['geo'] = 0;
                        $all_offer_country = array();

                        foreach ($country as $key => $country) {
                            if (isset($country_list[$country])) {
                                $all_offer_country[] = $country_list[$country];
                            }
//                        $offerCountry['country_id'] = $country_ids[$country['CountryName']];     
                        }
                        $campaign['offer_country'] = $all_offer_country;
                    }

                    //

                    $CampFilter = array();
                    $CampFilter['campaign_name'] = $campaign['campaign_name'];
                    $CampFilter['advertiser_id'] = array($this->advertiser_id);
                    $data['campaign'] = $this->m_campaign->getCampaign($CampFilter);


                    if (!empty($data['campaign']) && $data['campaign'][0]['campaign_id'] != '') {
                        $_POST = $campaign;
                        $campaign_id = 0;
//                        echo '<pre>';
//                        print_r($campaign);
//                       ' echo '<pre>';'
                        $campaign_id = $data['campaign'][0]['campaign_id'];

                        $this->UpdateOffers($campaign_id);

                        $offer_fetched++;
//                        $this->load_controller("admin/offer/", "UpdateOffers", $campaign_id);
//                        echo 'updaing';
                    } else {
//                    create a new own 

                        $this->CreateOffers($campaign);
                        $offer_fetched++;
//                        $this->load_controller("admin/offer/", "CreateOffers", $campaign);
                    }
//                    }
                }
            }
        }
        $json['offer_fetched'] = $offer_fetched;
        echo json_encode($json);
    }

    public function setupAdvertiser() {
        //find user exist or not according to advertiser Name
        $filter = array();
        $filter['username'] = $this->advertiserName;
        $filter['company'] = $this->company_name;

        $user = $this->m_users->getUsers($filter);
//        echo '<pre>';
//        print_r($user);

        if (empty($user)) {
            //It means advertiser not exist 
            //Create a new user as advertiser

            $advertiser = array();
            $advertiser['UTID'] = ADVERTISER;
            $advertiser['username'] = $this->advertiserName;
            $advertiser['name'] = $this->advertiserName;
            $advertiser['company'] = $this->company_name;
            $advertiser['password'] = uniqid();
            $advertiser['re_password'] = $advertiser['password'];
            $advertiser['verified'] = 1;
            $advertiser['status'] = 1;

            if ($this->advertiser_id = $this->m_users->CreateUser($advertiser)) {
                //user created
            }
        } else {
            //user already exist

            $this->advertiser_id = isset($user[0]['uid']) ? $user[0]['uid'] : 0;
        }
//        echo '<pre>';
//        print_r($user);
    }

    public function getOffers() {
        $host = $this->api_url . $this->user_id . "&show=6000";
        $process = curl_init($host);
//        curl_setopt($process, CURLOPT_USERPWD, "$this->user_id:$this->apiKey");
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($process);
        curl_close($process);
        $offers = json_decode($return, TRUE);
        return $offers;
    }

}

//https://www.cpalead.com/dashboard/reports/campaign_json_load_offers.php?id=154885
