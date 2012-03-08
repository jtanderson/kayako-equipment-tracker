<?php
/**
 * This is the controller for the TB_Ticket table.
 * 
 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
 * @since 2011-11-13
 * @version 2011-11-13
 */

 class Ticket extends MY_Model{
	 /**
	  * This is the constructor function for the model
	  *
	  * @author Joseph Anderson
	  */
 	function __construct(){
 		parent::__construct();
        $this->table = "TB_Ticket";
 	}
	
	/**
	 * This function writes the ticket data to the database
	 *
	 * @param string $TicketData An associative array of ticket data
	 * @return boolean Whether or not the transaction was successful
	 * @author Joseph Anderson
	 * @since 2011-11-13
	 * @version 2011-11-13
	 */
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
	
	/**
	 * This funciton returns all data related to a particular ticket
	 *
	 * @param string $TicketPK 
	 * @return void
	 * @author Joseph Anderson
	 * @since 2011-11-13
	 * @version 2011-11-13
	 */
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
