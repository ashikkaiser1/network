<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of campaign
 *
 * @author NexGen
 */
class campaign extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com"); $this->com->is_advertiser();
        $this->load->model("advertiser/m_category");
        $this->load->model("advertiser/m_domain");
        $this->load->model("admin/random_string_gen", "hashCode");
        $this->load->model("advertiser/m_campaign");
        $this->load->model("advertiser/m_creative");
        $this->load->model("advertiser/m_goals");
        $this->load->model("account/m_account");


        //end
    }

    public function index() {
        $data = array();
        $catFilter = array();
        $catFilter['cat_type'] = NORMALCAMP;
        $data['category'] = $this->m_category->getCategory(0, $catFilter);
        $data['domain'] = $this->m_domain->getDomain();

        $data['PageContent'] = $this->load->view("advertiser/campaign/v-campaign", $data, TRUE);
        $this->load->view("advertiser/template", $data);
    }

    public function showOffers() {
        $this->load->helper("form");
        $data = array();
        $catFilter = array();
        $catFilter['cat_type'] = OFFER;
        $data['category'] = $this->m_category->getCategory(0, $catFilter);
        $data['domain'] = $this->m_domain->getDomain();
        $data['country'] = $this->m_account->getCountry();

        $data['PageContent'] = $this->load->view("advertiser/campaign/all_offer_tabular_view", $data, TRUE);    
//        $data['PageContent'] = $this->load->view("advertiser/campaign/v-offer-deisgn-2", $data, TRUE);
        $this->load->view("advertiser/template", $data);
    }

    public function offerRequest($campaign_id = 0) {
        $this->load->helper("form");
        //show offer request form to user to request the admin for offer approval.
        
        if(!$campaign_id){
            return;
        }

        $request = $this->input->post();
        if ($request) {
            //the request is accepeted by advertiser_apply_for_offer function
        }

//        echo '<pre>';
        $data = array();
        $data['campaign_id'] = $campaign_id;
        $data['campaign'] = $this->m_campaign->getOfferDetails($campaign_id);
        if(empty($data['campaign'])){
            return;
        }
        $county_filter = array();
        $county_filter['campaign_id'] = $campaign_id;
        $data['offer_country'] = array_column($this->m_campaign->getOfferCountry($county_filter), "name");
//        if (!$this->check_offer_approve($campaign_id, UID)) {
//            //if true it means offer is approved or no offer approval is required
//            //the show the genralte link form
//            $data['trackingPanel'] = $this->load->view("advertiser/offer/offer_tracking_link", $data, TRUE);
//
//            $data['p_type'] = array("0" => "Postback Url", "1" => "Image Pixel", "2" => "Iframe Pixel");
//            $data['PixelManager'] = $this->load->view("advertiser/offer/v-pixelManager", $data, TRUE);
//        } else if ($this->m_campaign->is_pending_request($campaign_id, UID)) {
//            //Request is pending and not approved;
//            $data['trackingPanel'] = "Your Reuest is pending";
//        } else {
//            $data['trackingPanel'] = $this->load->view("advertiser/offer/offer_request_form", $data, TRUE);
//        }
        
        //goals code
        
          //offer goal helper
        //$this->load->model("admin/m_goals");

        $this->load->model("admin/m_pay_type");
        $rev_filter = array();

        $rev_filter['type'] = PAYOUT;
        $rev_filter['formated'] = TRUE;
        $data['payout'] = $this->m_pay_type->getPayType($rev_filter);

        $rev_filter['type'] = REVENUE;
        $rev_filter['formated'] = TRUE;
        $data['revenue'] = $this->m_pay_type->getPayType($rev_filter);

        //global goals
        $filter = array();
        $filter['Formated'] = "TRUE";
        $data['global_goals'] = $this->m_goals->getGlobalGoals($filter);

        //end of code
        $data['campaign_id'] = $campaign_id;
        $data['offer_goals'] = $this->m_goals->getGoals($county_filter);
        $data['goals'] = $this->load->view("advertiser/offer/create/offer-details/offer_goals", $data, TRUE);
        
        //end of goals ode
        

        $data['payout'] = $this->load->view("advertiser/offer/create/offer-details/offer_payout", $data, TRUE);

        $data['getTargeting'] = $this->load->view("advertiser/offer/create/offer-details/offer_geo", $data, TRUE);



        //Goals
        //End goals


        $filterCreavtive = array();
        $filterCreavtive['campaign_id'] = $campaign_id;
        $data['OfferCreative'] = $this->m_creative->getOfferCreative($filterCreavtive);
        
        $data['creativePanel'] = $this->load->view("advertiser/offer/create/offer-details/offer_creative", $data, TRUE);
        
        
        ///offer Landing Pages
          $data['OfferUrls'] = $this->load->view("advertiser/offer/create/offer_url/all-offer-urls", $data, TRUE);
        //end
        
          
          
          
         


//        print_r($data);
//        die();
        $data['PageContent'] = $this->load->view("advertiser/offer/offer-details", $data, TRUE);
        $this->load->view("advertiser/template", $data);
    }

    public function getPost() {
        //get all post from db that is related to campaign and vice versa
        $this->load->model("advertiser/m_campaign");
        //   $this->load->model("advertiser/m_post");
        $request = $this->input->post();
        if ($request) {
            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;

            if (isset($request['onlyMe'])) {
                $request['onlyMe'] = UID;
            }
//            else
//            {
                $request['advertiser_id'] = UID;
//            }

            $data['posts'] = $this->m_campaign->get_post_camp($request);
            echo json_encode($data['posts']);
        }

        return;
    }

    public function generateLink($request = array(), $return = 0) {
        //the function is used for generating the link for post to share.///
        //call from different part of application link campaign and mylinks....

        $this->load->model("admin/m_tracker");
        $this->load->model("admin/advertiser/m_users");
        $this->load->model("admin/advertiser/m_campaign");

        if (empty($request))
            $request = $this->input->post();

        if ($request) {

            $link = array();
            $checkData = array();
            $checkData['post_id'] = $request['post_id'];
            $checkData['campaign_id'] = $request['campaign_id'];

            if (!isset($request['uid'])) {
                $checkData['uid'] = UID;
            } else {
                $checkData['uid'] = $request['uid'];
            }




            if ($this->check_offer_approve($checkData['campaign_id'], $checkData['uid'])) {
                $approval_json = array();
                $approval_json['success'] = FALSE;
                $approval_json['msg'] = "Need approval for offer.";
                if (!$return) {
                    echo json_encode($approval_json);
                    return FALSE;
                }
                return $approval_json;
            }

            $checkData['domain_id'] = $request['domain_id'] != '' ? $request['domain_id'] : $this->m_domain->getDefaultDomain();

            $checkData['aff_id'] = $this->m_users->getUsers(array("uid" => $checkData['uid']))['aff_id'];
            $payout = $this->m_campaign->getpayout_cost_type($checkData['campaign_id']);
            if ($payout) {
                $checkData['payout_cost'] = $payout['payout_cost'];
                $checkData['payout_type'] = $payout['payout_type'];
            }

//            echo '<pre>';
//            print_r($checkData);
            if ($link = $this->m_tracker->allreadyExist($checkData)) {
                //if link is already generated by user in past 
                //then it return the same link
                //
                $checkData = $link;
                $checkData['success'] = TRUE;

                //gen_link is used for those link that are
                //already generated by not havninng the offer_id and pub_id
                //so at this point of code the system append the two params with
                //already generated code 
                //params
                //offer_id  : it contains the campaign_id 
                //pub : It contains the uid of publisher 


                $checkData['gen_link'] = $this->m_domain->getDomain(array("domain_id" => $checkData['domain_id']))['domain_url'] . "/?offer_id=" . $checkData['campaign_id'] . "&pub=" . $checkData['uid'];
//                  " . $checkData['short_url']. "  
                unset($checkData['uid']);
                if (!$return) {
                    echo json_encode($checkData);
                    return;
                }
//                echo "<pre>";
//                print_r($checkData);
                return $checkData;
            } else {
                $checkData['short_url'] = $this->getUniqueCode();
//                " . $checkData['short_url']."
                $checkData['gen_link'] = $this->m_domain->getDomain(array("domain_id" => $checkData['domain_id']))['domain_url'] . "/?offer_id=" . $checkData['campaign_id'] . "&pub=" . $checkData['uid'];
            }


            //Set postback from Gloabl postback
            $this->load->model("admin/advertiser/modules/m_globalpostback", "globalPostback");
            $postback = '';
            $uid = isset($request['uid']) ? $request['uid'] : UID;
            if (isset($request['post_back']) && $request['post_back'] != '') {
                //This code is used for add converion pixel 
                //from page /admin/offer_postback/show_offer_postbacks
                $checkData['post_back'] = $request['post_back'];
                $checkData['p_type'] = isset($request['p_type']) ? $request['p_type'] : 0;
                //end of code
            } else if ($postback = $this->globalPostback->get_globalpostback($uid))
                $checkData['post_back'] = $postback != FALSE ? $postback['post_back'] : '';
            //end of post_back setting        

            if ($this->m_tracker->create_short_url($checkData)) {
                $checkData['success'] = TRUE;
                unset($checkData['uid']);
                if (!$return)
                    echo json_encode($checkData);
                else
                    return $checkData;
            }


            //echo $this->getUniqueCode();
        }
    }

    public function setConversionPixelUrl() {

        //this functon is used for setting a convertion pixel to
        //offer acc too publisher
        //function is used by advertiser/publisher
        //from set convertion Pixel or pixel manager


        $request = $this->input->post();
        $data = $this->get_offerUrl(TRUE);
        if ($data['success'] == TRUE) {
//            echo '<pre>';
//            print_r($data);
//            die();
            // $_POST['link_id'] = $data['link']['link_id'];
            $data['link']['post_back'] = isset($request['post_back']) ? $request['post_back'] : '';
            $data['link']['link'] = $data['link']['gen_link'];
            $data['link']['p_type'] = isset($request['p_type']) ? $request['p_type'] : 0;
//            echo '<pre>';
//            print_r($data);
            $data[] = $this->generatePublisherLink(TRUE, $data['link']);
        }

        echo json_encode($data);
    }

    public function get_offerUrl($return = FALSE) {
        //get the offer ul or post url  detaisl like tracking link
        //and their paramters
        //called from offfer_post_back 
        $this->load->model("admin/advertiser/m_post");
        $this->load->model("admin/advertiser/m_links");
        $this->load->model("admin/advertiser/modules/m_globalpostback", "globalPostback");
        $request = $this->input->post();
        if ($request) {
            $request['campaign_id'] = $this->m_post->getCampaign($request);
            $request['domain_id'] = '';

            $link_data = $this->generateLink($request, 1);
            if ($link_data['success'] == FALSE) {
                if ($return) {
                    return $link_data;
                } else {
                    echo json_encode($link_data);
                }
                return FALSE;
            }
            $filters = array();
            $filters['short_url'] = isset($link_data['short_url']) ? $link_data['short_url'] : '';
            $link = $this->m_links->getLinks($filters);
            if (!empty($link)) {
                //this code is special added for
                //when the old link that have not offer_id and pub in link
                $link['gen_link'] = $link_data['gen_link'];
            }

//            echo '<pre>';
//            print_r($link);
            $link_extra = $this->m_links->getLinkExtraParam($link);
            $link['campaign_id'] = $request['campaign_id'];
            $link_event = $this->m_links->getLinkEvents($link);

            if (isset($link['post_back']) && $link['post_back'] == '') {
                $postback = '';
                $uid = isset($request['uid']) ? $request['uid'] : UID;
                if ($postback = $this->globalPostback->get_globalpostback($uid))
                    $link['post_back'] = $postback != FALSE ? $postback['post_back'] : '';
            }
            $data['link'] = $link;
            $data['link_extra'] = $link_extra;
            $data['link_event'] = $link_event;
            $data['success'] = TRUE;
            $data['pixel'] = $this->gen_pixel($link);
            $data['conversion_pixel'] = $this->gen_conversion_pixel();
            if ($return) {
                return $data;
            } else {
                echo json_encode($data);
            }
        }
    }

    public function gen_pixel($link = array()) {
        //The function is used for generatiinf the image pixel for 
        //impression tracking....
        //return a string of code that containf
        //<img src='{http://tr.moremint.io/imptr/{shortCode}}'

        $code = "<img src ='" . IMP_URL . "?offer_id={$link['campaign_id']}&pub={$link['uid']}' width='1px' height='1px'/>";
        return $code;

        //end of code
    }

    public function gen_conversion_pixel() {
        //converiosn pixe;
        //that is only work for cookie 
        //a cookie transaction_id drop by tracker on user sider
        // the conersion pixel receive cookie from 
        //user side and submit to tracker system
        //http://tr.moremint.io.c_pr/
        $code = "<img src ='" . CONV_PIXEL . "' width='1px' height='1px'/>   or\n ";
        $code.="<iframe src='" . CONV_PIXEL . "' scrolling='no' frameborder='0' width='1' height='1'></iframe>";
        return $code;
    }

    public function check_offer_approve($campaign_id = 0, $uid = 0) {

        //funcation is used for check the offer is approved or not .. or by default approved for all

        if ($this->m_campaign->check_offerApproval($campaign_id)) {
            //true means the offer is not require any approval
            $filter = array();
            $filter['status'] = 1;
            if ($this->m_campaign->offerApprovedForUser($campaign_id, $uid, $filter)) {
                //if true the ogffer is available for user
                return FALSE;
            } else {

                return TRUE;
                //offer not available for user please send a request to admin
            }
        }

        return FALSE;

        //return FALSE;
        //send use the message to please send an approval to the admin for this offer
        //false means offer required approval  and system the check tthat the offer is enable for uid or not
    }

    public function generatePublisherLink($return = FALSE, $request = array()) {
        //gen publisher link by form

        $this->load->model("admin/advertiser/m_links");
        if (empty($request))
            $request = $this->input->post();
//        echo '<pre>';
//        print_r($request);
        if ($request) {
            $link_update = array();
            $link_update['post_back'] = $request['post_back'];
            if (isset($request['p_type'])) {
                $link_update['p_type'] = $request['p_type'];
            }
            $link_update['p_status'] = 1;
            if ($this->m_links->update_link($link_update, $request['link_id'])) {
                //notingn
            }

            //update extra prameter of links
            if (isset($request['col_value'])) {
                $linkExtra = array();
                for ($i = 0; $i < count($request['col_name']); $i++) {

                    if ($request['col_name'][$i] != '') {
                        $linkExtra[] = array("link_id" => $request['link_id'],
                            "col_name" => $request['col_name'][$i],
                            "col_value" => $request['col_value'][$i]);
                    }
                }

                if (!empty($linkExtra))
                    $this->m_links->setExtraPramLink($linkExtra, $request['link_id']);
            }


            //update link evenet prameter of links
            if (isset($request['offer_goal_id'])) {
                $linkEvent = array();
                for ($i = 0; $i < count($request['offer_goal_id']); $i++) {

                    if ($request['callback'][$i] != '') {
                        $linkEvent[] = array("link_id" => $request['link_id'],
                            "offer_goal_id" => $request['offer_goal_id'][$i],
                            "callback" => $request['callback'][$i]);
                    }
                }

                if (!empty($linkEvent))
                    $this->m_links->setLinkEvents($linkEvent, $request['link_id']);
            }

            //generate a link 

            $pub_url = $request['link'] . "&";
            //$pub_url = $request['link'] ;
            if (isset($request['col_name'])) {

                foreach ($request['col_name'] as $key => $val) {
                    if ($val != '')
                        $pub_url.=$val . "=" . $request['col_value'][$key] . "&";
                }
            }

            //no post back append further in syste,
            ////code is used for append the post_back in tracking url
            //bu from now 19 jan 2017 the post back is only save in db 
            //it get fetch by system when tracking link is clicked
            //$pub_url.="post_back=" . urlencode($request['post_back']);
            //code end
            $data['genurl'] = $pub_url;
            if ($return) {
                return $data;
            }
            echo json_encode($data);
            //end code  
        }
    }

    public function offerApprove() {

        //the function receive request from admin to apptove the camapign_id to a user 
        //the request id from the page "postbacke gen link" from admin panel.
        $this->load->model("advertiser/m_post");
        $request = $this->input->post();
        if ($request) {
            $json = array();
            $request['campaign_id'] = $this->m_post->getCampaign($request);
            unset($request['post_id']);
            if ($this->m_campaign->setofferApprove($request)) {
                $json['success'] = TRUE;
                $json['msg'] = "Offer is approved for Publisher.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Offer is not approved for Publisher.";
            }

            echo json_encode($json);
        }
    }

    public function advertiser_apply_for_offer() {
        //funcation is use for request to admin for approval of offer
        //1 callled from advertiser panel .
        $request = $this->input->post();
        if ($request) {
            $json = array();

            $request['uid'] = UID;
            $request['terms_cond'] = isset($request['terms_cond']) ? 1 : 0;

            $offerReuest_id = 0;
            if ($offerReuest_id = $this->m_campaign->advertiser_apply_for_offer($request)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your offer approval request is received.Thank you";

                //then generate a notification for account Manager of user to approve the request

                $data = array();
                $this->load->model("advertiser/m_users");
                $u_filter = array();
                $u_filter['uid'] = UID;
                $data['user'] = $this->m_users->getUsers($u_filter);

                $c_filter = array();
                $c_filter['campaign_id'] = isset($request['campaign_id']) ? $request['campaign_id'] : 0;
                $data['campaign'] = $this->m_campaign->getCampaign($c_filter);
                $data['request_id'] = $offerReuest_id;


                $notification = array();
                $notification['title'] = "New Request For offer";
                $notification['description'] = $this->load->view("advertiser/common/notif_layout/v-offer-approval-request", $data, true);
                $notification['link'] = SITEURL . "admin/campaign/show_request";
                $notification['noti_for'] = MANAGER;
                $notification['add_user'] = UID;


                $this->m_notify->save_notification($notification);

                //end of gen notification
            } else {
                $json['success'] = TRUE;
                $json['msg'] = "Something is missing or error generateed";
            }

            echo json_encode($json);
        }
    }

    public function featureoffer() {
        //get featured offers
        $this->load->model("advertiser/m_featured_offers");
        $filter = array();
        $filter['Featured'] = 'TRUE';
        
        $data = array();
        $data['featureOffer'] = $this->m_featured_offers->getFeaturedOffers($filter);

        echo json_encode($data);
    }

    function getUniqueCode() {
        $code = $this->hashCode->generate(10);

        if ($this->m_tracker->checkCodeExist($code)) {
            $code = $this->getUniqueCode();
        }

        return $code;
    }

}
