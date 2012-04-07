<?php

error_reporting(E_ALL);

$db_config_path = '../application/config/database.php';

// Only load the classes in case the user submitted the form
if($_POST) {

	// Load the classes and create the new objects
	require_once('includes/core_class.php');
	require_once('includes/database_class.php');

	$core = new Core();
	$database = new Database();


	// Validate the post data
	if($core->validate_post($_POST) == true)
	{

		// First create the database, then create tables, then write config file
		if($database->create_database($_POST) == false) {
			$message = $core->show_message('error',"The database could not be created, please verify your settings.");
		} else if ($database->create_tables($_POST) == false) {
			$message = $core->show_message('error',"The database tables could not be created, please verify your settings.");
		} else if ($core->write_config($_POST) == false) {
			$message = $core->show_message('error',"The database configuration file could not be written, please chmod /application/config/database.php file to 777");
		}

		// If no errors, redirect to registration page
		if(!isset($message)) {
		  $redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
      $redir .= "://".$_SERVER['HTTP_HOST'];
      $redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
      $redir = str_replace('install/','',$redir);
			header( 'Location: ' . $redir . 'home' ) ;
		}

	}
	else {
		$message = $core->show_message('error','Not all fields have been filled in correctly. The host, username, password, database name, and offline user details are required.');
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title>Install | Kayako Equipment Tracker</title>
		<link rel="stylesheet" href="assets/bootstrap.min.css" type="text/css" media="screen" title="bootstrap" charset="utf-8">
		<script type="text/javascript" src="assets/jquery-1.7.1.min.js"></script>
		<script src="assets/bootstrap.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" charset="utf-8">
			var currentPanel = 1;
			
			function nextPanel(){
				if ( currentPanel < 3 ){
					$("#install_panel_" + currentPanel).fadeOut(200, function(){
						currentPanel++;
						$("#install_panel_" + currentPanel).fadeIn();}
					);
				}
			}
			
			function previousPanel(){
				if ( currentPanel > 1){
					$("#install_panel_" + currentPanel).fadeOut(200, function(){
						currentPanel--;
						$("#install_panel_" + currentPanel).fadeIn();}
					);
				}
			}
		</script>
	</head>
	<body style="padding: 20px;">

	<div class="container">
		<div class="row">
			<div class="span8 offset2">
		    	<h1>Kayako Equipment Tracker Installation</h1><br/><br/>			
			</div>
		<div>
		<div class="row">
			<div class="span8 offset2">
				<p>This page is to facilitate the installation of the <a href="http://jtanderson.github.com/kayako-equipment-tracker/">Kayako Client Equipment Tracking System</a>.</p>

				<p>Proceed through the form below and the important settings for your system will be taken care of automagically.  Note that if you intend to use a
				dedicated database user for the system, be sure to create that user on the database before running this install script.</p><br/><br/>
			</div>
		</div>
		<div class="row">
			<div class="span8 offset2">
		    	<?php if(is_writable($db_config_path)):?>

				<?php if(isset($message)) {echo '<p class="alert alert-error">' . $message . '</p>';}?>
				<form id="install_form" method="post" class="well" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<fieldset id="install_panel_1">
						<legend>Database</legend>
						<label for="hostname">Database Hostname</label><input type="text" id="hostname" value="localhost" class="input_text" name="hostname" />
						<label for="username">Database Username</label><input type="text" id="username" class="input_text" name="username" />
						<label for="password">Database Password</label><input type="password" id="password" class="input_text" name="password" />
						<label for="database">Database Name</label><input type="text" id="database" class="input_text" name="database" /><br/>
						<input type="button" class="btn" value="Next &#x2192;" onclick="nextPanel();" id="next_1" />
					</fieldset>
					<fieldset id="install_panel_2" style="display:none;">
						<legend>Kayako Fusion</legend>
		  		  		<label for="kayakoapi">Kayako API Key</label><input type="text" id="kayakoapi" class="input_text" name="kayakoapi" />
				  		<label for="swifturl">Kayako URL</label><input type="text" id="swifturl" class="input_text" name="swifturl" />
				  		<label for="kayakosecretkey">Kayako Secret Key</label><input type="text" id="kayakosecretkey" class="input_text" name="kayakosecretkey" /><br/>
						<input type="button" class="btn" value="Back &#x2190;" onclick="previousPanel();" id="next_1" />
						<input type="button" class="btn" value="Next &#x2192;" onclick="nextPanel();" id="next_1" />
					</fieldset>
					<fieldset id="install_panel_3" style="display:none;">
						<legend>Offline Administrator</legend>
						<label for="offlineadminname">Name</label><input type="text" id="offlineadminname" class="input_text" name="offlineadminname" />
						<label for="offlineadminpassword">Password</label><input type="password" id="offlineadminpassword" class="input_text" name="offlineadminpassword" /><br/>
						<input type="button" class="btn" value="Back &#x2190;" onclick="previousPanel();" id="next_1" />
						<input type="submit" class="btn btn-primary" value="Finish" id="submit" />
					</fieldset>
				</form>

				<?php else: ?>
					<p class="error">Please make the /application/config/database.php file writable. <strong>Example</strong>:<br /><br /><code>chmod 777 application/config/database.php</code></p>
				<?php endif; ?>
			</div>
		</div>
	</div>

	</body>
</html>