<?php
/**
 * This is the view for the login page.  It will be shown
 * if the user does not have a session or is not logged in.
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
 * @since 2011-09-30
 * @version 2011-09-30
 */
?>
<script type="text/javascript" src="/cdn/js/<?php echo ( ENVIRONMENT == 'development' ? '_uncompressed/' : '' ); ?>login.js"></script>
<div class="login_box">
	<h2>Saint Vincent Service Desk Extension</h2>
	<img class="big_logo" src="/cdn/img/shield.gif"/>
	<div id="browser_warning">
		<span class="warn_head">Warning:</span>
		<div class="warn_body">This site is best viewed on a Webkit based broswer. Get one <a href="http://chrome.google.com/">here<a>.</div>
		<!-- <details>
		<summary>Details</summary>
		<p>Your Browser Engine:&nbsp;&nbsp;<span id="browser_name"></span></p>
		<p>Version:&nbsp;&nbsp;<span id="broswer_version"></span></p>
		</details> -->
		<div id="warning_details">
			<h4 class="expansion">Details</h4>
			<div>
				<div>Your Browser:&nbsp;&nbsp;<span id="browser_warning_engine"></span></div>
				<div>Browser Version:&nbsp;&nbsp;<span id="browser_warning_version"></span></div>
			</div>
		</div>
		<script type="text/javascript">
			LoginObj.setBrowserInfo();
		</script>
	</div>
	<script type="text/javascript">
			if ( ! $.browser.webkit ){
				$('#browser_warning').show();
			}
	</script>
	<table>
		<tr>
			<td>Username:</td>
			<td>
				<input id="Username" type="text" size="20"/>
			</td>
		</tr>
		<tr>
			<td>Password:</td>
			<td>
				<input id="Password" type="password" size="20"/>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input id="login_button" type="button" value="Login" onclick="LoginObj.submitLogin();" />
			</td>
		</tr>
		<tr>
			<td colspan='2'>
				<div id="bad_login">
					<img height="15px" width="15px" src="/cdn/img/Red_triangle_alert_icon.png">&nbsp;Login Failed
				</div>
			</td>
		</tr>
	</table>
	<input type="hidden" id="destinationURI" value="<?php echo isset($destination) ? $destination : ''; ?>"/>
</div>
<script type="text/javascript">
	LoginObj.setButtonProperties();
</script>