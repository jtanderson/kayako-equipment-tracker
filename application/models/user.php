<?php
/*
 * This is the controller to interface with the TB_User table
 * 
 * @author Joseph T. Anderson
 * @since 2011-09-30
 * @version 2011-09-30
 * 
 */

 class User extends MY_Model{
 	function __construct(){
 		parent::__construct();
        $this->table = "TB_User";
 	}
    
    private function __encrypt($str){
        return md5($str);
    }
	
 	function authenticate($username, $password){
 		$this->db->select('*');
		$this->db->from('TB_User');
		$this->db->where(array('U_Username' => $username, 'Password' => $this->__encrypt($password)));
		$query = $this->db->get();
		return $query->num_rows() == 1;
 	}
	
	function userExists($username){
		$this->db->select('*');
		$this->db->from('TB_User');
		$this->db->where(array('U_Username' => $username));
		$query = $this->db->get();
		return $query->num_rows() == 1;
	}
    
    function getUserData($ID){
        $this->db->select('*');
        $this->db->from('TB_User');
        $this->db->where('PK_UserNum', $ID);
        $query = $this->db->get();
        return $query->num_rows() > 0 ? $query->row_array() : FALSE;
    }
    
    function getUserPKFromUName($username){
        $this->db->select('PK_UserNum');
        $this->db->from('TB_User');
        $this->db->where('U_Username', $username);
        $query = $this->db->get();
        if ( $query->num_rows() == 1 ){
            $queryArray = $query->row_array();
            return $queryArray['PK_UserNum'];
        } else {
            return FALSE;
        }
    }
	
	function addUser($username, $password){
		$InsertArray = Array('U_Username' => $username, 'Password' => $this->__encrypt($password));
		$this->db->insert('TB_User', $InsertArray);
	}
    
    function setPassword($username, $password){
        $this->update_where(Array('U_Username' => $username), Array('Password' => $this->__encrypt($password)));
    }
 }
