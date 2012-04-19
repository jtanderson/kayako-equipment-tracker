/**
 * File: login.js
 * 
 * This file contains the javascript exclusive to the login page
 * 
 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
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
 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
 * @since 2011-10-28
 * @version 2011-10-28
 */

LoginObj.submitLogin = function(){
	$.blockUI({ css: { 
        border: 'none', 
        padding: '15px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .7, 
        color: '#fff' 
    	},
    	message: '<h1 style="color: inherit;">Please Wait...</h1>'
    });
	$('#login_button').attr('disabled', 'disabled');
	postData = {};
	postData['Username'] = $('#Username').val();
	postData['Password'] = $('#Password').val();
	
	$.post(BASE_URL + '/homeAjax/authenticateUser', postData, function(json){
		if ( json['success'] != undefined && json['success'] == true ){
			if ( $('#bad_login').is(':visible') ){
				$('#bad_login').toggle();
			}
			var url = $("#destination_url").val();
			if ( url == "" ){
				location.reload();
			} else {
				location.href = url;
			}
		} else {
			$.unblockUI();
			$('#bad_login').slideDown(500);
			$('#Username').focus();
		}
		$('#login_button').removeAttr('disabled');
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
	// $('input#Password').keyup(function(e){
	// 	if ( e.keyCode == 13 ){
	// 		LoginObj.submitLogin();
	// 	}
	// });
	// $('input#Username').keyup(function(e){
	// 	if ( e.keyCode == 13 ){
	// 		LoginObj.submitLogin();
	// 	}
	// });
	$('#login_button').button();
}
