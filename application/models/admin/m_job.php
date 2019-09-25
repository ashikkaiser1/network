<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_job
 *
 * @author NexGen
 */
class m_job extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function CreateJob($job = array()) {
        $this->db->insert("job_schedular", $job);
        return $this->db->insert_id();
    }

    public function getJob($filters = array()) {

        $this->db->select("*");
        $this->db->from("job_schedular");

        if (isset($filters['job_id']) && $filters['job_id'] != '') {
            $this->db->where("job_id", $filters['job_id']);
            return $this->db->get()->row_array();
        }

        if (isset($filters['job_type']) && $filters['job_type'] != '') {
            $this->db->where("job_type", $filters['job_type']);
        }
        if (isset($filters['job_name']) && $filters['job_name'] != '') {
            $this->db->like("job_name", $filters['job_name']);
        }
        if (isset($filters['status']) && $filters['status'] != '') {
            $this->db->where("status", $filters['status']);
        }
        if (isset($filters['limit']) && $filters['limit'] != '') {
            $filters['limit'] = ($filters['limit'] - 1) * 10;
            $this->db->limit(10, (int) $filters['limit']);
        } else {
            // $this->db->limit(10, 0);
        }
        return $this->db->get()->result_array();
    }

    public function UpdateJob($job = array(), $job_id = 0) {
        if (is_array($job_id) && (!empty($job_id))) {
            $this->db->where_in("job_id", $job_id);
        }
        if (!is_array($job_id))
           $this->db->where("job_id", $job_id);

        $this->db->update("job_schedular", $job);
        return $this->db->affected_rows();
        // return $this->db->insert_id();
    }

}
