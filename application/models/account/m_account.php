<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_account
 *
 * @author NexGen
 */
class m_account extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function getTimeZoneArray() {

        return $timezoneTable = array(
//             "" => "- Select Timezone -",
            "-12" => "(GMT -12:00) Eniwetok, Kwajalein",
            "-11" => "(GMT -11:00) Midway Island, Samoa",
            "-10" => "(GMT -10:00) Hawaii",
            "-9" => "(GMT -9:00) Alaska",
            "-8" => "(GMT -8:00) Pacific Time (US &amp; Canada)",
            "-7" => "(GMT -7:00) Mountain Time (US &amp; Canada)",
            "-6" => "(GMT -6:00) Central Time (US &amp; Canada), Mexico City",
            "-5" => "(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima",
            "-4" => "(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz",
            "-3.5" => "(GMT -3:30) Newfoundland",
            "-3" => "(GMT -3:00) Brazil, Buenos Aires, Georgetown",
            "-2" => "(GMT -2:00) Mid-Atlantic",
            "-1" => "(GMT -1:00) Azores, Cape Verde Islands",
            "0" => "(GMT) Western Europe Time, London, Lisbon, Casablanca",
            "1" => "(GMT +1:00) Brussels, Copenhagen, Madrid, Paris",
            "2" => "(GMT +2:00) Kaliningrad, South Africa",
            "3" => "(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg",
            "3.5" => "(GMT +3:30) Tehran",
            "4" => "(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi",
            "4.5" => "(GMT +4:30) Kabul",
            "5" => "(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent",
            "5.5" => "(GMT +5:30) Bombay, Calcutta, Madras, New Delhi",
            "6" => "(GMT +6:00) Almaty, Dhaka, Colombo",
            "7" => "(GMT +7:00) Bangkok, Hanoi, Jakarta",
            "8" => "(GMT +8:00) Beijing, Perth, Singapore, Hong Kong",
            "9" => "(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk",
            "9.5" => "(GMT +9:30) Adelaide, Darwin",
            "10" => "(GMT +10:00) Eastern Australia, Guam, Vladivostok",
            "11" => "(GMT +11:00) Magadan, Solomon Islands, New Caledonia",
            "12" => "(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka"
        );



