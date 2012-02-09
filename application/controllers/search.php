<?php
/**
 * File: Controller.php
 * 
 * This file is the controller for the ticket search page
 * 
 * @author Joseph T. Anderson
 * @since 2012-02-01
 * @version 2012-02-01
 */

 class Search extends MY_Controller{
     
     var $DocumentArray = Array(
        'Errors' => Array(),
        'success' => FALSE
     );
     
     /**
      * Function: __construct
      * 
      * This is the constructor.  It just calls the MY_Controller 
      * constructor
      * 
      * @author Joseph T. Anderson
      * @since 2012-02-01
      * @version 2012-02-01
      * 
      */    
     public function __construct(){
         parent::__construct();
         if ( ! $this->session->userdata('logged_in') ){
             redirect(base_url());
         }
         // $this->carabiner->css('search.css');
     }
     
     /**
      * Function: index
      * 
      * The main function for the search page.  For now, it just loads 
      * the appropriate view
      */
     function index(){
         $this->views['search'] = $this->DocumentArray;
     }
     
     /**
      * Function: search
      * 
      * This function uses the submitted barcode to try and retrieve ticket
      * data from the Kayako Fusion server.
      */
     function search(){
         
     }
     
     /**
      * Function: __finalize
      * 
      * This is the constructor.  It just calls the MY_Controller 
      * __finalize function
      * 
      * @author Joseph T. Anderson
      * @since 2012-02-01
      * @version 2012-02-01
      * 
      */    
     function __finalize(){
         parent::__finalize();
     }
 }
