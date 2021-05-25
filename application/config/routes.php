<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	http://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There area two reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router what URI segments to use if those provided
  | in the URL cannot be matched to a valid route.
  |
 */
 
 
/************************** USER ROUTES ******************************/

$route['default_controller'] = "admin/login";
$route['404_override'] = '';

/****************************login ****************************** */
$route['admin/login'] = 'admin/login/index';
$route['admin/check_login'] = 'admin/login/check_login';
$route['logout'] = 'admin/login/logout';

/**************************** admin dashboard ****************************** */

$route['admin/dashboard'] = 'admin/dashboard/index';


$route['manage_profile'] = 'admin/admin/manage_profile';

/***********************************settings ********************** */
/****************************************  change password ***************/
$route['admin/change-password'] = 'admin/setting/change_password';
$route['check_old_password']='admin/setting/check_old_password';
/*******************************email setting *********************** */
$route['admin/email_setting'] = 'admin/setting/email_setting';


/***************************************** forgot pass route ***************************************/
$route['admin/forgot-password'] = "admin/setting/forgot_password";
$route['admin/forgot-new-password/(:any)/(:any)'] = "admin/setting/forgot_new_password/$1/$2";
$route['admin/set-new-password'] = "admin/setting/set_new_password_forgot";

/**************************user view ******************************/

$route['admin/user_view'] = 'admin/users/user_view';

$route['admin/user_list_view'] = 'admin/users/user_list_view';
$route['admin/user_add'] = 'admin/users/user_add';

$route['admin/email_check'] = 'admin/users/email_check';
$route['admin/user_edit/(:any)'] = 'admin/users/user_edit/$1';
$route['admin/get_permission_data'] = 'admin/users/get_permission_data';
$route['admin/deactive_user']= 'admin/users/deactive_user';


$route['admin/contact_view']= 'admin/contact/contact_view';
$route['admin/contact_view_list'] = 'admin/contact/contact_view_list';
$route['admin/deactive_contact'] = 'admin/contact/deactive_contact';

$route['admin/faq_view']= 'admin/faq/faq_view';
$route['admin/faq_view_list'] = 'admin/faq/faq_view_list';
$route['admin/deactive_faq'] = 'admin/faq/deactive_faq';
$route['admin/delete_faq'] = 'admin/faq/delete_faq';
$route['admin/add_faq'] = 'admin/faq/add_faq';