        return array(
            "" => "- Select Timezone -",
            "-11" => "UTC-11",
            "-10" => "UTC-10",
            "-9" => "UTC-9",
            "-8" => "UTC-8",
            "-7" => "UTC-7",
            "-6" => "UTC-6",
            "-5" => "UTC-5",
            "-4" => "UTC-4",
            "-3" => "UTC-3",
            "-2" => "UTC-2",
            "-1" => "UTC-1",
            "0" => "UTC0",
            "1" => "UTC+1",
            "2" => "UTC+2",
            "3" => "UTC+3",
            "4" => "UTC+4",
            "5" => "UTC+5",
            "5.5" => "UTC+5.5",
            "6" => "UTC+6",
            "7" => "UTC+7",
            "8" => "UTC+8",
            "9" => "UTC+9",
            "10" => "UTC+10",
            "11" => "UTC+11");
    }

    public function getUser($filter = array()) {

        $this->db->select("u.*,ut.*")->from("users u");
        $this->db->join("usertype ut", "ut.UTID=u.UTID", "LEFT");


        if (isset($filter['email']) && $filter['email'] != '') {
            $this->db->where(array("u.email" => $filter['email'], "u.password" => $filter['password']));
        } else {
            $this->db->where(array("u.username" => $filter['username'], "u.password" => $filter['password']));
        }
//        $this->db->or_where(array("u.email" => $filter['username'], "u.password" => $filter['password']));
        
        if (isset($filter['check_status']) && $filter['check_status'] != '') {
            
//            $this->db->where("u.status", 1);
        }
        else
        {
            $this->db->where("u.status", 1);
        }
        
        return $this->db->get()->row_array();
    }

    public function checkInvitation($invite = array()) {
        $this->db->select("inv.*")->from("invite inv");
        $this->db->where(array("inv.in_code" => $invite['in_code']));
        $this->db->where("inv.in_valid", 0);
        $invitedata = $this->db->get()->row_array();
        if (!empty($invitedata))
            return TRUE;
        return FALSE;
    }

    public function checkedCodeUsed($invite = array()) {
        $this->db->select("u.in_code")->from("users u");
        $this->db->where(array("u.in_code" => $invite['in_code']));
        $invitedata = $this->db->get()->row_array();
        if (!empty($invitedata))
            return FALSE;
        return TRUE;
    }

    public function inviteMe($invite = array()) {
        $this->db->insert("invite", $invite);
        return $this->db->insert_id();
    }

    public function checkCodeExist($in_code = '') {

        $this->db->select("inv.in_code")->from("invite inv");
        $this->db->where(array("inv.in_code" => $in_code));
        $invitecode = $this->db->get()->row_array();
        if (!empty($invitecode))
            return TRUE;
        return FALSE;
    }

    public function getaUser($userName = '') {
        $this->db->select("u.username")->from("users u");
        $this->db->where(array("u.username" => $userName));
        $user = $this->db->get()->row_array();

        //if user exist then the $user array not blank
        if (!empty($user))
            return TRUE;
        return FALSE;
    }

    public function getUserType($filter = array()) {
        //getuser type fro user type table
        $this->db->select("*")->from("usertype");
        $result = $this->db->get()->result_array();
        $list = array();
        if (isset($filter['formated']) && $filter['formated'] != '') {
            if (!empty($result)) {
                foreach ($result as $row) {

                    $list[$row['UTID']] = $row['usertype_name'];
                }
            }
            return $list;
        }

        return $result;
    }

    public function getaEmail($Email = '') {
        $this->db->select("u.username")->from("users u");
        $this->db->where(array("u.email" => $Email));
        $user = $this->db->get()->row_array();
        if (!empty($user))
            return TRUE;
        return FALSE;
    }

    public function getEmailbyin_code($in_code = '') {

        $this->db->select("inv.in_email")->from("invite inv");
        $this->db->where(array("inv.in_code" => $in_code));
        $invitecode = $this->db->get()->row_array();
        if (!empty($invitecode))
            return $invitecode['in_email'];
        return FALSE;
    }

    public function reset_password($password = array(), $email = '') {
        $this->db->where("email", $email);
        $this->db->update("users", $password);
        return $this->db->affected_rows();
    }

    public function some_one_reffer_me($refferal = array()) {
        //this function is used for save the referals oof users and their amount on per refers.
        //columns are uid , ref_uid ,amt and remarks , remarks and status is for admin if the approved the
        //refereal is valida or not.
        $this->db->insert("usr_referals", $refferal);
        return $this->db->insert_id();
    }

    public function getUserByRefferalID($ref_id = 0) {
        if ($ref_id != '' && $ref_id != 0) {
            $this->db->select("uid")->from("users");
            $this->db->where("ref_id", $ref_id);
            return $this->db->get()->row_array();
        }
        return FALSE;
    }

    public function getofferCategory($filters = array()) {


        $this->db->select("*")->from("offer_category");
        $result = $this->db->get()->result_array();
        $list = array();
        if (!empty($result)) {
            foreach ($result as $row) {

                $list[$row['offer_cat_id']] = $row['title'];
            }
        }
        return $list;
    }

    public function gettraficType($filters = array()) {


        $this->db->select("*")->from("traffic_type");
        $result = $this->db->get()->result_array();
        $list = array();
        if (!empty($result)) {
            foreach ($result as $row) {

                $list[$row['trafic_type_id']] = $row['title'];
            }
        }
        return $list;
    }

    public function getOfferType($filters = array()) {


        $this->db->select("*")->from("offer_type");
        $result = $this->db->get()->result_array();
        $list = array();
        if (!empty($result)) {
            foreach ($result as $row) {

                $list[$row['offer_type_id']] = $row['title'];
            }
        }
        return $list;
    }

    public function getCountry($filters = array()) {


        $this->db->select("*")->from("country");
        $result = $this->db->get()->result_array();
        $country = array();
        if (!empty($result)) {
            foreach ($result as $row) {

                $country[$row['id']] = "(" . $row['iso'] . ") " . $row['nicename'];
            }
        }
        return $country;
    }

}
