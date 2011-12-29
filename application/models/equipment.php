<?php
/*
 * This is the model file to interact with the TB_Equipment table on the database
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
 * @since 2011-11-26
 * @version 2011-11-26
 * 
 */

 class Equipment extends MY_Model{
 	function __construct(){
 		parent::__construct();
        $this->table = "TB_Equipment";
 	}
	
	function createEquipment($EquipmentArray){
		foreach ( $EquipmentArray as $key => $row ){
			if ( !$this->db->field_exists($key, 'TB_Equipment') ){
				unset($EquipmentArray[$key]);
			}
		}
		if ( $this->db->insert('TB_Equipment', $EquipmentArray) ){
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	function getEquipmentData($PK){
		$this->db->select('*');
		$this->db->from('TB_Equipment');
		$this->db->where(Array('PK_EquipmentNum'=>$PK));
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result_array() : FALSE;
	}
	
	function getEquipmentForTicket($PK_TicketNum){
		$this->db->select('*');
		$this->db->from('TB_Equipment');
		$this->db->where(Array('FK_TicketNum' => $PK_TicketNum));
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result_array() : FALSE;
	}
 }
