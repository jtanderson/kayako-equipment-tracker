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
         foreach ( $currentValues as $id => $value ){
             if ( ! $this->find_where(Array('U_PriorityTitle'=>$value, 'PriorityFusionID'=>$id)) ){
                $this->insert(Array('U_PriorityTitle'=>$value, 'PriorityFusionID'=>$id));
             }
         }
         $this->db->trans_complete();
     }
     
     function getPKFromFusionID($id){
         $this->db->select('PK_PriorityNum');
         $this->db->from($this->table);
         $this->db->where('PriorityFusionID', $id);
         $query = $this->db->get();
         if ( $query->num_rows() == 1 ){
             $arr = $query->row_array();
             return $arr['PK_PriorityNum'];
         } else {
             return FALSE;
         }
     }
 }
