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

class ad_work_media extends offer {

    //put your code here
    private $apiKey = "cq4lqb6hkantit059v50dllmw0gpczanbjbhhqkb";
    private $api_url = "https://www.adworkmedia.com/api/index.php?pubID=4614&apiID=cq4lqb6hkantit059v50dllmw0gpczanbjbhhqkb&campDetails=true";
    private $advertiserName = "adworkmedia";
    private $company_name = "AD work Media";
    private $advertiser_id = 0;
    private $user_id = 4614;
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

        if (isset($offers['campDetails'])) {
            $filters = array();
            $filters['list'] = "iso";
            $country_list = $this->m_country->getCountry($filters);


            if (!empty($offers['campDetails'])) {
                foreach ($offers['campDetails'] as $key => $row) {
                    $campaign = array();
                    $campaign['advertiser_id'] = $this->advertiser_id;
                    $campaign['campaign_name'] = $row['campaign_name'];
                    $campaign['cmp_id'] = $row['campaign_id'];
                    $meta = stripslashes(trim(trim(strip_tags($row['campaign_desc']))));
                    $meta .= "Incent :- " . stripslashes(trim(trim(strip_tags($row['incent']))));
                    if (is_array($row['categories'])) {
                        $meta .= "Category :" . stripslashes(trim(trim(strip_tags(implode(",", $row['categories'])))));
                    } else {
                        $meta .= "Category :" . stripslashes(trim(trim(strip_tags($row['categories']))));
                    }

                    $meta .= "Conversion Point :" . stripslashes(trim(trim(strip_tags($row['conversion_point']))));
                    $meta .= "Device Type :" . stripslashes(trim(trim(strip_tags($row['device_type']))));
                    $campaign['meta'] = trim($meta);
                    $campaign['preview_link'] = isset($row['preview_url']) ? $row['preview_url'] : '';
                    $campaign['url_slug'] = isset($row['url']) ? $row['url'] . $this->tracking_urlExtension : '';
                    $campaign['start_date'] = date(OFFER_DATE_FROMAT, time());
                    $campaign['category_id'] = $this->category_to_post;

                    $campaign['end_date'] = date(OFFER_DATE_FROMAT, strtotime("+30 day"));
                    $campaign['revenue_type'] = 1; //RPA

                    $campaign['revenue_cost'] = (float) preg_replace('/[^0-9.]+/', '', $row['payout']);
                    $getAveraageRevenueCost = $campaign['revenue_cost'] = number_format((float) $campaign['revenue_cost'], 2, '.', '');

                    $campaign['payout_type'] = 4;

                    $campaign['payout_cost'] = $getAveraageRevenueCost - (($getAveraageRevenueCost * $this->admin_commission) / 100);
                    $campaign['payout_cost'] = number_format((float) $campaign['payout_cost'], 2, '.', '');
                    $campaign['status'] = 1;
                    $campaign['return'] = 1;
                    $campaign['geo'] = 1;
                    $campaign['conv_status'] = 1;

                    if (isset($row['creatives']['icon']))
                        $campaign['image'] = $row['creatives']['icon'];

                    $country = explode(":", $row['countries']);
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
        $host = $this->api_url;
        $process = curl_init($host);
        curl_setopt($process, CURLOPT_USERPWD, "$this->user_id:$this->apiKey");
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($process);
        curl_close($process);

        $json = json_encode(simplexml_load_string($return, 'SimpleXMLElement', LIBXML_NOCDATA));
        $offers = json_decode($json, TRUE);
        return $offers;
    }

}
