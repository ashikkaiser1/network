<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
class c_report extends CI_Controller {

    //put your code here
    private $dataColoums = array();
    private $default_report = array("offers_report" =>
        array(
            "offer" => "Offer",
            "offer_id" => "Offer ID",
//            "advertiser" => "Advertiser",
            "clicks" => "Clicks",
            "conversion" => "Conversion",
            "payout" => "Payout",
//            "revenue" => "Revenue",
//            "profit" => "Profit",
//            "cpc" => "CPC",
//            "rpc" => "RPC",
            "CR" => "CR"
        ),
        "aff_report" =>
        array(
            "aff_name" => "Affiliate",
            "clicks" => "Clicks",
            "conversion" => "Conversion",
            "payout" => "Payout",
//            "revenue" => "Revenue",
//            "profit" => "Profit",
            "cpc" => "CPC",
            "rpc" => "RPC",
        ),
        "adv_report" =>
        array(
//            "advertiser" => "Advertiser",
            "clicks" => "Clicks",
            "conversion" => "Conversion",
            "payout" => "Payout",
//            "revenue" => "Revenue",
//            "profit" => "Profit",
            "cpc" => "CPC",
            "rpc" => "RPC",
        )
        ,
        "daily_report" =>
        array(
            "date" => "Date",
            "clicks" => "Clicks",
            "conversion" => "Conversion",
            "payout" => "Payout",
//            "revenue" => "Revenue",
//            "profit" => "Profit",
//            "cpc" => "CPC",
//            "rpc" => "RPC",
            "CR" => "CR"
        )
        ,
        "hourly_report" =>
        array(
            "date" => "Date",
            "hour" => "Hour",
            "clicks" => "Clicks",
            "conversion" => "Conversion",
            "payout" => "Payout",
//            "revenue" => "Revenue",
//            "profit" => "Profit",
            "cpc" => "CPC",
            "rpc" => "RPC",
        )
    );
    private $goals = array("goal_id" => "Goal ID",
        "goal_name" => "Goal Name");
//            array("Install" => 1, "Event_1" => 2, "Event_2" => 3);
    // array("campaign" => "Campaign Wise", "uid" => "Affiliate Wise", "date" => "Date","hour" =>"hour","month"=>"month","year"=>"Year","week"=>"week");
    private $dataCol = array(
//        "aff_name" => "Affiliate",
//        "aff_id" => "Affiliate ID",
//        "aff_manager" => "Affiliate Manager",
        "offer_id" => "Offer ID",
        "offer" => "Offer",
//        "advertiser_id" => "Advertiser ID",
//        "advertiser" => "Advertiser",
//        "advertiser_manager" => "Advertiser Manager",
        "country" => "Country",
        "payout_type" => "Payout Type",
//        "revenue_type" => "Revenue Type",
        "url_id" => "Url ID",
        "url_name" => "Url Name",
        "refer_page" => "Referrer Page",
        "device" => "By Device",
        "platform" => "By Platform",
        );
    private $stats = array("clicks" => "Clicks",
        "conversion" => "Conversion",
        "impression" => "Impression",
        "payout" => "Payout",
        "CR" => "CR"
//        "revenue" => "Revenue",
//        "profit" => "Profit"
    );
    private $calulation = array("cpc" => "CPC", "cpa" => "CPA",
        "rpc" => "RPC", "rpa" => "RPA",
        "cpm" => "CPM", "rpm" => "RPM");
    private $interval = array("year" => "Year", "month" => "Month", "week" => "Week",
        "date" => "Date", "hour" => "Hour");

    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com"); $this->com->is_affiliate();
        

