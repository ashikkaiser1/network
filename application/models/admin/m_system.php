<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_system
 *
 * @author NexGen
 */
class m_system extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->db_reader = $this->load->database("db_reader", TRUE);
    }

    public function getOS() {
        //Data of OS for Drop Down

        return array(
            'AIX' => 'AIX',
            'AND' => 'Android',
            'AMG' => 'AmigaOS',
            'ATV' => 'Apple TV',
            'ARL' => 'Arch Linux',
            'BTR' => 'BackTrack',
            'SBA' => 'Bada',
            'BEO' => 'BeOS',
            'BLB' => 'BlackBerry OS',
            'QNX' => 'BlackBerry Tablet OS',
            'BMP' => 'Brew',
            'CES' => 'CentOS',
            'COS' => 'Chrome OS',
            'CYN' => 'CyanogenMod',
            'DEB' => 'Debian',
            'DFB' => 'DragonFly',
            'FED' => 'Fedora',
            'FOS' => 'Firefox OS',
            'FIR' => 'Fire OS',
            'BSD' => 'FreeBSD',
            'GNT' => 'Gentoo',
            'GTV' => 'Google TV',
            'HPX' => 'HP-UX',
            'HAI' => 'Haiku OS',
            'IRI' => 'IRIX',
            'INF' => 'Inferno',
            'KNO' => 'Knoppix',
            'KBT' => 'Kubuntu',
            'LIN' => 'GNU/Linux',
            'LBT' => 'Lubuntu',
            'VLN' => 'VectorLinux',
            'MAC' => 'Mac',
            'MAE' => 'Maemo',
            'MDR' => 'Mandriva',
            'SMG' => 'MeeGo',
            'MCD' => 'MocorDroid',
            'MIN' => 'Mint',
            'MLD' => 'MildWild',
            'MOR' => 'MorphOS',
            'NBS' => 'NetBSD',
            'MTK' => 'MTK / Nucleus',
            'WII' => 'Nintendo',
            'NDS' => 'Nintendo Mobile',
            'OS2' => 'OS/2',
            'T64' => 'OSF1',
            'OBS' => 'OpenBSD',
            'PSP' => 'PlayStation Portable',
            'PS3' => 'PlayStation',
            'RHT' => 'Red Hat',
            'ROS' => 'RISC OS',
            'REM' => 'Remix OS',
            'RZD' => 'RazoDroiD',
            'SAB' => 'Sabayon',
            'SSE' => 'SUSE',
            'SAF' => 'Sailfish OS',
            'SLW' => 'Slackware',
            'SOS' => 'Solaris',
            'SYL' => 'Syllable',
            'SYM' => 'Symbian',
            'SYS' => 'Symbian OS',
            'S40' => 'Symbian OS Series 40',
            'S60' => 'Symbian OS Series 60',
            'SY3' => 'Symbian^3',
            'TDX' => 'ThreadX',
            'TIZ' => 'Tizen',
            'UBT' => 'Ubuntu',
            'WTV' => 'WebTV',
            'WIN' => 'Windows',
            'WCE' => 'Windows CE',
            'WIO' => 'Windows IoT',
            'WMO' => 'Windows Mobile',
            'WPH' => 'Windows Phone',
            'WRT' => 'Windows RT',
            'XBX' => 'Xbox',
            'XBT' => 'Xubuntu',
            'YNS' => 'YunOs',
            'IOS' => 'iOS',
            'POS' => 'palmOS',
            'WOS' => 'webOS'
        );
    }

    public function getDevices() {

        return array(
            0 => 'Desktop',
            1 => 'Phone',
            2 => 'Tablet');
    }

    public function SetSetting($Setting = array()) {

        if (!empty($Setting)) {
            $this->db->insert_on_duplicate_update_batch("sys_option", $Setting, " so_id=LAST_INSERT_ID(so_id)");
        }

        return TRUE;
    }

    public function update_settings($setting = array(), $option_name = '') {

        if ($option_name != '') {

            $this->db->update('sys_option', $setting, array("option_name" => $option_name));
            return $this->db->affected_rows();
        }
        return FALSE;
    }

    public function getSettings($filters = array()) {


        $this->db_reader->select("*")->from("sys_option");


        if (isset($filters['Formated']) && $filters['Formated'] != '') {
            $result = $this->db_reader->get()->result_array();
            $list = array();
//            $list[0] = "Not Now";
            if (!empty($result)) {
                foreach ($result as $row) {
                    $list[$row['option_name']] = $row['option_value'];
                }
            }

            return $list;
        }

        return $this->db_reader->get()->result_array();
    }

    public function get_permissions($uid) {

        $this->db_reader->select("pm.link,up.p_id")->from("usr_permissions up");
        $this->db_reader->join("permission_master pm", "pm.p_id=up.p_id", "LEFT");
        $this->db_reader->where("up.uid", $uid);
        $this->db_reader->order_by("up.usr_per_id", "ASC");
        return $this->db_reader->get()->result_array();
    }

    public function get_aff_manager_menus($uid, $parent_id) {

        $this->db_reader->select("*")->from("usr_permissions up");
        $this->db_reader->join("permission_master pm", "pm.p_id=up.p_id", "LEFT");
        $this->db_reader->where("pm.parent_id", $parent_id);
        $this->db_reader->where("up.uid", $uid);
        $this->db_reader->order_by("pm.sort", "ASC");
        $result = $this->db_reader->get()->result_array();
        if (!empty($result)) {
            foreach ($result as $key => $row) {
                $result[$key]['child'] = $this->get_aff_manager_menus($uid, $row['p_id']);
            }
        }
        return $result;
    }

    public function init_system($system_options = array()) {


        foreach ($system_options as $option_name => $option_value) {
            if (!defined($option_name) && (isset($option_value) && $option_value != ''))
                define($option_name, $option_value);
        }

//
//
//        if (!defined("SITEURL") && (isset($system_options['SITEURL']) && $system_options['SITEURL'] != ''))
//            define("SITEURL", $system_options['SITEURL']);
//
//        if (!defined("HOST") && (isset($system_options['HOST']) && $system_options['HOST'] != ''))
//            define("HOST", $system_options['HOST']);
//
//        if (!defined("ASSETS") && (isset($system_options['ASSETS']) && $system_options['ASSETS'] != ''))
//            define("ASSETS", $system_options['ASSETS']);
//
//        if (!defined("UPLOAD") && (isset($system_options['UPLOAD']) && $system_options['UPLOAD'] != ''))
//            define("UPLOAD", $system_options['UPLOAD']);
//
//        if (!defined("EMAIL_ACC") && (isset($system_options['EMAIL_ACC']) && $system_options['EMAIL_ACC'] != ''))
//            define("EMAIL_ACC", $system_options['EMAIL_ACC']);
//
//        if (!defined("CURR") && (isset($system_options['CURR']) && $system_options['CURR'] != ''))
//            define("CURR", $system_options['CURR']);
//
//        if (!defined("IMP_URL") && (isset($system_options['IMP_URL']) && $system_options['IMP_URL'] != ''))
//            define("IMP_URL", $system_options['IMP_URL']);
//
//        if (!defined("CONV_PIXEL") && (isset($system_options['CONV_PIXEL']) && $system_options['CONV_PIXEL'] != ''))
//            define("CONV_PIXEL", $system_options['CONV_PIXEL']);
    }

    public function get_main_menus($parent_id = 0) {

//        $this->db->select("")

        $this->db_reader->select("*")->from("permission_master");
        $this->db_reader->where("parent_id", $parent_id);
        $this->db_reader->order_by("sort", "ASC");
        $result = $this->db_reader->get()->result_array();
        if (!empty($result)) {

            foreach ($result as $key => $row) {

                $result[$key]['child'] = $this->get_main_menus($row['p_id']);
            }
        }

        return $result;
    }

}
