<?php
/**
 * This is the custom controller base for the Kayako Extension software.
 * 
 * @author Joseph T. Anderson
 * @since 2011-09-30
 * @version 2012-02-01
 * 
 */

 class MY_Controller extends CI_Controller{
    
    protected $views = Array();
    
 	function __construct(){
 		parent::__construct();
        // $this->output->enable_profiler(TRUE);
		
		if ( ! $this->input->is_ajax_request() ){
            // $this->output->cache(15);
			$DocumentArray = array();

            $carabiner_config = array(
                'script_dir' => 'cdn/',
                'style_dir'  => 'cdn/',
                'cache_dir'  => 'cdn/cache/',
                'combine'    => TRUE,
                'dev'        => FALSE
            );
            $this->carabiner->config($carabiner_config);
            // $this->carabiner->css('css/reset.css');
            $this->carabiner->css('css/main.css');
            $this->carabiner->css('css/mydropdown.css');
            $this->carabiner->css('js/jquery/jquery-ui/css/dot-luv/jquery-ui-1.8.13.custom.css');
            
            $this->carabiner->js('js/jquery/jquery-1.7.1.min.js');
            $this->carabiner->js('js/jquery/jquery-ui/js/jquery-ui-1.8.13.custom.min.js');
            $this->carabiner->js('js/jquery/jquery.scrollTo-min.js');
            $this->carabiner->js('js/jquery/jquery.mydropdown.min.js');
            $this->carabiner->js('js/jquery/jquery.collapse.min.js');
            $this->carabiner->js('js/jquery/jquery.client.min.js');
            $this->carabiner->js('js/jquery/jquery.blockUI.min.js');
            $this->carabiner->js('js/' . ( ENVIRONMENT == 'development' ? '_uncompressed/' : '' ) . 'main.js');
            
            
            if ( $this->session->userdata('logged_in') ){
                $this->carabiner->css('css/cpanel.css');
                // $this->carabiner->css('css/settings.css');
                if ( $this->uri->segment(2) ){
                    $this->carabiner->css('css/'.$this->uri->segment(2).'.css');
                    $this->carabiner->js('js/' . ( ENVIRONMENT == 'development' ? '_uncompressed/' : '' ) . $this->uri->segment(2).'.js');
                }
            } else {
                $this->carabiner->css('css/login.css');
            }
            
            $this->views['header'] = $DocumentArray;
			//$this->load->view('header', $DocumentArray);
		}
 	}
	
    /**
     * Function: __finalize
     * 
     * This function is executed at the end of every controller's
     * lifecycle.  It loads the views place on the "stack" by the
     * controllers if the request is not simply an AJAX request.
     * 
     * @author Joseph T. Anderson
     * @since 2011-09-30
     * @version 2012-02-01
     */
	function __finalize(){
		if ( ! $this->input->is_ajax_request() ){
            foreach ( $this->views as $view => $data ){
                $this->load->view($view, $data);
                log_message('debug', 'Loading view: ' . $view);
            }
			$this->load->view('footer');
            log_message('debug', 'Loading view: footer');
            // sess_write(TRUE);
		}
	}
 }