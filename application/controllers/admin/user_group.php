<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user_group
 *
 * @author NexGen
 */
class user_group extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com"); $this->com->is_admin();
        //end
        $this->load->model("admin/m_users");
        $this->load->model("admin/m_user_group");
        $this->load->model("account/m_account");
        $this->load->helper("form");
    }

    public function CreateGroup($UTID = AFFILIATE) {


        $request = $this->input->post();

        if ($request) {//creaeting goals 
            $json = array();

            $group = array();
            $group['gstatus'] = isset($request['gstatus']) ? $request['gstatus'] : 0;
            $group['gname'] = isset($request['gname']) ? $request['gname'] : '';
            $group_id = 0;
            if ($group_id = $this->m_user_group->CreateGroup($group)) {

                $uids = isset($request['uid']) ? $request['uid'] : array();
                if ($group_id) {
                    $this->m_user_group->setUserTogroup($uids, $group_id);
                }

                $json['success'] = TRUE;
                $json['msg'] = "New Group created";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Group not created";
            }

            echo json_encode($json);
            return;
        }


        $group_members = array_column($this->m_user_group->getGroupMembers(), "uid");

        $filter = array();
        if ($UTID)
            $filter['UTID'] = $UTID;
        $filter['listFormated'] = "TRUE";
        $filter['ex_uid'] = $group_members;
        $data['users'] = $this->m_users->getUsers($filter);

        $data['FormAction'] = SITEURL . "admin/user_group/CreateGroup";
        $data['FormSubmitBtn'] = "Save";
        $data['SubmitAction'] = "Creating...";
        $data['panel_title'] = "Add New Group";
        $data['allgroupLink'] = SITEURL . "admin/user_group/showGroup/";
        $data['allgroupTitle'] = "All Groups";

        $data['status'] = array("1" => "Active", "0" => "Inactive", "2" => "Pending", "3" => "Block", "4" => "Reject");

        // $data['UTID'] = $UTID;

        $data['PageContent'] = $this->load->view("admin/user_group/add-user-group", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function UpdateGroup($UTID = AFFILIATE, $group_id = 0) {


        $request = $this->input->post();
        $data = array();
        if ($request) {//creaeting goals 
            $json = array();

            $group = array();
            $group['gstatus'] = isset($request['gstatus']) ? $request['gstatus'] : 0;
            $group['gname'] = isset($request['gname']) ? $request['gname'] : '';

            $uids = isset($request['uid']) ? $request['uid'] : array();
            if ($group_id) {
                $this->m_user_group->setUserTogroup($uids, $group_id);
            }
            $group['gdateTime'] = date('d-m-Y h:s a');
            if ($this->m_user_group->UpdateGroup($group, $group_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "New Group Updated";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Group not Updated";
            }

            echo json_encode($json);
            return;
        }

        $gFilter = array();
        $gFilter['group_id'] = $group_id;
        $data['group_members'] = array_column($this->m_user_group->getGroupMembers($gFilter), "uid");


        $data['group'] = $this->m_user_group->getUserGroup($gFilter);

//        echo '<pre>';
//        print_r( $data['group']);

        $filter = array();
        if ($UTID)
            $filter['UTID'] = $UTID;
        $filter['listFormated'] = "TRUE";
        // $filter['ex_uid'] = $group_members;
        $data['users'] = $this->m_users->getUsers($filter);

        $data['FormAction'] = SITEURL . "admin/user_group/UpdateGroup/" . $UTID . "/" . $group_id;
        $data['FormSubmitBtn'] = "Update";
        $data['SubmitAction'] = "Update...";
        $data['panel_title'] = "Update Group";
        $data['allgroupLink'] = SITEURL . "admin/user_group/showGroup/";
        $data['allgroupTitle'] = "All Groups";

        $data['status'] = array("1" => "Active", "0" => "Inactive", "2" => "Pending", "3" => "Block", "4" => "Reject");

        // $data['UTID'] = $UTID;

        $data['PageContent'] = $this->load->view("admin/user_group/add-user-group", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function showGroup() {

        $data = array();
        $data['AddgroupLink'] = SITEURL . "admin/user_group/CreateGroup/";
        $data['AddgroupTitle'] = "Add Group";

        //$filters = array();
        $data['group'] = $this->m_user_group->getUserGroup();
        $data['PageContent'] = $this->load->view("admin/user_group/show-user-group", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function deleteGroup() {

        $request = $this->input->post();
        $json = array();
        if ($request) {

            if ($this->m_user_group->deleteGroup($request)) {
                $json['success'] = TRUE;
                $json['msg'] = "Deleted";
            } else {
                $json['success'] = TRUE;
                $json['msg'] = "Deleted";
            }
        }

        echo json_encode($json);

        return;
    }

    public function deleteGroupMember() {

        $request = $this->input->post();
        $json = array();
        if ($request) {

            if ($this->m_user_group->deleteGroupMember($request)) {
                $json['success'] = TRUE;
                $json['msg'] = "Deleted";
            } else {
                $json['success'] = TRUE;
                $json['msg'] = "Deleted";
            }
        }

        echo json_encode($json);

        return;
    }

    public function getGroupMembers() {

        $request = $this->input->post();
        $data = array();
        if ($request) {
            $group_members = array_column($this->m_user_group->getGroupMembers($request), "uid");
            if (!empty($group_members)) {
                $filter = array();
                // $filter['listFormated'] = "TRUE";
                $filter['uid'] = $group_members;
                $data['users'] = $this->m_users->getUsers($filter);
                $data['success'] = TRUE;
            } else {
                $data['success'] = FALSE;
            }
        } else {
            $data['success'] = FALSE;
        }

        echo json_encode($data);
    }

}
