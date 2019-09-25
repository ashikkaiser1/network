<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of job_schedule
 *
 * @author NexGen
 */
class job_schedule extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        //check the login for user
        $this->load->library("common/com"); $this->com->is_admin();
        //end
        $this->load->helper("form");
        $this->load->model("admin/m_job");
        $this->load->model("admin/m_campaign");
    }

    public function allJobs() {
        //show the avilabele campaignss....
        $data = array();
        $request = $this->input->post();
        if ($request) {
            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            $data['all_jobs'] = $this->m_job->getJob($request);
            echo json_encode($data);
            return;
        }
        $data['PageContent'] = $this->load->view("admin/job/v_alljob", '', TRUE);
        $this->load->view("admin/template", $data);
    }

    public function CreateJob() {

        //request starts
        $request = $this->input->post();
        if ($request) {
            $request['job_data'] = json_encode($request['job_data']);
            if ($this->m_job->CreateJob($request)) {
                $json = array("success" => TRUE, "msg" => "Success: Job Created!");
            } else {
                $json = array("success" => FALSE, "msg" => "Error: Job not Created!");
            }
            echo json_encode($json);
            return;
        }
        //request ends

        $data['FormAction'] = SITEURL . "admin/job_schedule/CreateJob";
        $data['SubmitBtn'] = "Create";
        $data['Submiting'] = "Creating...";
        $data['title'] = "Create new Job";

        $data['PageContent'] = $this->load->view("admin/job/add-job", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function updateJob($job_id = 0) {

        //request starts
        $request = $this->input->post();
        if ($request) {
            
            $request['job_data'] = json_encode($request['job_data']);
            
            if ($this->m_job->UpdateJob($request, $job_id)) {
                $json = array("success" => TRUE, "msg" => "Success: Job updated!");
            } else {
                $json = array("success" => FALSE, "msg" => "Error: Job not Updated!");
            }
            echo json_encode($json);
            return;
        }
        //request ends


        $data = array();
        $JobFilter = array();
        $JobFilter['job_id'] = $job_id;
        $data['jobs'] = $this->m_job->getJob($JobFilter);
        
        if($data['jobs']['job_type']==1)
        { 
            //campaign view
          $autoSelected = (array) json_decode($data['jobs']['job_data']);  
          $data['view'] = $this->getcampaignview($autoSelected);  
        }
        

        $data['FormAction'] = SITEURL . "admin/job_schedule/updateJob/" . $job_id;
        $data['SubmitBtn'] = "Update";
        $data['Submiting'] = "Updating...";
        $data['title'] = "Update Job";

        $data['PageContent'] = $this->load->view("admin/job/add-job", $data, TRUE);
        $this->load->view("admin/template", $data);
    }
    
    public function bulkupdate() {
        //Admin can bulk update the status of jobs
        $getRequest = $this->input->get();
        $json = array();
        $json['success'] = FALSE;
        $json['msg'] = "Incomplete Request..";
        if ($getRequest) {
            $request = $this->input->post();

            $request['status'] = isset($getRequest['status']) ? $getRequest['status'] : 0;
            $jobid = isset($request['job_id']) ? $request['job_id'] : 0;
            unset($request['job_id']);

            $JobData = array();
            $JobData['status'] = $request['status'];

            if ($this->m_job->UpdateJob($JobData, $jobid)) {
                $json['success'] = TRUE;
                $json['msg'] = "Update Complete";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Update Incomplete.";
            }
        }
        echo json_encode($json);
    }    

    public function getview() {
        $request = $this->input->post();
        $json = array();
        $json['success'] = false;
        if ($request) {
            switch ($request['job_type']) {
                case 1:
                    $json['success'] = true;
                    $json['view'] = $this->getcampaignview();
                    break;
                case 2:
                    '';
                    break;
                case 3:
                    '';
                    break;
                case 4:
                    '';
                    break;
                case 5:
                    '';
                    break;
            }
        }
        echo json_encode($json);
    }

    public function getcampaignview($autoSelect = array()) {
        $filter = array();
        $filter['Formated'] = TRUE;
        $filter['group_by'] = 'campaign_id';
        
        $filter['format'] = 'Formated';
        
        $data['campaign'] = $this->m_campaign->getCampaign($filter);
        $data['autoSelect'] = $autoSelect;
        return $this->load->view("admin/job/campaign_view", $data, TRUE);
    }

}
