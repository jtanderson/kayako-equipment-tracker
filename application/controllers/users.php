<?php
/**
 * File Users.php
 * 
 * This is the controller that will be used to interface with user profiles, preference, etc.
 * 
 * @author Joseph T. Anderson
 * @since 2011-12-23
 * @version 2011-12-23
 */

 class Users extends MY_Controller{
     
     var $DocumentArray = Array();
     
     function __construct(){
         $this->DocumentArray['Errors'] = Array();
         parent::__construct();
     }
     
     function index(){
         
     }
     function __finalize(){
         parent::__finalize();
     }
 }
