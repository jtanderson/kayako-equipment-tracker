<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

/**
 * Kayako API Library
 *
 * This file contains funcitons that load and interface with the Kayako Fusion PHP SDK.
 * To run, it must have access to the CurlRequest library.
 *
 * @author Joseph T. Anderson
 * @since 2011-12-17
 * @version 2012-02-15
 *
 */

class Kayako
{
	private $APIKey;
	private $SecretKey;
	private $SwiftURL;
	private $Request;

	/**
	 * Constructor. This laods the custom configuration file
	 * and sets the API Key, URL, and Secret Key to be used
	 * in the connection to the Kayako Fusion software.  From
	 * this point, any method that uses a Kayako object need not
	 * include the class.  All Kayako classes are loaded by the
	 * kyIncludes.php file.
	 *
	 * @TODO: Find a way to gracefully defer processing of data if a connection is not available
	 *
	 * @author Joseph T. Anderson
	 * @since 2011-12-17
	 * @version 2011-12-17
	 *
	 */
	function __construct(){
		$CI =& get_instance();
		// $CI->config->load('kayakofusion');
		$CI->load->model('APISetting');


		require_once('CurlRequest.php');
		$this->Request = new CurlRequest();

		$APIKeyRecord = $CI->APISetting->find(Array('U_Title' => 'APIKey'));
		$SwiftURLRecord = $CI->APISetting->find(Array('U_Title' => 'SwiftURL'));
		$SecretKeyRecord = $CI->APISetting->find(Array('U_Title' => 'APISecretKey'));
		$this->APIKey = $APIKeyRecord['Value'];
		$this->SwiftURL = $SwiftURLRecord['Value'];
		$this->SecretKey = $SecretKeyRecord['Value'];
		// $this->APIKey = $CI->config->item('KayakoAPIKey');
		// $this->SwiftURL = $CI->config->item('SwiftURL');
		// $this->SecretKey = $CI->config->item('KayakoSecretKey');

		require_once 'Kayako/kyIncludes.php';
		log_message('debug', "Kayako API Loaded");
		try{
			kyBase::init($this->SwiftURL . '/api/', $this->APIKey, $this->SecretKey, FALSE, 'Y-m-d H:i:s');
		} catch ( Exception $e ){
			log_message('error', $e->getMessage());
			// Should do something...
		}
	}

