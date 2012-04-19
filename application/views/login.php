<?php
/**
 * This is the view for the login page.  It will be shown
 * if the user does not have a session or is not logged in.
 * 
 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
 * @since 2011-09-30
 * @version 2011-09-30
 */
?>
<div class="login_box">
	<div class="login_top">
		<h2>Kayako Client Equipment Tracking</h2>
		<div class="big_logo"></div>
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
	</div>
	<form id="login_form" method="post" onsubmit="" action="javascript:LoginObj.submitLogin();">
		<table>
			<tr>
				<!-- <td>Username:</td> -->
				<td>
					<input id="Username" placeholder="Username" type="text" size="20"/>
				</td>
			</tr>
			<tr>
				<!-- <td>Password:</td> -->
				<td>
					<input id="Password" placeholder="Password" type="password" size ="20"/>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input id="login_button" type="submit" value="Login" />
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					<div id="bad_login">
						<img height="15px" width="15px" src="<?php echo base_url("/cdn/img/Red_triangle_alert_icon.png"); ?>">&nbsp;Login Failed
					</div>
				</td>
			</tr>
		</table>
	</form>
	<input type="hidden" id="destination_url" value="<?php echo $this->session->userdata('destinationURL') ?: ''; ?>"/>
</div>
<script type="text/javascript">
	LoginObj.setButtonProperties();
	$(document).ready(function(){
		$("#login_form").slideDown(500, function(){
			$('input').first().focus();
		});
	});
</script>