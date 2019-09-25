<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



$route['admin/'] = "admin/$1";
$route['advertiser/'] = "advertiser/$1";
$route['affiliate/usr_offer_link_postback/(.*)']="admin/usr_offer_link_postback/$1"; 
//$route['affiliate/aff_manager/'] = "affiliate/aff_manager/$1"; 
$route['util/offer_apis/(.*)'] = "util/offer_apis/$1"; 
$route['404_override'] = 'util/not_found/index';
$route['default_controller'] = "account/account";


/* End of file routes.php */
/* Location: ./application/config/routes.php */