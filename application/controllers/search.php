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
             $this->session->set_userdata(Array('destinationURL' => current_url()));
             $this->session->sess_write(TRUE);
             redirect(base_url());
         }
         $this->carabiner->css('css/search.css');
         $this->carabiner->js('js/_uncompressed/search.js');
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
      * 
      * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
      * @since 2012-02-01
      * @version 2012-02-15
      */
     function find($ticketID=""){
         $this->load->library('kayako');
         $this->load->model('Ticket');
         $LocalData = $this->Ticket->find(Array('TicketDisplayID'=>$ticketID));
         // $this->DocumentArray['TicketData'] = $LocalData ?: "[None]";
         $this->DocumentArray['TicketData'] = $LocalData ? $this->Ticket->getTicketData($LocalData['PK_TicketNum']) : "[None]";
         //$this->DocumentArray['TicketData'] = $this->kayako->search($LocalData['TicketFusionID']);
         $this->views['search'] = $this->DocumentArray;
     }
     
     /**
      * Function: __finalize
      * 
      * This is the finalizer.  It just calls the MY_Controller 
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
