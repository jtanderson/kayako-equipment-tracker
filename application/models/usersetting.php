<?php
/**
 * The model to interface with the TB_UserSetting table
 * 
 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
 * @since 2011-12-26
 * @version 2011-12-26
 */

 class UserSetting extends MY_Model{
	 /**
	  * This is the constructor for this model.
	  *
	  * @author Joseph Anderson
	  * @since 2011-12-26
	  * @version 2011-12-26
	  */
     function __construct(){
         parent::__construct();
         $this->table = "TB_UserSetting";
     }
 }
