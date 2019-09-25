<?php
 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of post
 *
 * @author NexGen
 */
class post extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();

        //check the login for user
        $this->load->library("common/com"); $this->com->is_advertiser(); 
//        $this->com->is_admin();
        //end

        $this->load->model("admin/m_category");
        $this->load->model("admin/m_post");
        $this->load->model("admin/m_website");
        $this->load->model("admin/m_campaign");

        $this->load->helper("form");
    }

    public function CreatePost() {
        $this->load->helper("form");
        $request = $this->input->post();

        if ($request) {

            $post = $request;
            $image = $this->do_upload("image");
            if (!isset($image['error'])) {
                $post['image'] = UPLOAD."post/".$image['upload_data']['file_name'];
            }

            $category_ids = isset($post['category_id']) ? $post['category_id'] : 0;
            $campaign_id = isset($post['campaign_id']) ? $post['campaign_id'] : 0;
            unset($post['category_id']);
            unset($post['campaign_id']);
            $json = array();
            $post_id = 0;
            if ($post_id = $this->m_post->CreatePost($post)) {
                if ($category_ids) {
                    if ($this->m_category->category_to_post($category_ids, $post_id)) {
                        $this->m_campaign->addpostToCampaign($campaign_id, $post_id);
                        $json['success'] = TRUE;
                        $json['msg'] = "Your new post is added.";
                    } else {
                        $json['success'] = FALSE;
                        $json['msg'] = "Your new post can't be added.";
                    }
                } else {
                    $json['success'] = FALSE;
                    $json['msg'] = "Your new post can't be added.";
                }
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your new post can't be added.";
            }

            echo json_encode($json);
            return;
        }


        $data = array();
        $data['FormAction'] = SITEURL . "advertiser/post/CreatePost";
        $data['SubmitBtn'] = "Create";
        $data['Submiting'] = "Creating...";
        $data['title'] = "Create a Post";

        $data['category'] = $this->m_category->getCategoryList();
        $data['website'] = $this->m_website->getWebsiteList();
        $filter = array();
        $filter['Formated'] = TRUE;
        $data['campaign'] = $this->m_campaign->getCampaign($filter);

//        echo '<pre>';
//        print_r($data['campaign']);
//        die();
        //$data['post'] = $this->m_post->getCategory(0,array("allchild"=>true));
        //$data['allCategory'] = $this->load->view("admin/post/all-post", $data, TRUE);
        $data['PageContent'] = $this->load->view("admin/post/add-post", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function UpdatePost($post_id = 0) {
        $this->load->helper("form");
        $request = $this->input->post();

        if ($request) {

            $post = $request;
            $image = $this->do_upload("image");
//            echo '<pre>';
//            print_r($image);
            if (!isset($image['error'])) {
                $post['image'] = UPLOAD."post/".$image['upload_data']['file_name'];
                //$post['image'] = $image['upload_data']['file_name'];
            }

            $category_ids = isset($post['category_id']) ? $post['category_id'] : '';
            $campaign_id = isset($post['campaign_id']) ? $post['campaign_id'] : 0;
            unset($post['category_id']);
            unset($post['campaign_id']);
            $json = array();
            //$post_id = 0;
            if ($this->m_post->UpdatePost($post, $post_id) || $this->m_category->category_to_post_update($category_ids, $post_id) || $this->m_campaign->updatepostTocampaign($campaign_id, $post_id)
            ) {

                $json['success'] = TRUE;
                $json['msg'] = "Your  post is update.";
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your  post can't be update.";
            }

            echo json_encode($json);
            return;
        }




        $data = array();
        $data['FormAction'] = SITEURL . "advertiser/post/UpdatePost/$post_id";
        $data['SubmitBtn'] = "Update";
        $data['Submiting'] = "Updating...";
        $data['title'] = "Update a Post";

        $data['post'] = $this->m_post->getPostForUpdate($post_id);

//        echo '<pre>';
//        print_r($data['post']);
//        die();

        $data['category'] = $this->m_category->getCategoryList();
        $data['website'] = $this->m_website->getWebsiteList();
        $filter['Formated'] = TRUE;
        $data['campaign'] = $this->m_campaign->getCampaign($filter);
        //$data['post'] = $this->m_post->getCategory(0,array("allchild"=>true));
        //$data['allCategory'] = $this->load->view("admin/post/all-post", $data, TRUE);
        $data['PageContent'] = $this->load->view("admin/post/add-post", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function deletepost($post_id = 0) {
        //create a user 

        $request = $this->input->post();

        if ($request) {
            $json = array();
            $post_id = $request['post_id'];
            // $request['status'] = isset($request['status']) ? 1 : 0;
            if ($this->m_post->deletepost($post_id)) {
                $json['success'] = TRUE;
                $json['msg'] = "Your post is deleted.";

                $json['data'] = $request;
            } else {
                $json['success'] = FALSE;
                $json['msg'] = "Your  canot be deleted.";
            }

            echo json_encode($json);
            return;
        }
    }

    public function show_post() {
        $data = array();
        $request = $this->input->post();
        if ($request) {
            
            $getRequest = $this->input->get();
            $request['limit'] = isset($getRequest['page']) ? $getRequest['page'] : 1;
            $data['posts'] = $this->m_post->getPost($request);

            echo json_encode($data['posts']);
            return;
        }

        $data['category'] = $this->m_category->getCategoryList();
        $data['website'] = $this->m_website->getWebsiteList();
        //$data['posts'] = $this->m_post->getPost();
        //$data['allCategory'] = $this->load->view("admin/post/all-post", $data, TRUE);
        $data['PageContent'] = $this->load->view("admin/post/all-post", $data, TRUE);
        $this->load->view("admin/template", $data);
    }

    public function getPostDataHttp() {

        $this->load->helper("advanced_html_dom");
        //$this->load->helper("simple_html_dom");

        $request = $this->input->post();
        if ($request) {
            $html = file_get_html($request['url']);
            $json = array();
            $json['title'] = $html->find("meta[property=og:title]")->getAttribute('content');
            $json['meta'] = $html->find("meta[property=og:description]")->getAttribute('content');
            $json['image'] = $html->find("meta[property=og:image]")->getAttribute('content');
            $json['success'] = TRUE;

            echo json_encode($json);
        }
    }

    public function do_upload($user_file, $folder = "post") {
        $data = array();

        $config['upload_path'] = APPPATH . "../upload/" . $folder;
        $config['allowed_types'] = 'gif|jpg|png|mp3';
//        $config['max_size'] = 100;
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
