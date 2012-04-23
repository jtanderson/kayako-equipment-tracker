<?php

class Core {

	// Function to validate the post data
	function validate_post($data)
	{
		// Counter variable
		$counter = 0;

		// Validate the hostname
		if(isset($data['hostname']) AND !empty($data['hostname'])) {
			$counter++;
		}
		// Validate the username
		if(isset($data['username']) AND !empty($data['username'])) {
			$counter++;
		}
		// Validate the password
		if(isset($data['password']) AND !empty($data['password'])) {
		  // pass
		}
		// Validate the database
		if(isset($data['database']) AND !empty($data['database'])) {
			$counter++;
		}
		// Validate the Kayako API Key
		if(isset($data['kayakoapi']) AND !empty($data['kayakoapi'])){
			//None
		}
		// Validate the Swift URL
		if(isset($data['swifturl']) AND !empty($data['swifturl'])){
			//None
		}
		// Validate the Kayako Secret Key
		if(isset($data['kayakosecretkey']) AND !empty($data['kayakosecretkey'])){
			//None
		}
		// Validate the Offline Administrator Username
		if(isset($data['offlineadminname']) AND !empty($data['offlineadminname'])){
			$counter++;
		}
		// Validate the Offline Administrator Password
		if(isset($data['offlineadminpassword']) AND !empty($data['offlineadminpassword'])){
			$counter++;
		}

		// Check if all the required fields have been entered
		if($counter == 5) {
			return true;
		}
		else {
			return false;
		}
	}

	// Function to show an error
	function show_message($type,$message) {
		return $message;
	}

	// Function to write the config file and the index file
	function write_config($data) {

		// Config path
		$template_path 	= 'config/database.php';
		$output_path 	= '../application/config/database.php';
		$index_template	= 'config/index.php';
		$index_path		= '../index.php';

		// Open the file
		$database_file = file_get_contents($template_path);

		$new  = str_replace("%HOSTNAME%",$data['hostname'],$database_file);
		$new  = str_replace("%USERNAME%",$data['username'],$new);
		$new  = str_replace("%PASSWORD%",$data['password'],$new);
		$new  = str_replace("%DATABASE%",$data['database'],$new);
		// $new  = str_replace('$config[\'firstrun\'] = FALSE;', '$config[\'firstrun\'] = TRUE;', $new);

		$index_file = file_get_contents($index_template);
		$new_index = str_replace("define('FIRSTRUN', FALSE);", "define('FIRSTRUN', TRUE);", $index_file);
		
		// Write the new database.php file
		$handle = fopen($output_path,'w+');
		$index_handle = fopen($index_path,'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path, 0777);
		@chmod($index_path, 0777);

		// Verify file permissions
		if(is_writable($output_path) && is_writable($index_path)) {

			// Write the file
			if(fwrite($handle,$new) && fwrite($index_handle, $new_index)) {
				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}
}
?>