<?php
/**
 * File: priority.php
 * 
 * Interfaces with the TB_Priority table on the database
 * 
 * @author Josph T. Anderson <joe.anderson@email.stvincent.edu
 * @since 2011-12-28
 * @version 2011-12-28
 */

 class Priority extends MY_Model{
	/**
	 * The constructor for this model
	 *
	 * @author Joseph Anderson
	 * @since 2011-12-28
	 * @version 2011-12-28
	 */
     function __construct(){
         parent::__construct();
         $this->table = "TB_Priority";
     }

     /**
      * This function updates the TB_Priority table with the data from Kayako Fusion.
      *
      * @param string $currentValues An associative array of Priority names and Kayako ID's
      * @return void
      * @author Joseph Anderson
	  * @since 2011-12-28
	  * @version 2011-12-28
      */
     function refreshTable($currentValues){
         $this->db->trans_start();
         foreach ( $currentValues as $id => $value ){
             if ( ! $this->find_where(Array('U_PriorityTitle'=>$value, 'PriorityFusionID'=>$id)) ){
                $this->insert(Array('U_PriorityTitle'=>$value, 'PriorityFusionID'=>$id));
             }
         }
         $this->db->trans_complete();
     }
     
	 /**
	  * This function uses a Kayako Fusion ID of a priority to find the Local
	  * database ID
	  *
	  * @param string $id The Kayako Fusion ID
	  * @return void
	  * @author Joseph Anderson
	  * @since 2011-12-28
	  * @version 2011-12-28
	  */
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
