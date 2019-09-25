<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of csv
 * @Created on : Sep 16, 2015, 6:14:36 PM
 * @author Anup kumar
 * @Team NexGen PHP Development Team
 * @copyright (c) year, NexGen Innovators IT Services Pvt. Ltd.
 * @website http://nexgeninnovators.com
 * @location
 * @uses 
 */
class csv {

              // constructor
              private $super_object;

              public function __construct() {
                            // calling to parent constructor
                            $this->super_object = & get_instance();
              }

              /*

               * ["report_name"] : string will have report name
               * ["data"] : in form of array(array(),array());               */

              public function export_csv($report_data) {
                            $filename = $report_data['report_name'] . ".csv";
                            $fp = fopen('php://output', 'w');
                            header('Content-type: application/csv');
                            header('Content-Disposition: attachment; filename=' . $filename);
                            foreach ($report_data['data'] as $each_row) {
                               fputcsv($fp, $each_row);
                            }
                            //exit;
              }

              // start you function from here
}
