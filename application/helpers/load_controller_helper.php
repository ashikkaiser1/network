<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('load_controller')) {

    function load_controller($path, $method = 'index',$param=array()) {

       
        $controller = basename($path);
        $path = str_replace($controller, "", $path);
        
        require_once(FCPATH . APPPATH . 'controllers/' .$path. $controller . '.php');

       
        $controller = new $controller();

        return $controller->$method($param);
    }

}