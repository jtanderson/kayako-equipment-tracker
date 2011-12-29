<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['display_override'][] = array(
	'class' => '',
	'function' => 'compress',
	'filename' => 'compress.php',
	'filepath' => 'hooks'
	);
	
// $hook['post_controller'][] = array(
	// 'class' => 'MY_Controller',
	// 'function' => '__finalize',
	// 'filename' => 'MY_Controller.php',
	// 'filepath' => 'core'
// );

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */