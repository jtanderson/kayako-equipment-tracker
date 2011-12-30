/**
 * File: login.js
 * 
 * This file contains the javascript exclusive to the login page
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
 * @since 2011-12-24
 * @version 2011-12-24
 */

var LoginObj = {};

/**
 * Function submitLogin
 * 
 * This function processes the data on the login form and makes a request to the server for database
 * authentication.  On a successful login, the user is directed to the home page. On failure, a
 * notice is displayed.
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
 * @since 2011-10-28
 * @version 2011-10-28
 */

LoginObj.submitLogin = function(){
	$('#login_button').attr('disabled', 'disabled');
	$('#login_button').val('Please Wait...');
	postData = {};
	postData['Username'] = $('#Username').val();
	postData['Password'] = $('#Password').val();
	
	$.post('/homeAjax/authenticateUser', postData, function(json){
		console.log(json);
		if ( json['success'] != undefined && json['success'] == true ){
			if ( $('#bad_login').is(':visible') ){
				$('#bad_login').toggle();
			}
			location.reload();
		} else {
			$('#bad_login').slideDown(500);
			$('#Username').focus();
		}
		$('#login_button').removeAttr('disabled');
		// $('#login_button').val('Login');
	}, 'json');
}

LoginObj.setBrowserInfo = function(){
	$('#browser_warning_engine').html($.client.browser);
	$('#browser_warning_version').html($.browser.version);
	$('#warning_details').collapse({
		head: 'h4',
		show: function() {
	        this.animate({
	            opacity: 'toggle', 
	            height: 'toggle'
	        }, 300);
	    },
	    hide: function() {
	        this.animate({
	            opacity: 'toggle', 
	            height: 'toggle'
	        }, 300);
	    }
	});
}

LoginObj.setButtonProperties = function(){
	$('input#Username').focus();
	$('input#Password').keyup(function(e){
		if ( e.keyCode == 13 ){
			$('#login_button').click();
		}
	});
	$('input#Username').keyup(function(e){
		if ( e.keyCode == 13 ){
			$('#login_button').click();
		}
	});
	$('#login_button').button();
}
