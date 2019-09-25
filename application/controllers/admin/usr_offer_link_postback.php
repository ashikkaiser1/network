<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usr_offer_link_postback
 *
 * @author kuldeep
 */
class usr_offer_link_postback extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();

        $this->load->library("common/com");
//        $this->com->is_admin();
        $this->load->model("admin/m_macros");
        $this->load->model("admin/m_users");
        $this->load->model("admin/affiliate/m_domain");
        $this->load->model("admin/m_usr_offer_link_postback", "muop");

        //this functionality is comman btwn admin and affiliate so 
        //any one can access this and setup their postback as well as goal postback 
    }

    public function set_up_postback() {
        $json = array("success" => FALSE, "msg" => "Something went wrong..!!!!! Please try again the process.");
        //this function is used to set a postback for any campaign 
        // admin/affiliate have to pass
        //params
        //campaign_id  , uid (if loggedin user is admin ) and goal_id is optional 
        //p_type (0->S2S postbact url , 1->image pixel ,2 -> iframe );
        //post_back (url , image pixel code ,iframe pixel code)
        //goal_id is used for when the user want to setup goal postabck
        //other wise is should be 0 ,
        $request = $this->input->post();
//        echo '<pre>';
//        print_r($request);
        if ($request) {
//            return;
            $post_back = array();
            if (UTID == ADMIN) {
                $post_back['uid'] = (isset($request['uid']) && $request['uid'] != '') ? $request['uid'] : UID;
            } else {
                $post_back['uid'] = UID;
            }

            $post_back['domain_id'] = (isset($request['domain_id']) && $request['domain_id'] != '') ? $request['domain_id'] : $this->m_domain->getDefaultDomain();
            $post_back['goal_id'] = (isset($request['goal_id']) && $request['goal_id'] != '') ? $request['goal_id'] : 0;
            $post_back['campaign_id'] = (isset($request['campaign_id']) && $request['campaign_id'] != '') ? $request['campaign_id'] : 0;
            $post_back['p_type'] = (isset($request['p_type']) && $request['p_type'] != '') ? $request['p_type'] : 0;
            $post_back['post_back'] = (isset($request['post_back']) && $request['post_back'] != '') ? trim($request['post_back']) : '';


            //now post_back is reday to insert 
            //check the existance is this data , if this is  already exist then it should be update.
            if (!empty($this->muop->get_postback($post_back))) {
                //then delete the last one postback

                $filter = array();
                $filter['campaign_id'] = $post_back['campaign_id'];
                $filter['uid'] = $post_back['uid'];
                if ($this->muop->delete_postback($filter)) {
                    //if that one is succeffuly deleted then insert the new one

                    if ($this->muop->add_new_posback($post_back)) {

                        if (isset($request['goals']) && !empty($request['goals'])) {
                            foreach ($request['goals'] as $goal) {
                                $goal['domain_id'] = $post_back['domain_id'];
                                $this->muop->add_new_posback($goal);
                            }
                        }

                        $json['success'] = TRUE;
                        $json['msg'] = "Your postback is setted. Thank you.";
                    }
                }
            } else {
                //direclty iinsert the new postback row in db
                if ($this->muop->add_new_posback($post_back)) {

                    if (isset($request['goals']) && !empty($request['goals'])) {
                        foreach ($request['goals'] as $goal) {
                            $goal['domain_id'] = $post_back['domain_id'];
                            $this->muop->add_new_posback($goal);
                        }
                    }

                    $json['success'] = TRUE;
                    $json['msg'] = "Your postback is setted. Thank you.";
                }
            }

            //
        }



        echo json_encode($json);
    }

    public function get_posback() {
        // get postback is used for accessing the already setuped postback
        // Admin/ Affiliate can access this function

        $json = array("success" => FALSE, "msg" => "Something went wrong..!!!!! Please try again the process.");
        $request = $this->input->post();
        if ($request) {

            $post_back = array();
            if (UTID == ADMIN) {
                $post_back['uid'] = (isset($request['uid']) && $request['uid'] != '') ? $request['uid'] : UID;
            } else {
                $post_back['uid'] = UID;
            }

            $post_back['campaign_id'] = (isset($request['campaign_id']) && $request['campaign_id'] != '') ? $request['campaign_id'] : 0;
            $post_back['goal_id'] = (isset($request['goal_id'])) ? $request['goal_id'] : '';
            if (empty($post_back['goal_id'])) {
                unset($post_back['goal_id']);
            }

            $post_back = $this->muop->get_postback($post_back);

            $response = array();
            if (!empty($post_back)) {
                foreach ($post_back as $row) {
                    $row['post_back']=htmlspecialchars_decode($row['post_back']);
                    if ($row['goal_id'] == 0) {
                        
                        $response['offer_postback'] = $row;
                    } else {
                        $response['offer_postback']['goals'][$row['goal_id']] = $row;
                    }
                }
            }
            if (!empty($response)) {
                $json['sucees'] = TRUE;
                $json['msg'] = "Offer postback info received..";
            }
            $json['post_back'] = $response;
        }

        echo json_encode($json);
    }

    public function getOfferGoals() {
        //this fuction is used for geting the offer goals
        //call from Affiliate and ADmin panel
        $request = $this->input->post();
        $json = array("success" => FALSE, "msg" => "Something went wrong..!!!!! Please try again the process.");
        if ($request) {
            $filter = array();
            $filter['campaign_id'] = $request['campaign_id'] ? $request['campaign_id'] : 0;
            $response = $this->muop->getOfferGoals($filter);
            if (!empty($response)) {
                $json['success'] = TRUE;
                $json['goals'] = $response;
            }
        }

        echo json_encode($json);
    }

    public function getAffiliatesPostback() {
        //Only Admin can access this function
        $this->com->is_admin();
        $request = $this->input->post();
        $response = array();
        if ($request) {
            $request['goal_id'] = 0;
            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            $response = $this->muop->getAffiliatesPostbacks($request);
            
             foreach ($response as $key=>$row) {
                    $row['post_back']=htmlspecialchars_decode($row['post_back']);
                    $response[$key] = $row;
                } 
        }

        echo json_encode($response);
    }

    public function delete_postback() {
        $this->com->is_admin();
        //Admin can acess this function only
        $json = array("success" => FALSE, "msg" => "Something went wrong..!!!!! Please try again the process.");
        $request = $this->input->post();
        if ($request && isset($request['pixeldel'])) {
            foreach ($request['pixeldel'] as $pixel) {
                $filter = array();

                $pixel = explode("_", $pixel);
                $filter['uid'] = $pixel[0];
                $filter['campaign_id'] = $pixel[1];
                $this->muop->delete_postback($filter);
            }
            $json = array("success" => TRUE, "msg" => "Delete action performed successfully");
        } else {
            $json = array("success" => FALSE, "msg" => "Something went wrong..!!!!! Please try again the process.");
        }



        echo json_encode($json);
    }

    public function generate_tracking_link() {

        //this function is used for generate tracking link of raffiliae
        //this function called from Admin as well as affiliate


        $request = $this->input->post();
        $response = array("success" => FALSE);

        if ($request) {

            $filter = array();
            $filter['default'] = 1;
            $domain = $this->m_domain->getDomain($filter);

            if (UTID != ADMIN) {
                $request['uid'] = UID;
            }

            if (!empty($domain)) {

                $response['gen_link'] = $domain['domain_url'] . "?offer_id=" . $request['campaign_id'];
                $response['gen_link'] .= "&pub=" . $request['uid'];
            }

            if (!empty($response)) {
                $response['success'] = TRUE;
            }
        }

        echo json_encode($response);
    }

}
