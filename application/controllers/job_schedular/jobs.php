<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of jobs
 *
 * @author kuldeep
 */
class jobs extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        $this->load->model("job_schedular/m_jobs");
    }

    public function run($job_id = 0) {
        $filters = array();
        $data = array();
        if ($job_id) {
            $filters['job_id'] = $job_id;
        } else {
            $filters['status'] = 1;
            $filters['limit'] = 1;
        }
        $data['jobs'] = $this->m_jobs->getJobs($filters);

//        echo '<pre>';
//        print_r($data);
        if (!empty($data['jobs'])) {
            foreach ($data['jobs'] as $job) {

                $jobComplete = FALSE;
                if ($job['job_type'] == 1) {
                    if ($this->campaignJob($job['job_data'])) {
                        $jobComplete = TRUE;
                    }
                }

                if ($jobComplete) {
                    $Job = array();
                    $Job['status'] = 2;
                    $this->m_jobs->updateJob($Job, $job['job_id']);
                }
            }
        }
    }

    public function campaignJob($campaign = '') {

        $campaign = (array) json_decode($campaign);

        if (isset($campaign['campaign_id']) && isset($campaign['status'])) {

            $Campaign = array();
            $Campaign['status'] = $campaign['status'];
            $campaign_id = array();
            $campaign_id = $campaign['campaign_id'];

            return $this->m_jobs->UpdateCampaign($Campaign, $campaign_id);
        }

        return FALSE;
    }

}
