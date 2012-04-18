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
	 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
	 * @since 2011-09-30
	 * @version 2011-12-17
	 */
 	function __construct(){
 		parent::__construct();
        if ( $this->uri->segment(2) ){
            $this->carabiner->css('css/'.$this->uri->segment(2).'.css');
            $this->carabiner->js('js/' . ( ENVIRONMENT == 'development' ? '_uncompressed/' : '' ) . $this->uri->segment(2).'.js');
        }
 	}
	
	/**
	 * The default function of the home controller (as configured
	 * in the routes.php configuration file).  If the user is logged
	 * in, the main page is loaded.  If not, a login screen in shown.
	 * 
	 * @author Joseph T. Anderson <jtanderson@raticaeli.com>
	 * @since 2011-09-30
	 * @version 2011-12-17
	 */
	function index(){
		if ( ! $this->session->userdata('logged_in') ){
            $this->carabiner->js('js/' . ( ENVIRONMENT == 'development' ? '_uncompressed/' : '' ) . 'login.js');
            // $this->DocumentArray['destinationURL'] = $_SERVER['HTTP_REFERER'];
			$this->views['login'] = $this->DocumentArray;
		} else {
		    // TODO: load priority and department options from Database
//		    $this->load->helper('form');
		    $this->carabiner->js('js/' . ( ENVIRONMENT == 'development' ? '_uncompressed/' : '' ) . 'home.js');
            
		    $this->load->model('Priority');
            $this->load->model('Department');
            $this->DocumentArray['Departments'] = $this->Department->find_all();
            $this->DocumentArray['Priorities'] = $this->Priority->find_all();
            if ( ! $this->session->userdata('kayako_connected') ){
                $this->DocumentArray['Errors'] []= "The system is not connected to the Kayako Fusion Server.  To try and reconnect, log out and log back in.";
            }
            $this->views['home'] = $this->DocumentArray;
			// $this->load->view('home', $this->DocumentArray);
		}
	}
	
	 /**
	  * This function loads the user's preferences from the database, aggregates
      * them, and sends them to the settings view.
	  *
	  * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
      * @since 2012-01-12
      * @version 2012-02-15  
	  *
      */
     function settings($UserID = NULL){
         if ( $UserID == NULL ){
             show_404();
         }
         
         if ( ! $this->session->userdata('logged_in') ){
             $this->index(current_url());
             return;
         }
         
         $this->load->model('User');
         $this->DocumentArray['UserData'] = $this->User->getUserData($UserID);
         
         $this->load->model('Setting');
         $this->load->helper('Array');
         $SettingArray = $this->Setting->getSettingsForUser($UserID);
         $this->DocumentArray['Settings'] = Array();
         
         if ( $SettingArray != FALSE ){
            $SettingArray = associate_by('U_Title', $SettingArray);
         
             $SettingsToLoad = Array(
                'DefaultTicketDepartment',
                'DefaultTicketPriority'
             );
             
             foreach ( $SettingsToLoad as $key => $setting ){
                 if ( is_array($SettingArray[$setting]) ){
                     $this->DocumentArray['Settings'][$setting] = $SettingArray[$setting]['Value'] ? $SettingArray[$setting]['Value'] : $SettingArray[$setting]['Default'];
                 }
             }
         }
         
         // $this->config->load('kayakofusion');
		 $this->load->model('APISetting');
         $this->DocumentArray['KayakoAPIKey'] = $this->APISetting->find(Array('U_Title' => 'APIKey'));
         $this->DocumentArray['SwiftURL'] = $this->APISetting->find(Array('U_Title' => 'SwiftURL'));
         $this->DocumentArray['KayakoSecretKey'] = $this->APISetting->find(Array('U_Title' => 'APISecretKey'));
         
         $this->carabiner->js('js/' . ( ENVIRONMENT == 'development' ? '_uncompressed/' : '' ) . 'settings.js');
         
         $this->views['settings'] = $this->DocumentArray;
         // $this->load->view('settings.php', $this->DocumentArray);
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