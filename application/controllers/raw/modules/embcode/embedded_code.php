<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of embedded_code
 *
 * @author NexGen
 */
class embedded_code {

    //put your code here

    public $CI;

    public function __construct(CI_Controller &$CI) {
        // parent::__construct();
        $this->CI = $CI;
    }

    public function index($embeddedCode = array()) {

        if (empty($embeddedCode))
            return '';

        return $this->CI->load->view("modules/embcode/embeddedcode", $embeddedCode, TRUE);
    }

}
