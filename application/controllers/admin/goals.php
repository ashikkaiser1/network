<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of goals
 *
 * @author NexGen
 */
class goals extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com");
        $this->com->is_admin();
        //end
        $this->load->model("admin/m_campaign");
        $this->load->model("admin/m_users");
        $this->load->model("admin/m_goals");
        $this->load->helper("form");
        $this->load->model("admin/m_pay_type");
    }

    public function show_goals($campaign_id = 0) {

        $filter = array();
        $filter['campaign_id'] = $campaign_id;
        $data['all_goals'] = $this->m_goals->getGoals($filter);
        if (!empty($data['all_goals'])) {
            $data['success'] = TRUE;
        } else {
            $data['success'] = FALSE;
        }
        echo json_encode($data);
    }

    public function CreateGoal($campaign_id = 0) {


        $request = $this->input->post();
        if ($request) {
            //creaeting goals 
            $json = array();
            if ($this->m_goals->CreateOffer($request)) {
                $json['success'] = TRUE;
                $json['msg'] = "New Goal created";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Goal not created";
            }

            echo json_encode($json);
            return;
        }


        $data = array();
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


//        echo '<pre>';
//        print_r($data['global_goals']);
        //

        $offerFilter = array();
        $offerFilter['Formated'] = 'TRUE';
        $offerFilter['order_by'] = "campaign_name";
        $offerFilter['ctype'] = OFFER;
        $offerFilter['status'] = 1;
        $offerFilter['group_by'] = 'campaign_id';


        $data['campaign'] = array();
//        $this->m_campaign->getCampaign($offerFilter);
        $data['campaign_id'] = $campaign_id;

        $filters = array();
        $filters['UTID'] = ADVERTISER;
        $filters['listFormated'] = TRUE;
        $data['affiliates'] = $this->m_users->getUsers($filters);
        $data['FormAction'] = SITEURL . "admin/goals/CreateGoal";
        $data['SubmitBtn'] = "Create";
        $data['Submiting'] = "Creating...";
        $data['title'] = "Create new Goals";

        // $data['Campaign'] = $this->m_campaign->getCategory(0,array("allchild"=>true));
        //$data['allCategory'] = $this->load->view("admin/Campaign/all-Campaign", $data, TRUE);
        $data['PageContent'] = $this->load->view("admin/goal/v-create-goal", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function UpdateGoals($campaign_id = 0, $offer_goal_id = 0) {


        $request = $this->input->post();
        if ($request) {
            //creaeting goals 
            $json = array();
            if ($this->m_goals->UpdateGoals($request, $offer_goal_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "New Goal Updated";
            } else {
                $json['success'] = TRUE;
                $json['msg'] = "Goal not Updated";
            }

            echo json_encode($json);
            return;
        }


        $data = array();
        $rev_filter = array();

        $rev_filter['type'] = PAYOUT;
        $rev_filter['formated'] = TRUE;
        $data['payout'] = $this->m_pay_type->getPayType($rev_filter);

        $rev_filter['type'] = REVENUE;
        $rev_filter['formated'] = TRUE;
        $data['revenue'] = $this->m_pay_type->getPayType($rev_filter);



        //global goals
//        $filter = array();
//        $filter['Formated'] = "TRUE";
//        $data['global_goals'] = $this->m_goals->getGlobalGoals($filter);

        if (isset($campaign_id) && $campaign_id != 0) {
            $offerFilter = array();
            $offerFilter['Formated'] = 'TRUE';
            $offerFilter['order_by'] = "campaign_name";
            $offerFilter['group_by'] = "campaign_id";
            $offerFilter['ctype'] = OFFER;
            $offerFilter['status'] = 1;
            $offerFilter['campaign_id'] = $campaign_id;
            $data['campaign'] = $this->m_campaign->getCampaign($offerFilter);
        }

        $data['campaign_id'] = $campaign_id;

        $goalFilter = array();
        $goalFilter['offer_goal_id'] = $offer_goal_id;
        $data['goal'] = $this->m_goals->getGoals($goalFilter);
//        
//        echo '<pre>';
//        print_r($data['goal']);
//        die();


        $filters = array();
        $filters['UTID'] = ADVERTISER;
        $filters['listFormated'] = TRUE;
        $data['affiliates'] = $this->m_users->getUsers($filters);
        $data['FormAction'] = SITEURL . "admin/goals/UpdateGoals/$campaign_id/$offer_goal_id";
        $data['SubmitBtn'] = "Create";
        $data['Submiting'] = "Creating...";
        $data['title'] = "Update Goals";

        // $data['Campaign'] = $this->m_campaign->getCategory(0,array("allchild"=>true));
        //$data['allCategory'] = $this->load->view("admin/Campaign/all-Campaign", $data, TRUE);
        $data['PageContent'] = $this->load->view("admin/goal/v-create-goal", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function deleteGoal() {

        $request = $this->input->post();
        if ($request) {
            $json = array();
            if ($this->m_goals->deleteGoals($request)) {
                $json['success'] = TRUE;
                $json['msg'] = "Goal Deleted";
            } else {
                $json['success'] = TRUE;
                $json['msg'] = "Goal not Deleted";
            }

            echo json_encode($json);
        }
    }

}
