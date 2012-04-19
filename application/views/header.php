<?php
/**
 * This is the footer file for the Kayako Extension Application
 * 
 * @author Joseph T. Anderson
 * @since 2011-09-30
 * @version 2011-09-30
 * 
 */
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Kayako Equipment Tracker</title>
		<?php $this->carabiner->display('css'); $this->carabiner->display('js'); ?>
		<script type="text/javascript">
			var BASE_URL = "<?php echo site_url(); ?>";
		</script>
	</head>
	<!-- Begin Body -->
	<body>
		<?php if ($this->session->userdata('logged_in') ){
			$this->load->view('cpanel');
		} ?>