<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_jobs
 *
 * @author kuldeep
 */
class m_jobs extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function getJobs($filters = array()) {

        $this->db->select("*")->from("job_schedular");
        if (isset($filters['job_id']) && $filters['job_id'] != '') {
            $this->db->where("job_id", $filters['job_id']);
        }
        if (isset($filters['status']) && $filters['status'] != '') {
            $this->db->where("status", $filters['status']);
        }
        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db->limit(10, (int) $filters['limit']);
        }

        return $this->db->get()->result_array();
    }

    public function UpdateJob($job = array(), $job_id = 0) {
        $this->db->where("job_id", $job_id);
        $this->db->update("job_schedular", $job);
        return $this->db->affected_rows();
        // return $this->db->insert_id();
    }

    public function UpdateCampaign($Campaign = array(), $campaign_id = 0) {

        if (is_array($campaign_id)) {
            $this->db->where_in("campaign_id", $campaign_id);
        } else {
            $this->db->where("campaign_id", $campaign_id);
        }

        $this->db->update("campaign", $Campaign);
        return TRUE;
        //$this->db->affected_rows();
    }

}
