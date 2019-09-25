<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

        $this->load->library("common/com"); $this->com->is_admin();

        $this->load->helper("url");
        $this->load->helper('form');
//        $this->load->model('admin/m_notify');
        //  $this->load->model("publisher/utility", "util_model");
    }

    //function to show add new notification form
    public function CreateNoti() {

        $data['title'] = "Add Notification";
        //  

        $request = $this->input->post();

        if ($request) {
            if ($this->m_notify->save_notification($request)) {
                $json = array("success" => TRUE, "msg" => "Success: Notification Saved!");
            } else {
                $json = array("success" => FALSE, "msg" => "Error: Notification not Saved!");
            }

            echo json_encode($json);
            return;
        }
        $data['Formaction'] = SITEURL . "admin/notification/CreateNoti";


        $data['Submiting'] = "Creating..";


        $data['PageContent'] = $this->load->view("admin/notification/v-add-update-notify", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    //function to update the notification details

    public function update_notification($noti_id = 0) {

        $request = $this->input->post();

        $data['title'] = "Update Notification";

        $json = array("success" => FALSE);
        $data['action'] = "update_notification";

//        $this->load->model('admin/m_notify');

        if ($request) {

            if ($this->m_notify->update_notification($request, $noti_id)) {
                $json = array("success" => TRUE, "msg" => "Success: Notification Updated!", "data" => $noti_id);
            } else {
                $json = array("success" => TRUE, "msg" => "Error: Notification not Updated!");
            }

            echo json_encode($json);
            return;
        }

        $data['notification'] = $this->m_notify->get_notification_by_id($noti_id);
        $data['Formaction'] = SITEURL . "admin/notification/update_notification/" . $noti_id;


        $data['Submiting'] = "Updating..";


        $data['PageContent'] = $this->load->view("admin/notification/v-add-update-notify", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    //function to view and manage ie. change status, update, delete notifications
    public function allNotification() {

        $data['title'] = "All Notifications";
        //
        $request = $this->input->post();
         $getRequest = $this->input->get();
        if ($request || $getRequest) {
            $this->load->model('admin/m_notify');
            $request['uid'] = UID;
            if (UTID == ADMIN) {
                $request['all'] = "all";
            }
            
           
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            
            $data['notifications'] = $this->m_notify->get_all_notifications($request);

            echo json_encode($data['notifications']);
            return;
        }

        $data['PageContent'] = $this->load->view("admin/notification/all-notification", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function delete_notification() {

        $notification_id = $this->input->post();
        if ($notification_id) {
//            $this->load->model('admin/m_notify');

            if ($this->m_notify->delete_notification($notification_id['noti_id'])) {
                echo json_encode(array('success' => TRUE, 'msg' => 'Notification Deleted!'));
            } else {
                echo json_encode(array('success' => FALSE, 'msg' => 'Error: Notification not Deleted!'));
            }
            return;
        }
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
}
