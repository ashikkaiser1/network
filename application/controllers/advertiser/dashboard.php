<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dashboard
 *
 * @author NexGen
 */
class dashboard extends CI_Controller {

    //put your code here

    private $stats = array("clicks" => "Clicks",
        "conversion" => "Conversion",
        "impression" => "Impression",
        "payout" => "Payout",
    );
    private $default_select = array(
        0 => "clicks",
//        1 => "conversion",
//        2 => "impression",
        3 => "payout",
//        "revenue" => "Revenue",
            // 3 => "profit",
//            "cpc" => "CPC",
//            "rpc" => "RPC",
    );

    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com"); $this->com->is_advertiser();
        //end
        $this->load->helper("form");
    }

    public function index() {

        $data = array();

        $data['stats'] = $this->stats;
        $data['deafult_select'] = $this->default_select;

//        $data['LeaderBorad'] = $this->load_controller("advertiser/modules/leaderboard");
        $data['PageContent'] = $this->load->view("advertiser/dashboard/dashboard", $data, TRUE);
        $this->load->view("advertiser/template", $data);
    }

    public function getstats() {
        //$this->output->enable_profiler(TRUE);
        $this->load->model("advertiser/mc_report","m_reports");
        $request = $this->input->post();
//        
//        echo '<pre>';
//        print_r($request);
        
//        echo "Pre";
        $data = array();  

        if ($request) { 

            if (!isset($request['select'])) {
                echo json_encode(array("success" => FALSE));
                return;
            }
            $select = array();
            foreach ($request['select'] as $key => $sel) {

                $select[$sel] = $sel;
            }

            $request['select'] = $select;
            $request['uid'] = array(UID);

            $request['startDate'] = date("Y-m-d", strtotime($request['startDate']));
            $request['endDate'] = date("Y-m-d", strtotime($request['endDate']));

            if ($request['startDate'] == $request['endDate']) {
                // echo "equal";
                unset($request['groupby']['date']);
                $request['groupby']['hour'] = 'hour';
            } else {
                // echo 'Date not equal';
            }
            $report = $this->m_reports->getAdvanceReport($request);
//            $data['data'] = $report;
            $data['success'] = TRUE;
//            
//            echo '<pre>';
//            print_r($report);
            //
            $yaxis = "Date";
            if (isset($request['groupby']['date'])) {
                $date = array_unique(array_column($report, "Date"));
                $yaxis = "Date";
            } else if (isset($request['groupby']['hour'])) {
                $date = array_unique(array_column($report, "Hour"));
                $yaxis = "Hour";
            }

//            echo '<pre>';
//            print_r($date);
            // $country = array_unique(array_column($list, "country"));
            $graph = array();
            foreach ($request['select'] as $selection) {
                //selection would be clicks,conversion,revenue ,profile,etc;
                $graph[] = array("name" => ucfirst($selection), "data" => $this->parse($report, ucfirst($selection), $date, ucfirst($selection), $yaxis));
            }
            $data = array();
            $data['y'] = array_values($date);
            $data['x'] = $graph;
            $data['gtype'] = "Statistics";
            $data['sign'] = "";
            $data['title'] = "<b>Statistics</b>";
            
//            echo"<pre>";
//            print_r($data);
//            exit;
            
            echo json_encode($data);
        }
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
    
    public function getcommonStats($request = array()) {
        //get stats about earning ,conversion , clicks ,
       
        $request = $this->input->post();
        if ($request) {
            $request['uid'] =array(UID);
            $request['startDate'] = date("Y-m-d", strtotime($request['startDate']));
            $request['endDate'] = date("Y-m-d", strtotime($request['endDate']));
         //   $this->load->model("advertiser/m_reports");
             $this->load->model("advertiser/mc_report");
             
            $request['select']['payout'] ='payout';
            $request['select']['conversion'] ='conversion';
            $request['select']['CR'] ='CR';
            $request['select']['clicks'] ='clicks';
            $request['all']='all';
            $data['data'] = $this->mc_report->getAdvanceReport($request);
            $data['success'] = TRUE;
            echo json_encode($data);
        }
        //  }
    }

//    public function getgraph() {
//
//        $this->load->model("advertiser/m_reports");
//        $filter = array();
//        $filter['uid'] = UID;
//        $request = $this->input->post();
//        if ($request) {
//            $filter['startDate'] = $request['startDate'] != '' ? date("Y-m-d", strtotime($request['startDate'])) : '';
//            $filter['endDate'] = $request['endDate'] != '' ? date("Y-m-d", strtotime($request['endDate'])) : '';
//        }
//        $list = $this->m_reports->getgraphData($filter);
//        $date = array_unique(array_column($list, "date"));
//        $country = array_unique(array_column($list, "country"));
//        $graph = array();
//        foreach ($country as $countryName) {
//
//            $graph[] = array("name" => $countryName, "data" => $this->parse($list, $countryName, $date));
//        }
//        $data = array();
//        $data['y'] = array_values($date);
//        $data['x'] = $graph;
//        $data['gtype'] = "Clicks";
//        $data['sign'] = "";
//        $data['title'] = "<b>Clicks</b>";
//        echo json_encode($data);
//    }
//
//    public function getgraphEarning() {
//
//        $this->load->model("advertiser/m_reports");
//
//        $filters = array();
//        $filters['groupby'] = "date";
//        $filters['country'] = "TRUE";
////        $filters['']
//
//
//        $filters['uid'] = UID;
//        $request = $this->input->post();
//        if ($request) {
//            $filters['startDate'] = $request['startDate'] != '' ? date("Y-m-d", strtotime($request['startDate'])) : '';
//            $filters['endDate'] = $request['endDate'] != '' ? date("Y-m-d", strtotime($request['endDate'])) : '';
//        }
//        $list = $this->m_reports->getReport($filters);
//        $date = array_unique(array_column($list, "date"));
//        $country = array_unique(array_column($list, "country"));
//        $graph = array();
//        foreach ($country as $countryName) {
//
//            $graph[] = array("name" => $countryName, "data" => $this->parse($list, $countryName, $date, "earn"));
//        }
//        $data = array();
//        $data['y'] = array_values($date);
//        $data['x'] = $graph;
//        $data['gtype'] = "Earning ($)";
//        $data['sign'] = "$";
//        $data['title'] = "<b>Earning</b>";
//
//        echo json_encode($data);
//    }
//
    public function Earningstats() {

        $filters = array();
        $filters['groupby'] = "date";
        $filters['country'] = "TRUE";
        $filters['uid'] = UID;
        $request = $this->input->post();
        if ($request) {

            $this->load->model("advertiser/m_reports");

            switch ($request['type']) {
                case "today": $filters['startDate'] = date("Y-m-d", time());
                    $filters['endDate'] = date("Y-m-d", time());

                    break;
                case "yesterday": $filters['startDate'] = date("Y-m-d", strtotime('-1 day', strtotime(time())));
                    $filters['endDate'] = date("Y-m-d", strtotime('-1 day', strtotime(time())));

                    break;
                case "month":$filters['startDate'] = date("Y-m-01", time());
                    $filters['endDate'] = date("Y-m-t", time());


                    break;
                default:
                    break;
            }

            $list = $this->m_reports->getReport($filters);
            $earn = array_column($list, "earn");
            $earning = (float) round(array_sum($earn), 2);

            $json = array("earn" => $earning);
            echo json_encode($json);
        }
    }
    
    public function updates ()
    {
         $data = array();

       
        $data['PageContent'] = $this->load->view("advertiser/notification/v-all-noti", $data, TRUE);
        $this->load->view("advertiser/template", $data);
    }

//
//    function parse($list, $countryName, $date, $parseKey = 'clicks') {
//
//        $data_ser = array();
//        foreach ($date as $dat) {
//            foreach ($list as $listdata) {
//
//                if ($listdata['date'] == $dat && $listdata['country'] == $countryName) {
//                    $data_ser[$dat] = (float) round($listdata[$parseKey], 2);
//                } else {
//                    if (!isset($data_ser[$dat]))
//                        $data_ser[$dat] = 0;
//                }
//            }
//        }
//        return array_values($data_ser);
//    }
//
//    function createRange($startDate, $endDate) {
//        $tmpDate = new DateTime($startDate);
//        $tmpEndDate = new DateTime($endDate);
//
//        $outArray = array();
//        do {
//            $outArray[] = $tmpDate->format('Y-m-d');
//        } while ($tmpDate->modify('+1 day') <= $tmpEndDate);
//
//        return $outArray;
//    }
}