        //end
    }

    public function index() {
        $data = array();
//        echo 'hi';

        $data['PageContent'] = $this->load->view("affiliate/report/v-report", $data, TRUE);
        $this->load->view("affiliate/template", $data);
    }

    //advance report 

    public function advance_report() {

//        echo 'hi';
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

        $this->load->helper("form");
        $filter = array();

//
//
//        $filter = array();
//        $filter['Formated'] = TRUE;
//        $camp = $this->m_campaign->getCampaign($filter);
//        unset($camp[0]);
//        $data['Camapign'] = $camp;

        $data['dataCol'] = $this->dataCol;
        $data['stats'] = $this->stats;
        $data['interval'] = $this->interval;
        $data['calculation'] = $this->calulation;

        $g_filter = array();
        $g_filter['Formated'] = TRUe;
        $data['global_goal'] = $this->goals;
//                $this->m_global_goal->getGoals($g_filter);

        $data['GroupBy'] = array("campaign" => "Campaign Wise", "uid" => "Affiliate Wise", "date" => "Date", "hour" => "hour", "month" => "month", "year" => "Year", "week" => "week");
        $data['OrderBy'] = array("campaign" => "Campaign", "date" => "Date");
        $data['SortOrder'] = array("ASC" => "ASC", "DESC" => "DESC");

        switch ($report_type) {
            case 'offers_report':
                $data['PageContent'] = $this->load->view("affiliate/report/c_reports/v-campaign-report", $data, TRUE);
                break;
            case 'daily_report':
                $data['PageContent'] = $this->load->view("affiliate/report/c_reports/v-performance-report", $data, TRUE);
                break;
            case 'conversion_report':
                $data['PageContent'] = $this->load->view("affiliate/report/c_reports/v-conversion-report", $data, TRUE);
                break;
            case 'detail_report':
                $data['PageContent'] = $this->load->view("affiliate/report/v-advance-report", $data, TRUE);
                break;
            

            default:
                break;
        }


        $this->load->view("affiliate/template", $data);
    }

    public function getAdvanceReport() {
        //$this->output->enable_profiler(TRUE);
        $this->load->model("affiliate/mc_report");
        $request = $this->input->post();
        $data = array();
        $data['filesuccess'] = FALSE;
        if ($request) {
            $excel = FALSE;
            //  $request['goals'] = $this->goals;
            $request['uid'][] = UID;

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
            $request['startDate'] = date("Y-m-d", strtotime($request['startDate']));
            $request['endDate'] = date("Y-m-d", strtotime($request['endDate']));
            $report = $this->mc_report->getAdvanceReport($request);
            $data['data'] = $report;
            $data['success'] = TRUE;

            //graph

            $yaxis = "Date";
            if (isset($request['groupby']['date'])) {
                $date = array_unique(array_column($report, "Date"));
                $yaxis = "Date";

                $data['graph'] = $this->draw_line_graph($request, $report, $date, $yaxis);
            } else if (isset($request['groupby']['hour'])) {
                $date = array_unique(array_column($report, "Hour"));
                $yaxis = "Hour";
            } else if (isset($request['groupby']['offer'])) {
                $date = array_unique(array_column($report, "Offer_ID"));
                $yaxis = "Offer_ID";

                $data['graph'] = $this->draw_pie_chart($request, $report, $date, $yaxis);
            }

//            echo"<pre>";
//            print_r($data);
//            exit;
            
            //end
            //code for excel import
            if ($excel) {
                $data['filesuccess'] = TRUE;
                $data['filedownload'] = $this->getExcelReport($report);
            }
            //code end
            echo json_encode($data);
        }
    }

    function draw_pie_chart($request, $report, $date, $yaxis) {
        $graph = array();
        $graph_tye = array();
        foreach ($request['select'] as $selection) {
            //selection would be clicks,conversion,revenue ,profile,etc;

            $graph = array();

            $graph['name'] = ucfirst($selection);
            $graph['tooltip'] = "'{series.name}: <b>{point.percentage:.1f}%</b>'";

            $graph['series']['name'] = ucfirst($selection);
            foreach ($report as $row) {

                $graph['series']['data'][] = array("name" => substr($row['Offer_Name'], 0, 30), "y" => (float) $row[ucfirst($selection)]);
            }

            $graph_tye[ucfirst($selection)] = $graph;
        }


        return $graph_tye;
    }

    function draw_line_graph($request, $report, $date, $yaxis) {

        // groupby[offer]:
//            echo '<pre>';
//            print_r($date);
        // $country = array_unique(array_column($list, "country"));
        $graph = array();
        foreach ($request['select'] as $selection) {
            //selection would be clicks,conversion,revenue ,profile,etc;
            $graph[] = array("name" => ucfirst($selection), "data" => $this->parse($report, ucfirst($selection), $date, ucfirst($selection), $yaxis));
        }
        $data_graph = array();
        $data_graph['y'] = array_values($date);
        $data_graph['x'] = $graph;
        $data_graph['gtype'] = "Statistics";
        $data_graph['sign'] = "";
        $data_graph['title'] = "<b>Statistics</b>";

        return $data_graph;
    }

    function parse($list, $selctionName, $date, $parseKey = 'clicks', $y = 'Date') {

        $data_ser = array();
        foreach ($date as $dat) {
            foreach ($list as $listdata) {

                if ($listdata[$y] == $dat && isset($listdata[$selctionName])) {
                    $data_ser[$dat] = (float) round($listdata[$parseKey], 2);
                } else {
                    if (!isset($data_ser[$dat]))
                        $data_ser[$dat] = 0;
                }
            }
        }
        return array_values($data_ser);
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

    //end of advance report



    public function getReport() {
        $this->load->model("affiliate/mc_report");
        $request = $this->input->post();
        if ($request) {
            $request['uid'] = UID;
            $report = $this->mc_report->getReport($request);

            echo json_encode($report);
        }
    }

}
