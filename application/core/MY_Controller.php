<?php
/*
 * This is the custom controller base for the Kayako Extension software.
 * 
 * @author Joseph T. Anderson
 * @since 2011-09-30
 * @version 2011-09-30
 * 
 */

 class MY_Controller extends CI_Controller{
 	function __construct(){
 		parent::__construct();
		
		if ( ! $this->input->is_ajax_request() ){
			$DocumentArray = array();
			$this->load->view('header', $DocumentArray);
		}
 	}
	
	function __finalize(){
		if ( ! $this->input->is_ajax_request() ){
			$this->load->view('footer');
		}
	}
 }