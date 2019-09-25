<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of offer_export
 *
 * @author NexGen
 */
class offer_export extends CI_Controller {

    //put your code here

    private $coloums = array("campaign_id" => "Offer Id",
        "Add_User" => "Add User",
        "Mode_DateTime" => "Mode DateTime",
        "Mode_User" => "Mode User",
        "Revenue_TypeName" => "Revenue TypeName",
        "advertiser_id" => "advertiser id",
        "campaign_name" => "campaign name",
        "cap" => "cap",
        "cat_Name" => "cat Name",
        "country_Name" => "country Name",
        "c_type" => "c type",
        "end_date" => "end date",
        "c_status" => "c status",
        "featured" => "cfeatured",
        "name" => "name",
        "payOut_TypeName" => "payOut TypeName",
        "payout_cost" => "payout cost",
        "payout_type" => "payout type",
        "preview_link" => "preview link",
        "redirect_Url" => "redirect Url",
        "redirection" => "redirection",
        "req_approval" => "req approval",
        "revenue_cost" => "revenue cost",
        "revenue_type" => "revenue type",
        "start_date" => "start date",
        "status" => "status",
        "uid" => "uid",
    );
    
 private $coloums1= array("uid" => "u Id",
        "UTID" => "UT ID",
        "manager" => "manager ",
        "username" => "username ",
      "name" => "name ",
     "email" => "email ",
     "contact" => "contact ", 
     "contact_time" => "contact time ",
      "contact_timezone" => "contact timezone ",
      "contact_am" => "contact am ",
      "skype_id" => "skype id ",
      "timeZone" => "timeZone ",
      "global" => "global ",
      "company" => "company ",
      "password" => "password ",
      "re_password" => "re password ",
      "aff_id" => "aff id ",
      "country_id" => "country id ",
     "address" => "address ",
     "offer_workwith" => "offer workwith ", 
     "offer_specific" => "offer specific ",
      "bank_name" => "bank name ",
      "IFSC_code" => "IFSC code ",
      "bank_account" => "bank account ",
      "PAN" => "PAN ",
      "swift_code" => "swift code ",
      "bank_verification_status" => "bank verification status ",
      "DOJ" => "DOJ ",
      "in_code" => "in code ",
     "verified" => "verified ",
      "AddUser" => "AddUser ",
     "ModeUser" => "ModeUser ",
     "ModeDateTime" => "ModeDateTime ", 
     "status" => "status ",
     
     
     
     
     
     );
 
    public function __construct() {
        parent::__construct();

        //check the login for user
        $this->load->library("common/com"); $this->com->is_admin();
        //end
    }

    public function index() {
        $data = array();
        $data['dataSelection'] = $this->coloums;
         $data['dataSelection1'] = $this->coloums1;
        $data['PageContent'] = $this->load->view("admin/offer/export/export", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

}
