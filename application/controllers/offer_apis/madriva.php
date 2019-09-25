<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of madriva
 *
 * @author kuldeep
 */
require_once APPPATH . "controllers/admin/offer.php";

class madriva extends offer {

    //b6df9fc5b4c7efb2fae9e167411408f075b772e62d05f0fba60a77b7caaa0b70
//            api.midenity.com/pubapi.php
//            
//            
    //007b27d87b75287b1ce1aadf27a95f535618f3fed591db5356d1223fc7e7acd7
    //api.1318amethyst.com/pubapi.php/getbannerlist
    private $apiKey = "b6df9fc5b4c7efb2fae9e167411408f075b772e62d05f0fba60a77b7caaa0b70";
    private $api_url = "http://api.midenity.com/pubapi.php";
    private $advertiserName = "midenity";
    private $company_name = "Madriva midenity";
    private $advertiser_id = 0;
    private $admin_commission = 30; // it is in percentage
    private $tracking_urlExtension = "&subid={transaction_id}";
    private $category_to_post = array(55, 57, 58, 59, 60);

    //put your code here
    public function __construct() {
        parent::__construct();
        //

        $this->load->library("common/com");
        $this->load->model("admin/m_users");
        $this->load->model("admin/m_campaign");
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
            $advertiser['status'] = 3;

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

    public function index() {

        if (!$this->pre_config_api()) {
            return;
        }

        $json = array("success" => TRUE, "offer_fetched" => 0);
        $offer_fetched = 0;
        $this->setupAdvertiser();

        $offers = $this->getOffers();
//        echo '<pre>';
//        print_r($offers);
//        die();

        if (isset($offers['data'])) {


            if (!empty($offers['data'])) {


                foreach ($offers['data'] as $key => $row) {
                    $campaign = array();
                    $campaign['advertiser_id'] = $this->advertiser_id;
                    $campaign['campaign_name'] = $row['name'];
                    if (!is_array($row['description'])) {
                        $meta = "Description : " . strip_tags($row['description']) . "\n";
                        $meta .= "Category : " . $row['category'] . "\n";
                        $meta .= "Geo Targeting : " . $row['geotargeting'] . "\n";
                        $campaign['meta'] = $meta;
                    }

                    $campaign['preview_link'] = isset($row['PreviewUrl']) ? $row['PreviewUrl'] : '';
                    $campaign['url_slug'] = isset($row['TrackingUrl']) ? $row['TrackingUrl'] . $this->tracking_urlExtension : '';
                    $campaign['start_date'] = date(OFFER_DATE_FROMAT, time());
                    $campaign['category_id'] = $this->category_to_post;


//                    if (!empty($row['bannercount']) && $row['bannercount'] > 0) {
//
//                       $banners = $this->getOffeerBanners($row['campaignid']);
//                       
//                       echo '<pre>';
//                        print_r($banners);
//                    }
//                    $endDates = array_column($row['countries'], 'endDate');
//                    echo '<pre>';
//                    print_r($endDates);
                    $campaign['end_date'] = date(OFFER_DATE_FROMAT, strtotime("+30 day"));
//                    if (isset($endDates[0]))
//                        $campaign['end_date'] = date(OFFER_DATE_FROMAT, strtotime($endDates[0]));
                    //get Avergage cost of all Countries ...
//                    $all_rates = array_column($row['countries'], 'Rate');
//                    echo array_sum($all_rates);
//                    if (isset($all_rates) && !empty($all_rates)) {
//
//                        $getAveraageRevenueCost = array_sum($all_rates) / count($all_rates);
//                    }
                    //end
                    $campaign['revenue_type'] = 1; //RPA
//                    (float)preg_replace('/[^0-9.]+/', '', $row['payout']);


                    $campaign['revenue_cost'] = (float) preg_replace('/[^0-9.]+/', '', $row['payout']);
                    $getAveraageRevenueCost = $campaign['revenue_cost'] = number_format((float) $campaign['revenue_cost'], 2, '.', '');
                    $campaign['payout_type'] = 4;


                    $campaign['payout_cost'] = $getAveraageRevenueCost - (($getAveraageRevenueCost * $this->admin_commission) / 100);
                    $campaign['payout_cost'] = number_format((float) $campaign['payout_cost'], 2, '.', '');
                    $campaign['status'] = 3;
                    $campaign['return'] = 1;
                    $campaign['geo'] = 1;
                    $campaign['conv_status'] = 1;




                    $CampFilter = array();
                    $CampFilter['campaign_name'] = $campaign['campaign_name'];
                    $CampFilter['advertiser_id'] = array($this->advertiser_id);
                    $data['campaign'] = $this->m_campaign->getCampaign($CampFilter);


//                    echo '<pre>';
//                    print_r($campaign);
//                    echo "<pre>";
//                    print_r($data);
                    if (!empty($data['campaign']) && $data['campaign'][0]['campaign_id'] != '') {
                        $_POST = $campaign;
                        $campaign_id = 0;
//                          echo '<pre>';
//                    print_r($campaign);
//                        
//                        echo '<pre>';
                        $campaign_id = $data['campaign'][0]['campaign_id'];
                        $this->UpdateOffers($campaign_id);
                        $offer_fetched++;
//                        echo 'updaing';
                    } else {
//                    create a new own 


                        $this->CreateOffers($campaign);
                        $offer_fetched++;
                    }
                }
            }
        }

        $json['offer_fetched'] = $offer_fetched;
        echo json_encode($json);
    }

    public function getOffeerBanners($campaignid) {

        // Sets our destination URL
        $endpoint_url = "http://api.midenity.com/pubapi.php";

// Creates our data array that we want to post to the endpoint
        $data_to_post = [
            'apikey' => $this->apiKey,
            'apifunc' => 'getbannerlist',
            'campaignid' => $campaignid
        ];

// Sets our options array so we can assign them all at once
        $options = [
            CURLOPT_URL => $endpoint_url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data_to_post,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HEADER => 0
        ];
// Initiates the cURL object
        $curl = curl_init();
// Assigns our options
        curl_setopt_array($curl, $options);
// Executes the cURL POST
        $results = curl_exec($curl);
        curl_close($curl);
        $json = json_encode(simplexml_load_string($results, 'SimpleXMLElement', LIBXML_NOCDATA));

        $aru = json_decode($json, true);
        return $aru;
    }

    public function getOffers() {
        // Sets our destination URL
        $endpoint_url = $this->api_url;

// Creates our data array that we want to post to the endpoint
        $data_to_post = [
            'apikey' => $this->apiKey,
            'apifunc' => 'getcampaigns',
        ];

// Sets our options array so we can assign them all at once
        $options = [
            CURLOPT_URL => $endpoint_url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data_to_post,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HEADER => 0
        ];

// Initiates the cURL object
        $curl = curl_init();

// Assigns our options
        curl_setopt_array($curl, $options);

// Executes the cURL POST
        $results = curl_exec($curl);
        curl_close($curl);
//$results =substr($results, 0, strlen($results)-1);
//        echo '<pre>';
        $json = json_encode(simplexml_load_string($results, 'SimpleXMLElement', LIBXML_NOCDATA));

        $aru = json_decode($json, true);

//header('Content-type: application/xml');
//echo $results;
//        $oXML = new SimpleXMLElement($results);
////        $array = json_decode($json, true);
        return $aru;

// Be kind, tidy up!
    }

}
