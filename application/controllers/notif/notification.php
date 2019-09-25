<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of notify_mngr
 *
 * @author sandeep yadav    
 */
class notification extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library("common/com");
    }

    public function noti_change_status($noti_id = '', $status = 1) {
//        $this->load->model('admin/m_notify');
        if ($this->m_notify->noti_change_status($noti_id, $status)) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('success' => false));
        }
    }

    //affiliate part

    public function getNotification() {


        $request = $this->input->post();
        if ($request) {

            $request['uid'] = UID;
            if ((int) UTID == ADMIN) {
                $request['all'] = "all";
            }

            $request['status'] = 1;

            $request['limit'] = 1;
            $json = array();
            $json['success'] = TRUE;
            $json['notification'] = $this->m_notify->get_all_notifications($request);
            $json['new_notification'] = $this->m_notify->getNoNewNotifi($request)['total_new_noti'];

            echo json_encode($json);
        }
    }

    public function count_new_notification() {
        $request = $this->input->post();
        if ($request) {
            $json = array();
            $request['uid'] = UID;
            //$json['UTID'] = UTID;
            // $json['ADMIN'] =ADMIN;
            if ((int) UTID == ADMIN) {
                // $json['cond'] = "cond"; 
                $request['all'] = "all";
            }
            $request['status'] = 1;
            // $json = array();
            $json['success'] = TRUE;
            $json['new_notification'] = $this->m_notify->getNoNewNotifi($request)['total_new_noti'];

            echo json_encode($json);
        }
    }

    public function i_read_notification() {
        $request = $this->input->post();
        if ($request) {
            $json = array();
            $request['uid'] = UID;
            $this->m_notify->readNotification($request);
            $json['success'] = TRUE;
            $json['new_notification'] = $this->m_notify->getNoNewNotifi($request)['total_new_noti'];

            echo json_encode($json);
        }
    }

}
