<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of report
 *
 * @author NexGen
 */
class report extends CI_Controller {

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
    private $goals = array();
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
        "revenue_type" => "Revenue Type"
    );
    private $stats = array("clicks" => "Clicks",
        "conversion" => "Conversion",
        "cost" => "Cost",
        "revenue" => "Revenue",
        "profit" => "Profit");
    private $calulation = array("cpc" => "CPC", "cpa" => "CPA",
        "rpc" => "RPC", "rpa" => "RPA",
        "cpm" => "CPM", "rpm" => "RPM");
    private $interval = array("year" => "Year", "month" => "Month", "week" => "Week",
        "date" => "Date", "hour" => "Hour");

    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com");

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



    

    public function getAdvanceReport() {
        //$this->output->enable_profiler(TRUE);
        $this->load->model("api/m_reports");
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
           if(isset($request['startDate']) && $request['endDate']) 
           { $request['startDate'] = date("Y-m-d", strtotime($request['startDate']));
            $request['endDate'] = date("Y-m-d", strtotime($request['endDate']));
           }
            $report = $this->m_reports->getAdvanceReport($request);
            $data['response'] = $report;
            $data['success'] = TRUE;
            $data['request'] = $request;
            $data['message'] = "Report";
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

    public function getReport() {

        //normal report
        $this->load->model("admin/m_reports");
        $request = $this->input->post();
        if ($request) {
            // $request['uid'] = UID;
            $report = $this->m_reports->getReport($request);

            echo json_encode($report);
        }
    }

}
