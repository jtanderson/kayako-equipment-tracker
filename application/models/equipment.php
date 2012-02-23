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
	/**
	 * The model constructor
	 *
	 * @author Joseph Anderson
	 * @since 2011-12-28
	 * @version 2011-12-28
	 */
 	function __construct(){
 		parent::__construct();
        $this->table = "TB_Equipment";
 	}

	/**
	 * This function creates a new record in the TB_Equipment table
	 *
	 * @param string $EquipmentArray An array of equipment data
	 * @return void
	 * @author Joseph Anderson
	 * @since 2011-12-28
	 * @version 2011-12-28
	 */
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
	
	/**
	 * This function returns all data associated with a particular equipment record
	 *
	 * @param string $PK The primary key of the equipment
	 * @return Array The associative array of equipment data
	 * @author Joseph Anderson
	 * @since 2011-12-28
	 * @version 2011-12-28
	 */
	function getEquipmentData($PK){
		$this->db->select('*');
		$this->db->from('TB_Equipment');
		$this->db->where(Array('PK_EquipmentNum'=>$PK));
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result_array() : FALSE;
	}
	
	/**
	 * This function uses a ticket foreign key to find the associated equipment
	 *
	 * @param string $PK_TicketNum 
	 * @return Array The associative array of equipment data
	 * @author Joseph Anderson
	 * @since 2011-12-28
	 * @version 2011-12-28
	 */
	function getEquipmentForTicket($PK_TicketNum){
		$this->db->select('*');
		$this->db->from('TB_Equipment');
		$this->db->where(Array('FK_TicketNum' => $PK_TicketNum));
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result_array() : FALSE;
	}
 }
