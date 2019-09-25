<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of c_right
 *
 * @author kuldeep
 */
class c_right {

    private $id = "Right";
    public $CI;

    public function __construct(CI_Controller &$CI) {
        //parent::__construct();
        // echo "Hello";
        $this->CI = $CI;
        $this->CI->load->model("common/module", "module");
    }

    public function index() {
        // return "Top";
        $response = "";
        $modules = $this->CI->module->load($this->id, $this->CI->page);

        foreach ($modules as $module) {

            $response.=$this->CI->load_controller('modules/' . $module['module_class'], "index", $module);
        }
        return $response;
    }

}
