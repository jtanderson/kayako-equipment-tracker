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
         foreach ( $currentValues as $id => $value ){
             if ( ! $this->find_where(Array('U_DepartmentTitle'=>$value, 'DepartmentFusionID'=>$id)) ){
                $this->insert(Array('U_DepartmentTitle'=>$value, 'DepartmentFusionID'=>$id));
             }
         }
         $this->db->trans_complete();
     }
     
     function getPKFromFusionID($id){
         $this->db->select('PK_DepartmentNum');
         $this->db->from($this->table);
         $this->db->where('DepartmentFusionID', $id);
         $query = $this->db->get();
         if ( $query->num_rows() == 1 ){
             $arr = $query->row_array();
             return $arr['PK_DepartmentNum'];
         } else {
             return FALSE;
         }
     }
 }
