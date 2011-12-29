<?php
/**
 * This file contains the data that will be appended to the end of a
 * response to a non-AJAX request
 * 
 * @author Joseph T. Anderson
 * @since 2011-09-30
 * @version 2011-12-17
 */
?>
	<div class="footer_data">
		Developed by Joseph T. Anderson<br/>
		Powered by CodeIgniter: Version <?php echo CI_VERSION;?>
	</div>
	<script type="text/javascript">	
		if ( ! $.browser.webkit ){
			displayWarning('This site is best viewed on a webkit-based browser. Get one <a href="http://chrome.google.com">here</a>.');
		}
	</script>
	</body>
	<!-- End Body -->
</html>