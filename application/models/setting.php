<?php
/**
 * The model to interface with the TB_Setting table.
 * 
 * @author Joseph T. Anderson <jtanderson@ratioaceli.com>
 * @since 2011-12-26
 * @version 2011-12-26
 */

 class Setting extends MY_Model{
     function __construct(){
         parent::__construct();
         $this->table = "TB_Setting";
     }
     
     function getPKFromTitle($Title){
         $this->db->select('PK_SettingNum');
         $this->db->from($this->table);
         $this->db->where('U_Title', $Title);
         $query = $this->db->get();
         if ( $query->num_rows() == 1 ){
             $arr = current($query->result_array());
             return $arr['PK_SettingNum'];
         } else {
             return FALSE;
         }
     }
 }
