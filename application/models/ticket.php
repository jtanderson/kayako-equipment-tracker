<?php
/*
 * This is the controller for the TB_Ticket table.
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
 * @since 2011-11-13
 * @version 2011-11-13
 */

 class Ticket extends MY_Model{
 	function __construct(){
 		parent::__construct();
        $this->table = "TB_Ticket";
 	}
	
	function createTicket($TicketData){
		foreach ( $TicketData as $key => $row ){
			if ( ! $this->db->field_exists($key, 'TB_Ticket') ){
				unset($TicketData[$key]);
			}
		}
		if ( $this->db->insert('TB_Ticket', $TicketData) ){
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
	
	function getTicketData($TicketPK){
		$this->db->select('*');
		$this->db->from('TB_Ticket');
        $this->db->join('TB_Priority', 'TB_Priority.PK_PriorityNum = TB_Ticket.FK_PriorityNum');
        $this->db->join('TB_Department', 'TB_Department.PK_DepartmentNum = TB_Ticket.FK_DepartmentNum');
		$this->db->where(Array('TB_Ticket.PK_TicketNum'=>$TicketPK));
		$query = $this->db->get();
		return $query->num_rows() == 1 ? $query->row_array() : FALSE;
	}
 }
