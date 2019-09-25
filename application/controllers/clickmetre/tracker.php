<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tracker
 *
 * @author NexGen
 */
class tracker extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();

        $this->load->model("admin/m_tracker");
//        $this->load->model("admin/m_post");
        $this->load->library('user_agent');
        $this->load->helper("url");
    }

    public function index($short_url = '') {
       // $this->output->enable_profiler(TRUE);
        if ($short_url != '') {
            $link = $this->m_tracker->getLinkInfo(array("short_url" => $short_url));

            if (!empty($link) && $this->m_tracker->checkCampaing_status($link)) {
                //get post actual link for redirection
                unset($link['valid_date']);
                unset($link['status']);
                unset($link['AddUser']);
                unset($link['ModeUser']);
                unset($link['AddDateTime']);
                unset($link['ModeDateTime']);

                $link['browser'] = $this->agent->browser();
                $link['browser_version'] = $this->agent->version();
                $link['mobile'] = $this->agent->is_mobile() ? 1 : 0;
                $link['reffer_page'] = $this->agent->referrer();
                $link['mobname'] = $this->agent->mobile();
                $link['ip_address'] = $this->get_client_ip();
                $link['date'] = date("d-m-Y", time());
                $link['user_agent_str'] = $this->agent->agent_string();
                $link['country'] = "IN"; //json_decode(file_get_contents("http://ipinfo.io/{$link['ip_address']}"))->country;
                $link['transaction_id'] = bin2hex(mcrypt_create_iv(10, MCRYPT_DEV_URANDOM));
                $link['valid'] =1;
//                echo "<pre>";
//                print_r($link);
//                die();
                $post = $this->m_tracker->getPost(array("post_id" => $link['post_id']));
                if (!$this->agent->is_robot()) {
                    //track link by inserting
                    $clicktracker_id = $this->m_tracker->trackClick($link);
                }

  

                if (isset($post[0]) && isset($post[0]['url_slug'])) {
                    
                    $url = $this->get_url($link,$post); 
                    redirect($url);
                    ?>
                    <img width="1px" height="1px" src="<?php echo SITEURL . "clickmetre/tracker/clickvalid?click_id={$link['transaction_id']}" ?>"/>    
                    <script>
                        // Sets the new location of the current window.
                        //   window.location = "<?php echo $post[0]['url_slug'] . "&transaction_id={$link['transaction_id']}" ?>";
                          window.location = "<?php echo $url ?>";
                    </script>
                    <?php
                    //   redirect();
                }


//                echo '<pre>';
//
//                print_r($link);
            }
        }
    }
    
    public function get_url($link,$post) {
        //chancge macros accourding to data andmacros
        $url = $post[0]['url_slug'];
        if(!empty($link) && !empty($post))
        {
          $url = str_replace("{transaction_id}",$link['transaction_id'],$url);  
          $url = str_replace("{aff_id}",$link['uid'],$url);  
          //$url = str_replace("{transaction_id}",$link['transaction_id'],$url);  
        }
        return $url; 
        
    }
    
    public function pbtr() {
        
        //post back url  receiver
        $request = $this->input->get_post();
        if($request)
        {
            $transaction_id = isset($request['transaction_id']) ? $request['transaction_id'] : 0;
            $type = isset($request['type']) ? $request['type'] :0;
            $date = date("d-m-Y h:i:sa",time());
            $tr_data = array("transaction_id" => $transaction_id,
                              "type"=>$type,
                              "dateTime"=>$date);
            if($transaction_id && $type)
            {
                $this->m_tracker->pbtr($tr_data);
            }
        }
    }

    public function clickvalid() {
        //link for validate a lcik it is from image pixl
        $this->output->enable_profiler(TRUE);
        $request = $this->input->get();
        if ($request) {
            $transaction_id = isset($request['click_id']) ? $request['click_id'] : 0;
            if ($transaction_id) {
                $this->m_tracker->validClick($transaction_id);
            }
        }
    }


    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function fakeClick() {
        $filters = array();
        $filters['domain_id'] = 9;
        $link = $this->m_tracker->getLinkInfo($filters);

        for ($i = 0; $i < 10; $i++) {

            foreach ($link as $row) {


                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, $row['gen_link']);
                curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
                $query = curl_exec($curl_handle);
                curl_close($curl_handle);



                //file_get_contents();
            }
        }
    }

}
