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
require_once APPPATH . "controllers/offer_apis/offer_counter.php";

class ad_gate_media extends offer {

    //put your code here 
    private $apiKey = "1a41dd0a62a791c63f1dd17266f13fba";
    private $api_url = "https://api.adgatemedia.com/v2/offers?aff=6232&api_key=1a41dd0a62a791c63f1dd17266f13fba";
    private $advertiserName = "adgatemedia";
    private $company_name = "Ad Gate Media";
    private $advertiser_id = 0;
    private $user_id = 6232;
    private $admin_commission = 30; // it is in percentage
    private $tracking_urlExtension = "";
    private $category_to_post = array(55, 57, 58, 59, 60);
    private $ons_id = 0;

    public function __construct() {
        parent::__construct();
        $this->load->model("admin/m_country");
    }

    public function pre_config_api() {

        $request = $this->input->post();
        if ($request) {
            $this->ons_id = $request['ons_id'];
            offer_counter::$counter['ID_'.$this->ons_id] =0;
//            $this->session->set_userdata("ID_" . $this->ons_id, 0);
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

        if (isset($offers['data'])) {
            $filters = array();
            $filters['list'] = "iso";
            $country_list = $this->m_country->getCountry($filters);


            if (!empty($offers['data'])) {
                foreach ($offers['data'] as $key => $row) {
                    $campaign = array();
                    $campaign['advertiser_id'] = $this->advertiser_id;
                    $campaign['campaign_name'] = $row['name'];
                    $campaign['cmp_id'] = $row['id'];
                    $meta = stripslashes(trim(trim(strip_tags($row['anchor']))));
                    $meta .= stripslashes(trim(trim(strip_tags($row['requirements']))));
                    $meta .= "Category :" . stripslashes(trim(trim(strip_tags(implode(",", $row['categories'])))));
                    $meta .= "Tools :" . stripslashes(trim(trim(strip_tags(implode(",", $row['tools'])))));
                    $meta .= "Type :" . stripslashes(trim(trim(strip_tags($row['type']))));
                    $meta .= "User Agents :" . stripslashes(trim(trim(strip_tags(implode(",", $row['user_agent'])))));

                    $campaign['meta'] = trim($meta);
                    $campaign['preview_link'] = isset($row['preview_url']) ? $row['preview_url'] : '';
                    $campaign['url_slug'] = isset($row['click_url']) ? $row['click_url'] . $this->tracking_urlExtension : '';
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

                    if (isset($row['creatives']['icon'])) {

                        $url = $row['creatives']['icon'];
                        $img = APPPATH . "../upload/img/" . basename($url);
                        $imgurl = UPLOAD . "img/" . basename($url);
                        file_put_contents($img, file_get_contents($url));
                        $campaign['image'] = $imgurl;
                    }

                    $country = $row['countries'];
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

                        offer_counter::$counter['ID_'.$this->ons_id] =$offer_fetched;
//                        $this->load_controller("admin/offer/", "UpdateOffers", $campaign_id);
//                        echo 'updaing';
                    } else {
//                    create a new own 

                        $this->CreateOffers($campaign);
                        $offer_fetched++;
                        offer_counter::$counter['ID_'.$this->ons_id] =$offer_fetched;
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
        $offers = json_decode($return, TRUE);
        return $offers;
    }

}

//The API described on this page is for fetching offers for Content Lockers, Adgate Rewards, Super URLs, and Mobile App Walls. It is recommended to get a fresh list of offers every 10 minutes. Please do not use live traffic to request offers; the API should be called periodically from the backend.
//
//API url:
//https://api.adgatemedia.com/v2/offers?aff=6232&api_key=1a41dd0a62a791c63f1dd17266f13fba
//
//Required: 
//Affiliate (&aff=6232) - Enter your affiliate number (6232)
//
//API Key (&api_key=YOUR_KEY_HERE) - Enter the secret API key above
//
//Optional filters: 
//Format (&format=xml)- Enter xml to get xml output. By default the API will display offers in JSON format.
//
//Traffic Type (&traffic=content_locking,virtual_currency) - Filter by traffic type. Available options:
//content_locking
//virtual_currency
//video
//Incent (&incent=1|0) - Filter by offer type. Available options: 
//1 - only include incentive offers.
//0 - only include non-incentive offers
//Countries (&countries=CC,DD,EE) - Enter a list of country codes (comma separated) to get a list of offers only from those countries. 
//e.g. List all UK, US & CA offers - api.php?aff=1&country=gb,us,ca 
//
//Offer (&offer=1,2,3) - Enter list of offer ids (comma separated) to view details about selected offers. 
//e.g. List offers 4849, 5201 and 4809 - api.php?aff=1&offer=4849,5201,4809 
//
//Min EPC (&minepc=.01) - Enter a minimum EPC in dollars to return list of offers with greater or equal network EPC 
//e.g. List all offers with EPC greater than $0.15 - api.php?aff=1&epcmin=.15 
//
//Min Payout (&paymin=1) - Enter minimum payout in dollars to return list of offers with a greater or equal payout 
//e.g. List all offers with a payout greater than $1.15 - api.php?aff=1&paymin=1.15 
//
//User Agent (&user_agent=iPhone) - Enter a partial or full user agent here. This will display only offers that are compatible with that user agent.
//
//Mobile only (&mobile_only=1|0) - Return mobile-only offers. Available options: 
//1 - only includes mobile offers.
//0 - only include all offers (default)
//
//Categories (&categories=1,5,7) - Fetch offers that match any of the provided category IDs. Find the category-ID mapping below:
//1	Android
//2	Downloads
//3	Email Submits
//4	Free
//10	iPad
//11	iPhone
//12	Lead Gen
//13	Credit Card Required
//14	Mobile Subscription
//16	Surveys
//17	Videos
//18	CPC
//19	Pay Per Call
//Optional Limiting and Sorting: 
//Order By (&orderby=payout) - Order by either 'payout', 'epc', or 'id' (offer id) in descending order. Default is epc. 
//
//Limit (&take=10) - Limit to x results. By default all results are returned. 
//
//Skip (&skip=5) - Skips the first x result. Useful when combined with limiting (see above). By default, no offers are skipped.
