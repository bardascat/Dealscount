<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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

$route['default_controller'] = "landing";
$route['admin'] = "admin/dashboard";

//categorii
$route['categorii/(:any)'] = "categorii/load_categories";
$route['categorii/getSubcategory'] = "categorii/getSubcategory";

//oferte
$route['oferte/increment_offer_view'] = "oferte/increment_offer_view";
$route['oferte/show_offer'] = "oferte/show_offer";
$route['oferte/(:any)'] = "oferte/view";

//cart
$route['cart'] = "neocart";

//partener
$route['partener/suspenda-oferta/(:any)'] = "partener/suspend_offer";
$route['partener/activeaza-oferta/(:any)'] = "partener/resume_offer";
$route['partener/detalii-oferta/(:any)'] = "partener/offer_details";
$route['partener/editeaza-oferta/(:any)'] = "partener/edit_offer";
$route['partener/date-cont'] = "partener/date_cont";

$route['404_override'] = '';


/* End of file routes.php */
/* Location: ./application/config/routes.php */