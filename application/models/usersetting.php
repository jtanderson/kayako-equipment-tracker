<?php
/**
 * The model to interface with the TB_UserSetting table
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
 * @since 2011-12-26
 * @version 2011-12-26
 */

 class UserSetting extends MY_Model{
     function __construct(){
         parent::__construct();
         $this->table = "TB_UserSetting";
     }
 }
