<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['(:num)']			 = 'user/index/$1';
$route['user/form-add']  	 = 'user/form_add';
$route['user/form-edit'] 	 = 'user/form_edit';
$route['default_controller'] = 'user';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
