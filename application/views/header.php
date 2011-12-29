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
		<link type="text/css" rel="stylesheet" href="/cdn/css/main.css"/>
		<link type="text/css" rel="stylesheet" href="/cdn/js/jquery/jquery-ui/css/dot-luv/jquery-ui-1.8.13.custom.css"/>
		<link type="text/css" rel="stylesheet" href="/cdn/css/mydropdown.css"/>
		<?php if ( $this->session->userdata('logged_in') ){ ?>
			<link type="text/css" rel="stylesheet" href="/cdn/css/cpanel.css"/>
			<link type="text/css" rel="stylesheet" href="/cdn/css/settings.css"/>
		<?php } else { ?>
            <link type="text/css" rel="stylesheet" href="/cdn/css/login.css"/>
		<?php } ?>
		<script type="text/javascript" src="/cdn/js/jquery/jquery-1.6.1.min.js"></script>
		<script type="text/javascript" src="/cdn/js/jquery/jquery-ui/js/jquery-ui-1.8.13.custom.min.js"></script>
		<script type="text/javascript" src="/cdn/js/jquery/jquery.scrollTo-min.js"></script>
		<script type="text/javascript" src="/cdn/js/jquery/jquery.mydropdown.min.js"></script>
		<script type="text/javascript" src="/cdn/js/jquery/jquery.collapse.min.js"></script>
		<script type="text/javascript" src="/cdn/js/jquery/jquery.client.min.js"></script>
		<script type="text/javascript" src="/cdn/js/<?php if ( ENVIRONMENT == 'development') echo '_uncompressed/' ?>main.js"></script>
	</head>
	<!-- Begin Body -->
	<body>
		<?php if ($this->session->userdata('logged_in') ){
			$this->load->view('cpanel');
		} ?>