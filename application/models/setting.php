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
         $this->db->where(Array('U_Title' => $Title));
         $query = $this->db->get();
         if ( $query->num_rows() == 1 ){
             $arr = $query->row_array();
             return $arr['PK_SettingNum'];
         } else {
             return FALSE;
         }
     }
     
     function getSettingsForUser($UserPK){
         $this->db->select('*');
         $this->db->from('TB_Setting S');
         $this->db->join('TB_UserSetting US', 'S.PK_SettingNum = US.PKb_SettingNum', 'left');
         $this->db->where(Array('US.PKa_UserNum'=>$UserPK));
         $this->db->or_where(Array('US.PKa_UserNum' => NULL));
         $query = $this->db->get();
         return $query->num_rows() > 0 ? $query->result_array() : FALSE;
     }
 }
