<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of gencsv
 *
 * @author NexGen
 */
class gencsv extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com"); $this->com->is_affiliate();
        $this->load->library("reports/excel");

        //end
    }

    public function index() {
        $data = array();
        $data['PageContent'] = $this->load->view("affiliate/gencsv/v-gencsv", $data, TRUE);
        $this->load->view("affiliate/template", $data);
    }

    public function generateCSVfile() {
        $this->load->model("affiliate/m_links");
        $request = $this->input->post();
        if ($request) {
            $request['uid'] = UID;
            $links = $this->m_links->getLinks($request);
            $links = array_replace(array(0 => "Post Title", 1 => "Link"), $links);
            $file_name = date("Y-m-d") . "_" . uniqid() . "_" . "links.xls";
            $this->excel->stream_for_moremint($file_name, $links);

            $json = array("success" => TRUE,
                "fileLink" => UPLOAD . "../temp/$file_name");

            echo json_encode($json);
        }
    }

}
