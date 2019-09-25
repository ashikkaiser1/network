<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of upload
 *
 * @author NexGen
 */
class m_upload extends CI_Controller {
    //put your code here
    public function do_upload($user_file, $folder = "offers") {
        $data = array();

        $config['upload_path'] = APPPATH . "../upload/" . $folder;
        $config['allowed_types'] = '*';
        $config['max_size'] = 2048000000;
//        $config['max_width'] = 1024;
//        $config['max_height'] = 768;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($user_file)) {
            $data = array('error' => $this->upload->display_errors());
//            echo '<pre>';
//            print_r($error);
            // $this->load->view('upload_form', $error); 
        } else {
            $data = array('upload_data' => $this->upload->data());
            // $this->load->view('upload_success', $data); 
        }

        return $data;
    }
}
