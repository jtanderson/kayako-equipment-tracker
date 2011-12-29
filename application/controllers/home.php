<?php
/**
 * This is the main controller for the Kayako extension project.  It will handle all
 * requests to viewable sites.
 * 
 * @author Joseph T. Anderson
 * @since 2011-09-29
 * @version 2011-09-29
 * 
 */

 class Home extends MY_Controller{
     
    var $DocumentArray = Array(
        'Errors' => Array(),
        'success' => FALSE
    );
 	
	/**
	 * Constructor.  Only purpose is to invoke the MY_Controller
	 * constructor which handles the appropriate actions designated
	 * by the URL.
	 * 
	 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
	 * @since 2011-09-30
	 * @version 2011-12-17
	 */
 	function __construct(){
 		parent::__construct();
 	}
	
	/**
	 * The default function of the home controller (as configured
	 * in the routes.php configuration file).  If the user is logged
	 * in, the main page is laoded.  If not, a login screen in shown.
	 * 
	 * @author Joseph T. Anderson <jtanderson@raticaeli.com>
	 * @since 2011-09-30
	 * @version 2011-12-17
	 */
	function index(){
		if ( ! $this->session->userdata('logged_in') ){
			$this->load->view('login', $this->DocumentArray);
		} else {
            $this->load->library('Kayako');
            try{
                $this->DocumentArray['Priorities'] = $this->kayako->getTicketPriorities();
                $this->DocumentArray['Departments'] = $this->kayako->getDepartments();
            } catch ( Exception $e ){
                $this->DocumentArray['Priorities'] = Array();
                $this->DocumentArray['Departments'] = Array();
                $this->DocumentArray['Errors'] []= "The system is not connected to the Kayako Fusion Server. Try <a href=\"javascript:location.reload();\">refreshing</a>.";
                log_message('error', "Kayako Error: " . $e->getMessage());
            }
			$this->load->view('home', $this->DocumentArray);
		}
	}
    
     function Settings($UserID = NULL){
         if ( $UserID == NULL ){
             show_404();
         }
         
         if ( ! $this->session->userdata('logged_in') ){
             $this->index(current_url());
             return;
         }
         
         $this->load->model('User');
         $this->DocumentArray['UserData'] = $this->User->getUserData($UserID);
         
         $this->load->view('settings.php', $this->DocumentArray);
     }
     
	
	/**
	 * This function calls the __finalize function of the custom
	 * base controller, MY_Controller.  The core functionality of
	 * CodeIgniter is edited to call this function after the controller has
	 * processed the requested functions.  It takes the place of a
	 * destructor.  See the application/core/MY_Controller.php file
	 * for more detail.
	 * 
	 * @author Joseph T. Anderson <jtanderson@ratiocael.com>
	 * @since 2011-09-30
	 * @version 2011-09-30
	 */
	function __finalize(){
		parent::__finalize();
	}
 }
