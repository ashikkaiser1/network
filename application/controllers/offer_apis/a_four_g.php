<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of a_four_g
 *
 * @author kuldeep
 */
require_once APPPATH . "controllers/admin/offer.php";

class a_four_g extends offer {

    //
    //put your code here
    //https://traffic.a4g.com
    //https://traffic.a4g.com/www/admin/offers-api.php?apiKey=NL023p3z5U653bD141IxHRJC3w6nvi20Y15V571Wdc5FE0Z82X&zoneId=65588&affiliateId=12580&method=findAll&format=xml
    private $apiKey = "NL023p3z5U653bD141IxHRJC3w6nvi20Y15V571Wdc5FE0Z82X";
    private $api_url = "https://traffic.a4g.com/www/admin/offers-api.php?apiKey=NL023p3z5U653bD141IxHRJC3w6nvi20Y15V571Wdc5FE0Z82X&zoneId=65588&affiliateId=12580&method=findAll&format=json";
    private $advertiserName = "traffic_a4g_com";
    private $company_name = "Traffic A4G";
    private $advertiser_id = 0;
    private $admin_commission = 30; // it is in percentage
    private $tracking_urlExtension = "&subid2={transaction_id}&affid=12580";
    private $affiliateId = 12580;
    private $category_to_post = array(55, 57, 58, 59, 60);

    public function __construct() {
        parent::__construct();

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
                $this->affiliateId = $api_info['affId'];
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

        $this->setupAdvertiser();

        $result = file_get_contents($this->api_url);

        $offers = json_decode($result, TRUE);
//        echo '<pre>';
//        print_r($offers);
//        die();
        

        if (isset($offers['error']) && $offers['error'] == 'Success') {


            if (!empty($offers['Offers'])) {


                foreach ($offers['Offers'] as $key => $row) {
                    $campaign = array();
                    $campaign['advertiser_id'] = $this->advertiser_id;
                    $campaign['campaign_name'] = $row['OfferName'];
                    $campaign['cmp_id'] = $row['OfferId'];

                    $meta = "Description : " . $row['Description'] . "\n";
                    $meta .= "RestrictedTraffic : " . $row['Platform'] . "\n";
                    $meta .= "Restrictions : " . $row['Platform'] . "\n";
                    $meta .= "Platform : " . $row['Platform'] . "\n";
                    $meta .= "DailyCap : " . $row['DailyCap'] . "\n";
                    $campaign['meta'] = $meta;
                    $campaign['preview_link'] = isset($row['PreviewUrl']) ? $row['PreviewUrl'] : '';
                    $campaign['url_slug'] = isset($row['TrackingUrl']) ? $row['TrackingUrl'] . $this->tracking_urlExtension : '';
                    $campaign['start_date'] = date(OFFER_DATE_FROMAT, time());
                    $campaign['category_id'] = $this->category_to_post;

                    $endDates = array_column($row['countries'], 'endDate');
//                    echo '<pre>';
//                    print_r($endDates);
                    $campaign['end_date'] = date(OFFER_DATE_FROMAT, strtotime("+30 day"));
                    if (isset($endDates[0]))
                        $campaign['end_date'] = date(OFFER_DATE_FROMAT, strtotime($endDates[0]));

                    //get Avergage cost of all Countries ...
                    $all_rates = array_column($row['countries'], 'Rate');
//                    echo array_sum($all_rates);

                    if (isset($all_rates) && !empty($all_rates)) {

                        $getAveraageRevenueCost = array_sum($all_rates) / count($all_rates);
                    }

                    //end
                    $campaign['revenue_type'] = 1; //RPA
                    $campaign['revenue_cost'] = $getAveraageRevenueCost;
                    $campaign['revenue_cost'] = number_format((float) $campaign['revenue_cost'], 2, '.', '');
                    $campaign['payout_type'] = 4;


                    $campaign['payout_cost'] = $getAveraageRevenueCost - (($getAveraageRevenueCost * $this->admin_commission) / 100);
                    $campaign['payout_cost'] = number_format((float) $campaign['payout_cost'], 2, '.', '');
                    $campaign['status'] = 1;
                    $campaign['return'] = 1;
                    $campaign['geo'] = 1;
                    $campaign['conv_status'] = 1;
                    $campaign['offer_country'] = array();
                    if (!empty($row['countries'])) {
                        $campaign['geo'] = 0;
                        $filters = array();
                        $filters['isos'] = array_column($row['countries'], 'CountryName');
                        $filters['list'] = "iso";
                        $country_ids = $this->m_country->getCountry($filters);


                        $all_offer_country = array();

                        foreach ($row['countries'] as $key => $country) {
                            $offerCountry = array();
                            if (isset($country_ids[$country['CountryName']])) {
                                $offerCountry['country_id'] = $country_ids[$country['CountryName']];
                                $offerCountry['payout_type'] = 4;
                                $offerCountry['payout_cost'] = $country['Rate'] - (($country['Rate'] * $this->admin_commission) / 100);
                                $offerCountry['payout_cost'] = number_format((float) $offerCountry['payout_cost'], 2, '.', '');

                                $all_offer_country[] = $offerCountry;
                            }
//                        $offerCountry['country_id'] = $country_ids[$country['CountryName']];     
                        }
                        $campaign['offer_country'] = $all_offer_country;
                    }



                    $CampFilter = array();
                    $CampFilter['campaign_name'] = $campaign['campaign_name'];
                    $CampFilter['advertiser_id'] = array($this->advertiser_id);
                    $data['campaign'] = $this->m_campaign->getCampaign($CampFilter);

//                    echo "<pre>";
//                    print_r($data);
                    if (!empty($data['campaign']) && $data['campaign'][0]['campaign_id'] != '') {
                        $_POST = $campaign;
                        $campaign_id = 0;
                        $campaign_id = $data['campaign'][0]['campaign_id'];
                        $this->UpdateOffers($campaign_id);
                        $offer_fetched++;
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

}
