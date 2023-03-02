<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| BREADCRUMB CONFIG
| -------------------------------------------------------------------
| This file will contain some breadcrumbs' settings.
|
| $config['crumb_divider']		The string used to divide the crumbs
| $config['tag_open'] 			The opening tag for breadcrumb's holder.
| $config['tag_close'] 			The closing tag for breadcrumb's holder.
| $config['crumb_open'] 		The opening tag for breadcrumb's holder.
| $config['crumb_close'] 		The closing tag for breadcrumb's holder.
|
| Defaults provided for twitter bootstrap 2.0
*/

$config['tag_open'] = '';
$config['tag_close'] = '';
$config['crumb_open'] = '<li class="m-nav__item">';
$config['crumb_last_open'] = '<li class="m-nav__item">';
$config['crumb_close'] = '</li>';
$config['crumb_divider']='<li class="m-nav__separator">-</li>';
$config['inner_link_open']='<span class="m-nav__link-text">';
$config['inner_link_close']='</span>';
$config['class_link']='m-nav__link';

/* End of file breadcrumbs.php */
/* Location: ./application/config/breadcrumbs.php */