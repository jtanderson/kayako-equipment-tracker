<?php
/**
 * This controller will handle Ajax requests to the site.
 * 
 * @author Joseph T. Anderson
 * @since 2011-09-30
 * @version 2011-09-30
 * 
 */

 class HomeAjax extends MY_Controller{
 	
	var $DocumentArray = Array(
        'Errors' => Array(),
        'success' => FALSE
    );
	
 	function __construct(){
		parent::__construct();
		
		if ( ! $this->input->is_ajax_request() ){
			// show_404();
		}
 	}
	
	/** Function authenticateUser
	 * 
	 * This function handles the request for a user to sign in.  It calls the User model to
	 * verify that the password (md5 encrypted) matches a record for the passed username
	 * on the TB_User table. 
	 * 
	 * NOTE: All parameters are taken from the POST method.
	 * 
	 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
	 * @since 2011-11-30
	 * @version 2011-11-30
	 * 
	 * @param $username The user's registered username
	 * @param $password The user's password (in plain text)
	 * 
	 */
	
	function authenticateUser(){
		$this->load->model('User');
		$this->load->library('Kayako');
		
		$this->DocumentArray['success'] = FALSE;
		
		$username = $this->input->post('Username');
		$password = $this->input->post('Password');
		
		$KayakoLogin = $this->kayako->logIn($username, $password);
		if ( $KayakoLogin !== FALSE && $KayakoLogin['status'] == "1" ){
			if ( ! $this->User->userExists($username) ){
				$this->User->addUser($username, md5($password));
				
				//@TODO: Fetch user details from Kayako server and add to local database at some point
			}
            $id = $this->User->getUserPKFromUName($username);
			$this->DocumentArray['success'] = TRUE;
			$sess_data = Array(
				'username' => $username,
				'logged_in' => TRUE,
				'KayakoSessionID' => $KayakoLogin['sessionid'],
				'StaffID' => $KayakoLogin['staffid'],
				'LocalID' => $id
			);
			$this->session->set_userdata($sess_data);
            
            $this->load->library('Kayako');
            try{
                $PriorityArray = $this->kayako->getTicketPriorities() ?: Array();
                $this->load->model('Priority');
                $newValues = Array();
                foreach ( $PriorityArray as $priority ){
                    $newValues[$priority->getId()] = $priority->getTitle();
                }
                $this->Priority->refreshTable($newValues);
                
                $DepartmentArray = $this->kayako->getDepartments() ?: Array();
                $this->load->model('Department');
                $newValues = Array();
                foreach ( $DepartmentArray as $department ){
                    $newValues[$department->getId()] = $department->getTitle();
                }
                $this->Department->refreshTable($newValues);
            } catch ( Exception $e ){
                $this->DocumentArray['Errors'] []= "The system could not connect to the Kayako Fusion Server. Try <a href=\"javascript:location.reload();\">refreshing</a>.";
                log_message('error', "Kayako Error: " . $e->getMessage());
            }
		} else {
			$this->DocumentArray['success'] = FALSE;
			$this->DocumentArray['message'] = "Authentication Failed";
		}
		
		$this->output->append_output(json_encode($this->DocumentArray));
	}
	
	/**
	 * Function logOut
	 * 
	 * This funciton simply destroys the current session.  By doing this, the user 
	 * is "logged out" of the system.
	 * 
	 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
	 * @since 2011-11-30
	 * @version 2011-11-30
	 * 
	 */
	
	function logOut(){
		if ( $this->session->userdata('KayakoSessionID') ){
			$this->load->library('Kayako');
			$this->kayako->logOut($this->session->userdata('KayakoSessionID'));
		}
		$this->session->sess_destroy();
		$this->DocumentArray['success'] = TRUE;
		$this->output->append_output(json_encode($this->DocumentArray));
	}
	
	/**
	 * Function submitTicketData
	 * 
	 * This function takes the ticket data sent through POST variables.  Form validation
	 * libaries are invoked with appropriate rules.  Any error stops the function and sends
	 * the validation errors in a JSON format to be displayed to the user.  If the form
	 * validation runs without error, then the data in passed to the Ticket, Equipment,
	 * and User models to be entered into the ticket log. 
	 * 
	 * NOTE: All listed params are from POST variables
	 * 
	 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
	 * @since 2011-11-30
	 * @version 2011-11-30
	 * 
	 * @param Array $Equipment The array of equipment data objects (in the form of associative arrays containing: Make, Model, Type, Notes)
	 * @param String $FirstName The first name of the client
	 * @param String $LastName The last name of the client
	 * @param String $Issue The long description of the ticket
	 * @param String $Subject The title for the ticket
	 * @param String $Email The client's address
	 * @param String $Phone The client's phone number
	 * @param Date $Deadline The due date of the ticket
	 * @param Mixed $Priority The priority of the ticket
	 * 
	 * @param Mixed InsertArray The amalgamation of all POST data
	 * 
	 */
	
	function submitTicketData(){
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('','');
		
		$equipmentArray = $this->input->post('Equipment');
		
		if ( is_array($equipmentArray) ){
			foreach ( $equipmentArray as $key => $equipment ){
				$this->form_validation->set_rules('Equipment['.$key.'][Make]', 'Equipment '.preg_replace('/Equipment_/', '', $key).' Make', 'trim|required');
				$this->form_validation->set_rules('Equipment['.$key.'][Model]', 'Equipment '.preg_replace('/Equipment_/', '', $key).' Model', 'trim|required');
			}
		}
		
		$this->form_validation->set_rules('FirstName', 'First Name', 'trim|required');
		$this->form_validation->set_rules('LastName', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('Issue', 'Issue', 'trim|required');
		$this->form_validation->set_rules('Phone', 'Phone', 'trim|required');
		$this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('Subject', 'Subject', 'trim|required');
		$this->form_validation->set_rules('Priority', 'Priority', 'trim|required');
		$this->form_validation->set_rules('Deadline', 'Deadline', 'trim|required');
		$this->form_validation->set_rules('Department', 'Department', 'trim|required');
		
		if ( $this->form_validation->run() ){
			$InsertArray = $this->input->post();
			$InsertArray['Staff'] = $this->session->userdata('StaffID');
			
			$this->load->model('Ticket');
			if ( $TicketID = $this->Ticket->createTicket($InsertArray) ){
				if ( is_array($equipmentArray) ){
					$this->load->model('Equipment');
					foreach ( $equipmentArray as $key => $equipment ){
						$equipment['FK_TicketNum'] = $TicketID;
						if ( ! $this->Equipment->createEquipment($equipment) ){
							$this->DocumentArray['success'] = FALSE;
							$this->DocumentArray['Errors'] []= "There was a problem adding the equipment to the database.";
							$this->output->append_output(json_encode($this->DocumentArray));
							exit;
						}
					}
				}
				$this->DocumentArray['success'] = TRUE;
				$this->DocumentArray['TicketID'] = $TicketID;
			} else {
				$this->DocumentArray['success'] = FALSE;
				$this->DocumentArray['Errors'] []= "There was a problem writing the ticket to the database.  Please Try again.";
			}

		} else {
			$this->DocumentArray['success'] = FALSE;
			$errorString =  preg_replace("/[\n\r]/","###",trim(validation_errors()));
			$this->DocumentArray['Errors'] = explode('###', $errorString);
		}
		
		$this->output->append_output(json_encode($this->DocumentArray));
	}

	/**
	 * Function syncTicketWithFusion
	 * 
	 * This function will use the Kayako libraries to send a ticket information
	 * to the Kayako Fusion system.  It will retrieve the ID and write it to the 
	 * database.
	 * 
	 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
	 * @since 2011-11-30
	 * @version 2011-11-30
	 * 
	 * @param Integer $LocalTicketID The ID of the ticket on this system passed throught the POST variable 'PK_TicketNum'
	 */

	function syncTicketWithFusion(){
		$this->load->model('Ticket');
		$this->load->model('Equipment');
		
		$LocalTicketID = $this->input->post('PK_TicketNum');
		
		$TicketData = $this->Ticket->getTicketData($LocalTicketID);
		
		if ( $TicketData !== FALSE ){
		    // @TODO: Set the Due Date - probably as "Resolution Due"
			$Subject = $TicketData['Subject'];
			
			$StaffID = $TicketData['Staff'];
			$DepartmentID = $TicketData['Department'];
			$PriorityID = $TicketData['Priority'];
			
			$ContentFormat = "Ticket for user: %s %s ".PHP_EOL.
			"Phone Number: %s".PHP_EOL.
			"Email: %s".PHP_EOL.PHP_EOL.
			"Problem:".PHP_EOL.
			"%s".PHP_EOL.PHP_EOL;
			
			$Contents = sprintf($ContentFormat, $TicketData['FirstName'], $TicketData['LastName'], $TicketData['Phone'], $TicketData['Email'], $TicketData['Issue']);
			
			$EquipmentArray = $this->Equipment->getEquipmentForTicket($LocalTicketID);
			if ( $EquipmentArray !== FALSE ){
				$Contents .= "Equipment brought for service:".PHP_EOL.PHP_EOL;
				$EquipmentFormat = "%s %s %s".PHP_EOL;
				foreach ( $EquipmentArray as $equipment ){
					$Contents .= sprintf($EquipmentFormat, $equipment['Brand'], $equipment['Model'], $equipment['Type']);
					if ( trim($equipment['Notes']) != ""){
						$Contents .= "Notes:".PHP_EOL.$equipment['Notes'].PHP_EOL;
					}
					$Contents .= PHP_EOL;
				}
			}
			
			$TicketConfig = Array(
				'Creator' => $StaffID,
				'Priority' => $PriorityID,
				'Department' => $DepartmentID,
				'Contents' => $Contents,
				'Subject' => $Subject
			);
            
			try {
                $this->load->library('Kayako');
                $FusionID = $this->kayako->createTicket($TicketConfig);
                
                $this->Ticket->update($LocalTicketID, Array('FusionID'=>$FusionID));
                
				$this->DocumentArray['TicketID'] = $FusionID;
				$this->DocumentArray['success'] = TRUE;
			} catch ( Exception $e ){
				$this->DocumentArray['success'] = FALSE;
				$this->DocumentArray['Errors'] []= $e->getMessage();
			}
		} else {
			$this->DocumentArray['success'] = FALSE;
			$this->DocumentArray['Errors'] []= "The ticket was not found in the database.";
		}
		
		$this->output->append_output(json_encode($this->DocumentArray));
	}
	
	function test(){
		$this->load->library('Kayako');
		$this->output->append_output($this->kayako->test());
	}

	/**
	 * This function will return an image file to the requesting agent.
	 * To access this image, create a <img> tag with the src attribute
	 * pointing to the address that will return the appropriate bar code.
	 * 
	 * Ex: $('body').append('<img src="/homeAjax/createBarcode/TEST BARCODE"/>')
	 * 
	 * The extra characters in the URL should be converted in the request and
	 * the will be decoded in the function.
	 * 
	 * @author Joseph T. Anderson
	 * @since 2011-11-15
	 * @version 2011-11-15
	 * 
	 * @param String $text The text to be used to create a bar code
	 */
	
	function createBarcode($text){
		$this->load->library('zend');
		$this->zend->load('Zend/Barcode');
        $this->zend->load('Zend/Config');
        $this->zend->load('Zend/Pdf');
		$this->zend->load('Zend/Barcode/Renderer/Image');
        
        $pdf = new Zend_Pdf();
		
		// $text = $this->input->get('barcode_text');
		// $text = $this->input->post('text');
		$text = urldecode($text);  // In case there are spaces or other url encoded characters
		$text = strtoupper($text); // Many barcodes will not accept lower case
		$text = preg_replace('/[ ]/', '-', $text); // Most bar codes do not allow spaces - replace with a hyphen
		$text = preg_replace('/[^a-zA-Z0-9-]/', '', $text);  // Clean out any character not a letter, number, or hyphen
		if ( $text == '' ){
			$text = 'DEFAULT';
		}
		
		$config = new Zend_Config(array(
            'barcode'        => 'Code128',
            'barcodeParams'  => array('text' => $text),
            'renderer'       => 'image',
            'rendererParams' => array('imageType' => 'gif'),
        ));
			
		$renderer = Zend_Barcode::factory($config);
        $pdfWithBarcode = Zend_Barcode::factory($config)->setResource($pdf)->draw();
        
        // TODO: make sure this stuff works...
        
        $pdfWithBarcode->save(APPBASEPATH . '../cdn/pdf/' . $text);
        $this->load->model('Ticket');
        $this->Ticket->update(Array('PDFPath'=>APPBASEPATH . '../cdn/pdf/' . $text));
		
		$this->output->append_output($renderer->render());
	}

    function updateSettings(){
        $SettingsArray = $this->input->post('Settings');
        $UserProfileArray = $this->input->post('UserData');
        $PKUserNum = $this->input->post('PK_UserNum');
        
        $this->load->model('User');
        $this->load->model('Setting');
        $this->load->model('UserSetting');
        $this->User->update(Array('PK_UserNum'=>$PKUserNum), $UserProfileArray);
        
        // TODO: Finish saving settings to the database.
        // TODO: Decide on how to arrange the settings: categories, or all just generic settings? For now, all fields not on the TB_User table will fall into the Settings array
        
        foreach ( $SettingsArray as $title => $value ){
            if ( $settingPK = $this->Setting->getPKFromTitle($title) ){
                if ( ! $this->UserSetting->find_where(Array('PKa_UserNum'=>$PKUserNum, 'PKb_SettingNum'=>$settingPK)) ){
                    $this->UserSetting->insert(Array('PKa_UserNum'=>$PKUserNum, 'PKb_SettingNum'=>$settingPK, 'Value'=>$value));
                } else {
                    $this->UserSetting->update_where(Array('PKa_UserNum'=>$PKUserNum, 'PKb_SettingNum'=>$settingPK), Array('Value'=>$value));
                }
            }
        }
        
        $this->DocumentArray['success'] = TRUE;
        $this->output->append_output(json_encode($this->DocumentArray));
    }
	
	function __finalize(){
		parent::__finalize();
	}
 }
