<?php

class Database {

	// Function to the database and tables and fill them with the default data
	function create_database($data)
	{
		// Connect to the database
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],'');

		// Check for errors
		if(mysqli_connect_errno())
			return false;

		// Create the prepared statement
		$mysqli->query("CREATE DATABASE IF NOT EXISTS ".$data['database']);

		// Close the connection
		$mysqli->close();

		return true;
	}

	// Function to create the tables and fill them with the default data
	function create_tables($data)
	{
		// Connect to the database
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);

		// Check for errors
		if(mysqli_connect_errno())
			return false;

		// Open the default SQL file
		$query = file_get_contents('assets/install.sql');

		// Execute a multi query
		// $mysqli->multi_query($query);
		
		if ($mysqli->multi_query($query)) {
		    do {
		        /* store first result set */
		        if ($result = $mysqli->store_result()) {
		            $result->free();
		        }
		    } while ($mysqli->next_result());
		}
		
		/**
		 *  Insert the Kayako Fusion Settings into the database
		 */
		$KayakoQuery = "INSERT INTO `TB_APISetting` (`PK_APISettingNum`, `U_Title`, `Value`, `Display_Title`) VALUES
		(1, 'APIKey', '%s', 'API Key'),
		(2, 'SwiftURL', '%s', 'Swift URL'),
		(3, 'APISecretKey', '%s', 'API Secret Key');";
		
		$query = sprintf($KayakoQuery, $mysqli->real_escape_string($data['kayakoapi']), $mysqli->real_escape_string($data['swifturl']), $mysqli->real_escape_string($data['kayakosecretkey']));
		
		if ($mysqli->multi_query($query)) {
		    do {
		        /* store first result set */
		        if ($result = $mysqli->store_result()) {
		            $result->free();
		        }
		    } while ($mysqli->next_result());
		}
		
		// $mysqli->multi_query($query);
		
		$KayakoQuery = "INSERT INTO `TB_User` (`First`, `Last`, `Email`, `Password`, `U_Username`) VALUES
		('Offline', 'Administrator', '', '%s', '%s');";
		
		$query = sprintf($KayakoQuery, $this->__encrypt($data['offlineadminpassword']) ,$mysqli->real_escape_string($data['offlineadminname']));
		
		// echo $query;exit;
		
		if ($mysqli->multi_query($query)) {
		    do {
		        /* store first result set */
		        if ($result = $mysqli->store_result()) {
		            $result->free();
		        }
		    } while ($mysqli->next_result());
		}

		// Close the connection
		$mysqli->close();

		return true;
	}
	
	function __encrypt($string){
		return md5($string);
	}
}
?>