	/**
	 * Function: login
	 *
	 * This function makes use of the Kayako Fusion Staff API to request user authentication.
	 * Although the main functionality of the Staff API has no planned integration, it will
	 * be useful to make sure the user is a legitimate user of the Kayako Fusion system. The
	 * method uses a CURL helper (found in CurlRequest.php) to query the server.
	 *
	 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
	 * @since 2011-12-20
	 * @version 2011-12-20
	 *
	 * @param String $username The username of the user
	 * @param String $password The password of the user (in plaintext)
	 *
	 * @return Array $ReturnArray An associative array representing the XML response of the Kayako Fusion API
	 */
	public function logIn($username, $password){
		$url = preg_replace("/http:/i", "https:", $this->SwiftURL) . '/staffapi/index.php?/Core/Default/Login';
		$data = 'username='. utf8_encode($username) . '&password=' . $password;
		$result = $this->Request->post($url, $data);
		if ( $result != FALSE ){
			$result = explode("\r\n\r\n", $result, 2);
			$response = strip_cdata(html_entity_decode($result[1]));
			try{
				libxml_use_internal_errors(TRUE);
				$XMLResponse = new SimpleXMLElement($response);
				$ReturnArray = Array(
					'status' => (String) $XMLResponse->status,
					'error' => (String) $XMLResponse->error,
					'sessionid' => (String) $XMLResponse->sessionid,
					'sessiontimeout' => (String) $XMLResponse->sessiontimeout,
					'staffid' => (String) $XMLResponse->staffid
				);
			return $ReturnArray;
			} catch (Exception $e){
				libxml_use_internal_errors(FALSE);
				log_message('debug', 'Login Error: ' . $e->getMessage());
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	/**
	 * Function: logOut
	 *
	 * This function sends a request to the Kayako Fusion server to terminate the session data for the given
	 * sessionid.
	 *
	 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
	 * @since 2011-12-20
	 * @version 2011-12-20
	 *
	 * @param String $sessionid The string of the session ID obtained when the user logged in through the Staff API
	 *
	 * @return Bool TRUE because even in the event of error, the user will be logged out.
	 */
	public function logOut($sessionid){
		$url = $this->SwiftURL . '/staffapi/index.php?/Core/Default/Login';
		$data = 'sessionid='.$sessionid;
		$this->Request->post($url, $data);
		return TRUE;
	}

	/**
	 * This function submits the ticket data to the Kayako Fusion server.
	 *
	 * @author Joseph T. Anderson
	 * @since 2011-12-02
	 * @version 2012-02-15
	 *
	 * @param Data An associative array containing the essential data to create a ticket
	 *          - Priority: the priority code for the ticket
	 *          - Creator: the ID of the staff creating the ticket
	 *          - Department: the department ID for the ticket
	 *          - Contents: The text to be displayed in the ticket
	 *          - Subject: The subject line for the ticket
	 */
	public function createTicket($Data){
		$default_status_id = kyTicketStatus::getAll()->filterByTitle("Open")->first()->getId();
		$default_priority_id = kyTicketPriority::getAll()->filterByTitle("Normal")->first()->getId();
		$default_type_id = kyTicketType::getAll()->filterByTitle("Issue")->first()->getId();

		kyTicket::setDefaults($default_status_id, $default_priority_id, $default_type_id);

		$Priority = kyTicketPriority::get($Data['Priority']);
		$Creator = kyStaff::get($Data['Creator']);
		$Department = kyDepartment::get($Data['Department']);

		$ticket = kyTicket::createNew($Department, $Creator, $Data['Contents'], $Data['Subject'])
			->setPriority($Priority)
			->setResolutionDue($Data['ResolutionDue']) //TODO: Make this work!
			->create();
		return $ticket;
	}

	/**
	 * This function returns an object (over which can be iterated) that
	 * contains a kyTicketPriority object for each ticket priority
	 * found on the Kayako Fusion system.
	 *
	 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
	 * @since 2011-12-17
	 * @version 2011-12-17
	 *
	 * @return kyResultSet All ticket priorities available on the server.
	 */
	public function getTicketPriorities(){
		return kyTicketPriority::getAll();
	}

	/**
	 * This function retrieves the available departments in which to create a ticket.
	 *
	 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
	 * @since 2011-12-18
	 * @version 2011-12-18
	 *
	 * @return kyResultSet All Departments on the server.
	 */
	public function getDepartments(){
		return kyDepartment::getAll()->filterByModule(kyDepartment::MODULE_TICKETS);
	}

	public function testConnection(){

	}

	/**
	 * This function will add a local barcode image to a ticket as an attachment.
	 *
	 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
	 * @since 2012-02-05
	 * @version 2012-02-05
	 *
	 * @param $TicketID The ID of the ticket
	 * @param $BarcodePath The path to the ticket on the local server
	 *
	 */
	public function addTicketBarcode($TicketID = "", $BarcodePath = ""){
		if ( $TicketID == "" || $BarcodePath == "" ){
			throw new Exception("Invalid DisplayID or Barcode path.");
		}

		$ticket = kyTicket::get($TicketID);
		$user = kyStaff::get($ticket->getCreatorType());
		$post = $ticket
			->newPost($user, "The barcode for this ticket is attached.")
			->create();
		$contents = file_get_contents($BarcodePath);
		$name = "barcode.gif";
		$attachment = kyTicketAttachment::createNew($post, $contents, $name);
		$attachment->create();
		return TRUE;
	}

	/**
	 * This function searches the Fusion server for a ticket and returns the data
	 *
	 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
	 * @since 2012-02-14
	 * @version 2012-02-14
	 *
	 * @param String $ID The ID of the Ticket
	 */
	function search($ID){
		return kyTicket::get($ID);
	}

	/**
	 * This function queries the Kayako Fusion server and finds a staff user by
	 * a given username.  It then returns the kyStaff object
	 *
	 * @author  Joseph T. Anderson <joe.anderson@email.stvincent.edu>
	 * @since 2012-02-15
	 * @version 2012-02-15
	 *
	 * @param string Username The username of the requested user
	 * @return kyUser The user object returned from the call to Kayako
	 */
	function getStaffByUsername($username) {
		return kyStaff::getAll()->filterByUsername($username)->first();
	}
}

/*
 * End of Kayako PHP Library file
 */