<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cpagrip
 *
 * @author kuldeep
 */
require_once APPPATH . "controllers/admin/offer.php";

class scaleo extends offer {

    //put your code here
    private $apiKey = "e6a2d72018f133326b55864756f24132390f1c75";
    private $api_url = "http://partners.paidaffs.com/api/affiliate/get-offers-list";
    private $advertiserName = "paidAffs";
    private $company_name = "paidAff.com";
    private $advertiser_id = 0;
    private $user_id = 1186;
    private $admin_commission = 30; // it is in percentage
    private $tracking_urlExtension = "";
    private $category_to_post = array(55, 57, 58, 59, 60);

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
        $json = array("success" => TRUE, "offer_fetched" => 0);
        $offer_fetched = 0;
        $offers = $this->getOffers();

//        echo '<pre>';
//        print_r($offers);
//        die();
        if (!empty($offers)) {
            $this->setupAdvertiser();
        }

        if (isset($offers['offersList'])) {
            $filters = array();
            $filters['list'] = "iso";
            $country_list = $this->m_country->getCountry($filters);


            if (!empty($offers['offersList'])) {
                foreach ($offers['offersList'] as $key => $row) {
                    $campaign = array();
                    $campaign['advertiser_id'] = $this->advertiser_id;
                    $campaign['campaign_name'] = $row['name'];
                    $campaign['cmp_id'] = $row['id'];
                    $meta = stripslashes(trim(trim(strip_tags($row['notes']))));
//                    $meta .= "Type :- " . stripslashes(trim(trim(strip_tags($row['type']))));
                    if (is_array($row['categories'])) {
                        $meta .= "Category :" . implode(",", array_column($row['categories'], 'titles'));
                    } else {
//                        $meta .= "Category :" . stripslashes(trim(trim(strip_tags($row['category']))));
                    }


                    $campaign['meta'] = trim($meta);
                    $campaign['preview_link'] = isset($row['preview_url']) ? $row['preview_url'] : '#';
                    $campaign['url_slug'] = isset($row['trackingUrl']) ? $row['trackingUrl'] . $this->tracking_urlExtension : '';
                    $campaign['start_date'] = date(OFFER_DATE_FROMAT, time());
                    $campaign['category_id'] = $this->category_to_post;

                    $campaign['end_date'] = date(OFFER_DATE_FROMAT, strtotime("+30 day"));
                    $campaign['revenue_type'] = 1; //RPA

                    $payout = $row['goals'][0]['payout'];
                    $campaign['revenue_cost'] = (float) preg_replace('/[^0-9.]+/', '', $payout);
                    $getAveraageRevenueCost = $campaign['revenue_cost'] = number_format((float) $campaign['revenue_cost'], 2, '.', '');

                    $campaign['payout_type'] = 4;

                    $campaign['payout_cost'] = $getAveraageRevenueCost - (($getAveraageRevenueCost * $this->admin_commission) / 100);
                    $campaign['payout_cost'] = number_format((float) $campaign['payout_cost'], 2, '.', '');
                    $campaign['status'] = 1;
                    $campaign['return'] = 1;
                    $campaign['geo'] = 1;
                    $campaign['conv_status'] = 1;

                    if (isset($row['image']))
                        $campaign['image'] = $row['image'];

                    if (isset($row['accepted_countries'])) {
                        $country = explode(":", @$row['accepted_countries']);
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
        $host = $this->api_url;

        $data_to_post = [
            'api-key' => $this->apiKey,
        ];

//        $host .= "?api-key=" . $this->apiKey;

        $process = curl_init($host);
//        curl_setopt($process, CURLOPT_USERPWD, "$this->user_id:$this->apiKey");
//        curl_setopt($process, CURLOPT_POST, TRUE);
//        curl_setopt($process, CURLOPT_POSTFIELDS, $data_to_post);
        curl_setopt($process, CURLOPT_HEADER, false);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($process);
        curl_close($process);


        $offers = json_decode($return, TRUE);
        return $offers;
    }

}
