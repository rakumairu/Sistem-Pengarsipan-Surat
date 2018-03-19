<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['suratmasuk/create'] = 'suratmasukcontroller/create';
$route['suratmasuk/delete/(:any)'] = 'suratmasukcontroller/delete/$1';
$route['suratmasuk/detaildisposisi/(:any)'] = 'suratmasukcontroller/detaildisposisi/$1';
$route['suratmasuk/disposisi/(:any)'] = 'suratmasukcontroller/disposisi/$1';
$route['suratmasuk/unduh'] = 'suratmasukcontroller/unduh';
$route['suratmasuk/(:any)'] = 'suratmasukcontroller/edit/$1';

$route['suratkeluar/create'] = 'suratkeluarcontroller/create';
$route['suratkeluar/delete/(:any)'] = 'suratkeluarcontroller/delete/$1';
$route['suratkeluar/unduh'] = 'suratkeluarcontroller/unduh';
$route['suratkeluar/(:any)'] = 'suratkeluarcontroller/edit/$1';

$route['suratmasuk'] = 'suratmasukcontroller';
$route['suratkeluar'] = 'suratkeluarcontroller';
$route['dashboard'] = 'dashboardcontroller';

$route['login'] = 'users/login';
$route['logout'] = 'users/logout';

$route['default_controller'] = 'users/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
