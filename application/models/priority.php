<?php
/**
 * File: priority.php
 * 
 * Interfaces with the TB_Priority table on the database
 * 
 * @author Josph T. Anderson <jtanderson@ratiocaeli.com
 * @since 2011-12-28
 * @version 2011-12-28
 */

 class Priority extends MY_Model{
     function __construct(){
         parent::__construct();
         $this->table = "TB_Priority";
     }
     
     function refreshTable($currentValues){
         $this->db->trans_start();
         $this->db->empty_table($this->table);
         foreach ( $currentValues as $id => $value ){
             $this->insert(Array('U_Title'=>$value, 'FusionID'=>$id));
         }
         $this->db->trans_complete();
     }
 }
