<?php
/**
 * This is the controller to interface with the TB_User table
 * 
 * @author Joseph T. Anderson
 * @since 2011-09-30
 * @version 2011-09-30
 * 
 */

 class User extends MY_Model{
	 /**
	  * This is the constructor for the model
	  *
	  * @author Joseph Anderson
	  */
 	function __construct(){
 		parent::__construct();
        $this->table = "TB_User";
 	}
    
	/**
	 * This is a privately accessible file to return the encrypted contents of a string
	 * so that the encryption is decoupled from the calling funciton or any repeated usage.
	 *
	 * @param string $str The string to be encrypted
	 * @return void
	 * @author Joseph Anderson
	 * @since 2011-09-30
	 * @version 2011-09-30
	 */
    private function __encrypt($str){
        return md5($str);
    }
	
	/**
	 * This function verifies whether or not a user exists on the database with a particular password
	 *
	 * @param string $username The username of the user
	 * @param string $password The plaintext password string
	 * @return boolean Whether or not the user is valid
	 * @author Joseph Anderson
	 * @since 2011-09-30
	 * @version 2011-09-30
	 */
 	function authenticate($username, $password){
 		$this->db->select('*');
		$this->db->from('TB_User');
		$this->db->where(array('U_Username' => $username, 'Password' => $this->__encrypt($password)));
		$query = $this->db->get();
		return $query->num_rows() == 1;
 	}
	
	/**
	 * This function simply checks to see if a user exists in the database.
	 *
	 * @param string $username The username of the user
	 * @return boolean Whether or not the user record exists
	 * @author Joseph Anderson
	 * @since 2011-09-30
	 * @version 2011-09-30
	 */
	function userExists($username){
		$this->db->select('*');
		$this->db->from('TB_User');
		$this->db->where(array('U_Username' => $username));
		$query = $this->db->get();
		return $query->num_rows() == 1;
	}
    
	/**
	 * This function returns all data related to a particular user.
	 *
	 * @param string $ID The primary key of the user
	 * @return Array An associative array of user data
	 * @author Joseph Anderson
	 * @since 2011-09-30
	 * @version 2011-09-30
	 */
    function getUserData($ID){
        $this->db->select('*');
        $this->db->from('TB_User');
        $this->db->where('PK_UserNum', $ID);
        $query = $this->db->get();
        return $query->num_rows() > 0 ? $query->row_array() : FALSE;
    }
    
	/**
	 * This function finds a user record using the unique username and
	 * returns the primary key of that user.
	 *
	 * @param string $username The user's username
	 * @return String The primary key of the user or FALSE if it does not exist
	 * in the database
	 * @author Joseph Anderson
	 * @since 2011-09-30
	 * @version 2011-09-30
	 */
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
	
	/**
	 * This function writes a use to the database with the minimal required data,
	 * namely, the username and password.  This function uses the local __encrypt function
	 * to keep the encryption modular for when security standards are changed.
	 *
	 * @param string $username The username of the new user
	 * @param string $password The plaintext of the user's password
	 * @return bool Whether or not the data was written successfully
	 * @author Joseph Anderson
	 * @since 2011-09-30
	 * @version 2011-09-30
	 */
	function addUser($username, $password){
		$InsertArray = Array('U_Username' => $username, 'Password' => $this->__encrypt($password));
		return $this->db->insert('TB_User', $InsertArray);
	}
    
	/**
	 * This function looks up a user record with the (unique) username and
	 * changes the password. Uses the private __encrypt function.
	 *
	 * @param string $username The username of the user
	 * @param string $password The new password in plaintext.
	 * @return bool Whether or not the update was successful
	 * @author Joseph Anderson
	 * @since 2011-09-30
	 * @version 2011-09-30
	 */
    function setPassword($username, $password){
        return $this->update_where(Array('U_Username' => $username), Array('Password' => $this->__encrypt($password)));
    }
 }
