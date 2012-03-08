<?php
/**
 * File: department.php
 * 
 * Interfaces with the TB_Department table on the database
 * 
 * @author Joseph T. Anderson <jtanderson@email.stvincent.edu
 * @since 2011-12-28
 * @version 2011-12-28
 */

 class Department extends MY_Model{
	/**
	 * This function initializes the MY_Model controller which provides the more basic
	 * database operations.
	 *
	 * @author Joseph Anderson
	 * @since 2011-12-28
	 * @version 2011-12-28
	 */
     function __construct(){
         parent::__construct();
         $this->table = "TB_Department";
     }
     

	/**
	 * This function updates the TB_Department table with the possible departments
	 *
	 * @param Array $currentValues An array of department names and id's
	 * @return void
	 * @author Joseph Anderson
	 * @since 2011-12-28
	 * @version 2011-12-28
	 */
     function refreshTable($currentValues){
         $this->db->trans_start();
         foreach ( $currentValues as $id => $value ){
             if ( ! $this->find_where(Array('U_DepartmentTitle'=>$value, 'DepartmentFusionID'=>$id)) ){
                $this->insert(Array('U_DepartmentTitle'=>$value, 'DepartmentFusionID'=>$id));
             }
         }
         $this->db->trans_complete();
     }
     
	 /**
	  * This function finds a Department's local PK from the Kayako Fusion ID
	  * 
	  * NOTE: This is made obsolete by the MY_Model "where" function
	  *
	  * @param string $id The Kayako Fusion ID
	  * @return string or boolean The PK of the department or FALSE if it does not exist
	  * @author Joseph Anderson
 	  * @since 2011-12-28
	  * @version 2011-12-28
	  */
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
