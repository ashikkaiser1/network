<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of offer_approval
 *
 * @author NexGen
 */
class offer_permission extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();

        //check the login for user
        $this->load->library("common/com"); $this->com->is_admin();
        //end
        $this->load->model("admin/m_campaign");
        $this->load->model("admin/m_users");

        $this->load->model("admin/m_offer_permission");
    }

    public function getOfferPublisher() {

        $request = $this->input->get();
        $data = array();
        $data['success'] = FALSE;
        if ($request) {
            //$request['status'] = 1;
            //1 status for approved publisher.
            //0 for block and not in table means the pblisher 
            //is unapproved

            $approvedpub = array_column($this->m_offer_permission->getOfferUsers($request), "uid");

            //publisher 
            if (!empty($approvedpub)) {

                $pub_filter = array();
                $pub_filter['listFormated'] = "TRUE";
                $pub_filter['UTID'] = AFFILIATE;

                $pub_filter['uid'] = $approvedpub;
                $data['publisher'] = $this->m_users->getUsers($pub_filter);
                unset($data['publisher']['']);
                $data['success'] = TRUE;
            }

//             echo '<pre>';
//            print_r($data);
//            return;
            echo json_encode($data);
        }
    }

    public function getUnApprovedPublisher() {

        $request = $this->input->get();
        $data = array();
        $data['success'] = FALSE;
        if ($request) {

            if (isset($request['status']) && $request['status'] == '')
                unset($request['status']);
            $request['status'] = 1;
            //1 status for approved publisher.
            //0 for block and not in table means the pblisher 
            //is unapproved

            $approvedpub = array_column($this->m_offer_permission->getOfferUsers($request), "uid");
            //status 2 and 3 is used for unapproved and 3 reject
            //get all  user ids that are aunapproved and rejected.
            $request['status'] = array(2,3);
            $unapprovedpub = array_column($this->m_offer_permission->getOfferUsers($request), "uid");
          
            //publisher 
           // if (!empty($approvedpub)) {
                $pub_filter = array();
                $pub_filter['listFormated'] = "TRUE";
                $pub_filter['UTID'] = AFFILIATE;
                $pub_filter['ex_uid'] = $approvedpub;
                $pub_filter['in_uids'] = $unapprovedpub;
                $data['publisher'] = $this->m_users->getUsers($pub_filter);
                unset($data['publisher']['']);
                $data['success'] = TRUE;
           // }
//            echo '<pre>';
//            print_r($data);
//            return;
            echo json_encode($data);
        }
    }

    public function setApprovePublisher() {
        //call from Offer page
        //and from Generate Publisher Link
        $request = $this->input->post();

        $json = array();

        if ($request) {
            $uids = isset($request['uid']) ? $request['uid'] : array();
            $camapign_id = isset($request['campaign_id']) ? $request['campaign_id'] : 0;
            $status = isset($request['status']) ? $request['status'] : 0;

            if ($this->m_offer_permission->setApprovePublisher($uids, $camapign_id, $status)) {
                $json['success'] = TRUE;
                $json['msg'] = "Action performed successfully.";
            } else {
                $json['success'] = TRUE;
                $json['msg'] = "Action performed not successfully.";
            }
        }
        
        echo json_encode($json);
    }

}
