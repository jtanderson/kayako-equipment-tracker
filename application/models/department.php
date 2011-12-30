<?php
/**
 * File: department.php
 * 
 * Interfaces with the TB_Department table on the database
 * 
 * @author Josph T. Anderson <jtanderson@ratiocaeli.com
 * @since 2011-12-28
 * @version 2011-12-28
 */

 class Department extends MY_Model{
     function __construct(){
         parent::__construct();
         $this->table = "TB_Department";
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
