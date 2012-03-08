/**
 * File main.js
 * 
 * This file should contain all general JavaScript functions required by the Kayako Extension
 * 
 * @since 2011-10-28
 * 
 */

var MainObj = {};

/**
 * Function jAlert
 * 
 * This function is a shortcut to dynamically create a jQuery based dialog box that
 * essentially replaces the browser's default "alert" box.  When the dialog is closed,
 * the element created is removed from the DOM.
 * 
 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
 * @since 2011-10-28
 * @version 2011-10-28
 * 
 * @param String text The message text to be displayed
 */

MainObj.jAlert = function(text){
	var alertBox = $('<div></div>');
	alertBox.css('display', 'none');
	alertBox.html(text);
	$('body').append(alertBox);
	alertBox.dialog({
		title: 'Alert',
		modal: true,
		minWidth: 400,
		resizable: false,
		draggable: false,
		close: function(){
			$(this).remove();
		}
	});
}


/**
 * Function logOut
 * 
 * This function makes an Ajax request to the server to destroy any session data created
 * when the user authenticated.  If the user is not authenticated, the action gracefully
 * stops and simply reloads the page.  When the fuction is successful, the page is reloaded
 * and the login page is displayed.
 * 
 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
 * @since 2011-10-28
 * @version 2011-10-28
 * 
 */
MainObj.logOut = function(){
	$.post('/homeAjax/logOut', {}, function(json){
		console.log(json);
		if ( json.success != undefined && json.success ){
			location.href="/";
		} else {
			alert('There has been an error while trying to log out.');
		}
	}, 'json');
};



/**
 * Function displayWarning
 * 
 * This funciton uses the default layout for a warning and duplicates it.  The text is then
 * populated using the appropriate parameter.
 * 
 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
 * @since 2011-11-22
 * @version 2011-12-19
 * 
 * @param String text The warning text to be displayed.  HTML is acceptable.
 */

MainObj.displayWarning = function(text){
	if ( text != undefined && typeof(text) == "string" ){
		var container = $('#message_container');
		var newErrorBox = $('#DEFAULT_warning').clone();
		var idx = $('#message_container').find("[id$=_warning]").not("#DEFAULT_warning").length;
		newErrorBox.attr('id', idx+'_warning');
		newErrorBox.find('.warning_text').html(text);
		newErrorBox.css('display','');
		container.append(newErrorBox);
	} else {
		console.log("Warning: displayWarning function called with unacceptable parameters.");
	}
}

/**
 * Function removeWarning
 * 
 * This funciton removes a warning. Called from a button within the warning container.
 * 
 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
 * @since 2011-11-23
 * @version 2011-11-23
 * 
 * @param element The button clicked to remove the warning.
 * 
 */

MainObj.removeWarning = function(element){
	$(element).closest('div').detach();
}

/**
 * Function clearWarnings
 * 
 * This function removes all warnings on the screen.  Currently only called
 * from submitTicketData.
 * 
 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
 * @since 2011-11-23
 * @version 2011-11-23
 * 
 */

MainObj.clearWarnings = function(){
	var container = $('#message_container');
	container.find('.message').not('#DEFAULT_warning').remove();
}

MainObj.removeScriptTags = function(str){
	str = str + '';
	str = str.replace(/<(\/)?script[^>]*>/ig, '');
	return str;
}