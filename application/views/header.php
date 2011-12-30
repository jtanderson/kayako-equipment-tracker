<?php
/**
 * This is the footer file for the Kayako Extension Application
 * 
 * @author Joseph T. Anderson
 * @since 2011-09-30
 * @version 2011-09-30
 * 
 */
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Saint Vincent HelpDesk Extension</title>
		<?php $this->carabiner->display('css'); $this->carabiner->display('js'); ?>
	</head>
	<!-- Begin Body -->
	<body>
		<?php if ($this->session->userdata('logged_in') ){
			$this->load->view('cpanel');
		} ?>