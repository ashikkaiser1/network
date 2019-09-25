<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates   
 * and open the template in the editor.
 */

/**
 * Description of conversion_report
 *
 * @author NexGen
 */
class conversion_report extends CI_Controller {

    //put your code here
    //put your code here
    private $dataColoums = array();
    private $default_report = array("offers_report" =>
        array(
            "offer" => "Offer",
            "advertiser" => "Advertiser",
            "clicks" => "Clicks",
            "conversion" => "Conversion",
            "cost" => "Cost",
            "revenue" => "Revenue",
            "profit" => "Profit",
            "cpc" => "CPC",
            "rpc" => "RPC",
            "transaction_id" => "Transaction ID",
            "c_valid" => "Conversion Status",
//            "click_valid" => "Invalid Conversion" 
        ),
        "aff_report" =>
        array(
            "aff_name" => "Affiliate",
            "clicks" => "Clicks",
            "conversion" => "Conversion",
            "cost" => "Cost",
            "revenue" => "Revenue",
            "profit" => "Profit",
            "cpc" => "CPC",
            "rpc" => "RPC",
        ),
        "adv_report" =>
        array(
            "advertiser" => "Advertiser",
            "clicks" => "Clicks",
            "conversion" => "Conversion",
            "cost" => "Cost",
            "revenue" => "Revenue",
            "profit" => "Profit",
            "cpc" => "CPC",
            "rpc" => "RPC",
        )
        ,
        "daily_report" =>
        array(
            "date" => "Date",
            "clicks" => "Clicks",
            "conversion" => "Conversion",
            "cost" => "Cost",
            "revenue" => "Revenue",
            "profit" => "Profit",
            "cpc" => "CPC",
            "rpc" => "RPC",
        )
        ,
        "hourly_report" =>
        array(
            "date" => "Date",
            "hour" => "Hour",
            "clicks" => "Clicks",
            "conversion" => "Conversion",
            "cost" => "Cost",
            "revenue" => "Revenue",
            "profit" => "Profit",
            "cpc" => "CPC",
            "rpc" => "RPC",
        )
    );
   private $goals = array("goal_id" => "Goal ID",
        "goal_name" => "Goal Name");
//            array("Install" => 1, "Event_1" => 2, "Event_2" => 3);
    // array("campaign" => "Campaign Wise", "uid" => "Affiliate Wise", "date" => "Date","hour" =>"hour","month"=>"month","year"=>"Year","week"=>"week");
    private $dataCol = array("aff_name" => "Affiliate",
        "aff_id" => "Affiliate ID",
        "aff_manager" => "Affiliate Manager",
        "offer_id" => "Offer ID",
        "offer" => "Offer",
        "advertiser_id" => "Advertiser ID",
        "advertiser" => "Advertiser",
        "advertiser_manager" => "Advertiser Manager",
        "country" => "Country",
        "payout_type" => "Payout Type",
        "revenue_type" => "Revenue Type", 
        "transaction_id" => "Transaction ID",
        "c_valid" => "Conversion Status",
        "click_valid" => "Invalid Conversion",
        "device" => "By Device",
        "platform" => "By Platform",
    );
    private $stats = array("clicks" => "Clicks",
        "conversion" => "Conversion",
        "impression" => "Impression",
        "cost" => "Cost",
        "revenue" => "Revenue",
        "profit" => "Profit",
        "CR" => "CR"
    );
    private $calulation = array("cpc" => "CPC", "cpa" => "CPA",
        "rpc" => "RPC", "rpa" => "RPA",
        "cpm" => "CPM", "rpm" => "RPM",
    );
    private $interval = array("year" => "Year", "month" => "Month", "week" => "Week",
        "date" => "Date", "hour" => "Hour");

    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com"); $this->com->is_admin();

        $this->dataColoums[] = array("colVal" => 'campaign_name', "colNam" => "Campaign");
        $this->dataColoums[] = array("colVal" => 'campaign_id', "colNam" => "Campaign ID");
        $this->dataColoums[] = array("colVal" => 'name', "colNam" => "Affiliate");
        $this->dataColoums[] = array("colVal" => 'aff_id', "colNam" => "Aff ID");
        $this->dataColoums[] = array("colVal" => 'date', "colNam" => "Date");
        $this->dataColoums[] = array("colVal" => 'earn', "colNam" => "Payout");
        $this->dataColoums[] = array("colVal" => 'conversion', "colNam" => "Conversion");
        $this->dataColoums[] = array("colVal" => 'clicks', "colNam" => "Clicks");

        //end
    }

//    public function index() {
//        $data = array();
//        $data['PageContent'] = $this->load->view("admin/report/v-report", $data, TRUE);
//        $this->load->view("admin/template", $data);
//    }

    public function conv_report() {
        $data = array();
        $data['dataCol'] = json_encode($this->dataColoums);
        $this->load->model("admin/m_users");
        $this->load->model("admin/m_campaign");
        $this->load->model("admin/m_global_goal");

        //set up default report by request url
        $report_type = $this->input->get("repType");
        if ($report_type && isset($this->default_report[$report_type])) {
            $data['pre_checked_options'] = $this->default_report[$report_type];
            $data['repType'] = "getRep";
        }

        //end
        //by deafult selected Item
        $getReuest = $this->input->get();
        $data['autoAffiliateSelected'] = array();
        $data['autoOfferSelected'] = array();
        if ($getReuest) {
            $data['autoAffiliateSelected'][] = isset($getReuest['uid']) ? $getReuest['uid'] : 0;
            $data['autoOfferSelected'][] = isset($getReuest['campaign_id']) ? $getReuest['campaign_id'] : 0;
        }

        //end

        $this->load->helper("form");
        $filter = array();
        $filter['listFormated'] = TRUE;
        $filter['UTID'] = AFFILIATE;
        $aff = $this->m_users->getUsers($filter);
        unset($aff['']);

        $data['Affiliate'] = $aff;


        $filter = array();
        $filter['Formated'] = TRUE;
        $filter['group_by'] = 'campaign_id';
        $camp = array();
//                $this->m_campaign->getCampaign($filter);
        unset($camp[0]);
        $data['Camapign'] = $camp;

        $data['dataCol'] = $this->dataCol;
        $data['stats'] = $this->stats;
        $data['interval'] = $this->interval;
        $data['calculation'] = $this->calulation;
        $g_filter = array();
        $g_filter['Formated'] = TRUe;
        $data['global_goal'] =  $this->goals; //$this->m_global_goal->getGoals($g_filter);
        $data['GroupBy'] = array("campaign" => "Campaign Wise", "uid" => "Affiliate Wise", "date" => "Date", "hour" => "hour", "month" => "month", "year" => "Year", "week" => "week");
        $data['OrderBy'] = array("campaign" => "Campaign", "uid" => "Affiliate", "date" => "Date");
        $data['SortOrder'] = array("ASC" => "ASC", "DESC" => "DESC");


        $data['PageContent'] = $this->load->view("admin/report/v-conversion-report", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function getConAdvanceReport() {
        //$this->output->enable_profiler(TRUE);
        $this->load->model("admin/m_conversion_report");
        $request = $this->input->post();
        $data = array();
        $data['filesuccess'] = FALSE;
        if ($request) {
            $excel = FALSE;
            //$request['goals'] = $this->goals;

            if (!isset($request['select'])) {
                echo json_encode(array("success" => FALSE));
                return;
            }

            if (isset($request['fileImport']) && $request['fileImport'] == 'excel') {
                $excel = TRUE;
                unset($request['fileImport']);
            }
            // $request['uid'] = UID;
//            echo '<pre>';
//            print_r($request);
//            die();
            if (isset($request['startDate']) && $request['endDate']) {
                $request['startDate'] = date("Y-m-d", strtotime($request['startDate']));
                $request['endDate'] = date("Y-m-d", strtotime($request['endDate']));
            }
            $report = $this->m_conversion_report->getAdvanceReport($request);
            $data['data'] = $report;
            $data['success'] = TRUE;
            //code for excel import
            if ($excel) {
                $data['filesuccess'] = TRUE;
                $data['filedownload'] = $this->getExcelReport($report);
            }
            //code end
            echo json_encode($data);
        }
    }

    private function getExcelReport($result = array()) {
        $this->load->library("reports/excel");
        if (isset($result[0])) {
            $coloum = array_keys($result[0]);
            foreach ($coloum as $key => $val) {

                $coloum[$key] = str_replace("_", " ", $val);
            }

            array_unshift($result, $coloum);
//            echo '<pre>';
//            print_r($result);
        }
        $file_name = "Report" . date("Y-m-d") . "_" . uniqid() . "_" . "l.xls";
        $this->excel->stream_for_moremint($file_name, $result);

        return SITEURL . "../temp/" . $file_name;
    }

    public function ChangeStatus() {


        $request = $this->input->post();
        $json = array("success" => FALSE, "msg" => "Conversion Status Not Changes");
        if ($request) {
            $this->load->model("admin/m_conversion_report");
            //transaction_id is in reuest array
            $updateData = array();
            $updateData['c_valid'] = isset($request['c_valid']) ? $request['c_valid'] : 0;
            if ($this->m_conversion_report->ChangeStatus($request, $updateData)) {
                
                $click_track_update = array("valid"=>0);
                if($updateData['c_valid'] == 1){
                    $click_track_update["valid"]=1;
                }
                
                $this->m_conversion_report->ChangeClickStatus($request,$click_track_update);
                
                $json = array("success" => TRUE, "msg" => "Conversion Status Changed");
            } else {
                $json = array("success" => FALSE, "msg" => "Conversion Status Not Changes");
            }
        }

        echo json_encode($json);
    }

    public function convertion_bulk() {
        $data = array();
        $data['PageContent'] = $this->load->view("admin/report/bulk/conversion-status", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function chang_conversion() {
        //$image = $this->m_upload->do_upload("file", "offers");
         $this->load->model("admin/m_conversion_report");
        if (!empty($_FILES)) {
            $handle = fopen($_FILES['file']['tmp_name'], "r");
            $count = 0;  // to skip first column name
            $transation_ids = array();
            $updateData = array();
            $filters = array();
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

                $transation_ids[] = isset($row[0]) ? $row[0] : 0;
                $updateData['c_valid'] = isset($row[1]) ? $row[1] : 0;
            }

            $filters['transaction_id'] = $transation_ids;


            if ($this->m_conversion_report->ChangeStatus($filters, $updateData)) {
                $json = array("success" => TRUE, "msg" => "Conversion Status Changed");
            } else {
                $json = array("success" => FALSE, "msg" => "Conversion Status Not Changes");
            }
            
            echo json_encode($json);
        }
    }
}
    