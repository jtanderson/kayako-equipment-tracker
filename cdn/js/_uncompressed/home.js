/**
 * File: home.js
 * 
 * This file contains javascript exclusive to the Home page
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
 * @since 2011-12-24
 * @version 2011-12-24
 */

var HomeObj = {};

HomeObj.setSubmitDialog = function(){
	$('#submit_dialog').dialog({
 		autoOpen: false,
 		modal: true,
 		draggable: false,
 		resizable: false,
 		title: "Submit Ticket",
 		minWidth: 400,
 		open: function(){
 			$("html,body").css("overflow","hidden");
 		},
 		close: function(){
 			$(this).find('#progressbar').progressbar('value', 0);
 			$('#pBar').attr('value', 1);
 			$("html,body").css("overflow","auto");
 			$('.finished').html('');
 			$('.finished').hide();
 			$('.waiting').show();
 		}
	 });
}

HomeObj.setDocumentDropdownBlur = function(){
	$(document).bind('click', function(){
		return function(){
			$('.menuHeader').each(function(){
				if ( $(this).is(":visible") ){
					$(this).hide();
				}
			});
		}
	}());
}

/**
 * Function submitTicketData
 * 
 * This function is tailored to aggregate the user input on the main ticket creation page and
 * POST the data to the server which will then create a ticket on the standalone database.
 * The server then attempts to contact the designated Kayako Support Suite system to create
 * a ticket with the given information.  See the homeAjax.php controller file for more
 * information on ticket creation and submission.  If the ticket is successfully created on
 * the Support Suite system, a bar code is generated with the Ticket ID (given by S.S.) and
 * it may be printed by the user to be affixed to any relevant hardware.  This fucntion
 * also calls the displayWarning funciton if the backend returns validation errors.
 * Curretnly, this function is called by both the button in the upper "fixed" menu element and
 * the submit button on the bottom of the home screen.
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
 * @since 2011-10-28
 * @version 2011-11-26
 * 
 */

HomeObj.submitTicketData = function(){
	MainObj.clearWarnings();
	var dialog = $('#submit_dialog').dialog('open');
	var postData = {};
	var inputs = $('#client_data input[type!=button], #client_data textarea').not('#display_deadline');
	inputs.each(function(){
		postData[$(this).attr('id')] = $(this).val();
	});
	postData['Priority'] = $('#Priority :selected').val();
	postData['Department'] = $('#Department :selected').val();
	
	if ( $('#display_deadline').val() == "" ){
		postData['Deadline'] = "";
	}
	
	var equipmentArray = $('#equipment_table [id*=Equipment_]').not('#Equipment_DEFAULT');
	equipmentArray.each( function(){
		postData['Equipment['+$(this).attr('id')+'][Make]'] = $(this).find('#Make').val();
		postData['Equipment['+$(this).attr('id')+'][Model]'] = $(this).find('#Model').val();
		postData['Equipment['+$(this).attr('id')+'][Type]'] = $(this).find('#Type').val();
		postData['Equipment['+$(this).attr('id')+'][Notes]'] = $(this).find('#Notes').val();
	});
	
	$.post('/homeAjax/submitTicketData', postData, function(json){
		if ( json != undefined && json['success'] == true ){
			$('#waiting_message').html('Sending to Kayako Fusion...');
			
			// @TODO: Should the request to Kayako be made first and then write the ticket to the local DB?
			// Post a request to create the KF ticket
			$.post('homeAjax/syncTicketWithFusion',{
				'PK_TicketNum': json.TicketID
			}, function(json2){
				if ( json2.success ){
					// Happens when the sync is successful
					$('div.waiting').hide();
					var finishedBox = $('div.finished');
					finishedBox.addClass("barcode");
					finishedBox.css('text-align', 'center');
					finishedBox.append( HomeObj.fetchBarcode(json2.TicketID + '') ); // Cast the TicketID to a string and fetch the barcode
					finishedBox.append("<p>The request is complete.<p>");
					finishedBox.show();
				} else {
					// Ticket did not sync and was not created in Kayako Fusion
					dialog.dialog('close');
					MainObj.jAlert('An Error has occurred.');
				}
			}, 'json');
		} else {
			for ( var i in json.Errors ){
				MainObj.displayWarning(json.Errors[i]);
			}
			dialog.dialog('close');
			document.location = '#';
		}
	}, 'json');
}

/**
 * Function toggleCollapse
 * 
 * This function was implemented early to emulate more complicated functionality of the
 * jquery.collapse.js library.  Customized for the equipment data blocks.
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
 * @since 2011-11-15
 * @version 2011-11-16
 * 
 * @param obj This is the button used clicked to initiate the collapse.
 * 
 */

HomeObj.toggleEquipmentCollapse = function(obj){
	tr = $(obj).closest('tr[id^=Equipment_]');
	// var tr = $('#equipment_'+suffix);
	var table = tr.find('table.equipment');
	if ( table.is(':visible') ){
		tr.find('span.expansion').css('background-position','0 -33px');
		// table.slideUp(200);
		table.hide();
	} else {
		tr.find('span.expansion').css('background-position','0 5px');
		// table.slideDown(200);
		table.show();
		tr.find('input:first').focus();
		$.scrollTo(table);
	}
}

/**
 * Function setEquipmentTitle
 * 
 * Uses the user input to the "Make" and "Model" fields of the equipment data
 * to change the default equipment name to a more meaningful value.  This title
 * will not itself be passed to the server when the ticket is created.
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
 * @since 2011-11-17
 * @version 2011-11-17
 * 
 * @param obj The input field being changed.
 * 
 */

HomeObj.setEquipmentTitle = function(obj){
	var tr = $(obj).closest('tr[id^=Equipment_]');
	// var tr = $('#equipment_'+suffix);
	var titleSpan = tr.find('.equipment_banner span');
	var model = tr.find('input[id=Model]').val();
	var make = tr.find('input[id=Make]').val();
	if ( make == '' && model == '' ){
		titleSpan.html('['+tr.attr('id')+']');
		titleSpan.addClass('unchanged');
	} else {
		titleSpan.html(make + ' ' + model);
		titleSpan.removeClass('unchanged');
	}
}

/**
 * Function addEquipment
 * 
 * When called, this funciton clones the template element, whose id is equipment_DEFAULT,
 * and clones it.  The id is then altered to be an incremental value based on how many
 * existing equipment blocks are already on the screen.
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
 * @since 2011-11-17
 * @version 2011-11-17
 * 
 */

HomeObj.addEquipment = function(){
	var table = $('#equipment_table');
	var templateRow = $('#Equipment_DEFAULT').detach();
	var count = $('#equipment_table > tbody > tr').length + 1;
	var newRow = templateRow.clone();
	newRow.attr('id', 'Equipment_'+count);
	newRow.find('.equipment_banner span').html('[Equipment_'+count+']');
	table.append(newRow);
	table.append(templateRow);
	newRow.show();
	$.scrollTo(newRow);
	newRow.find('input:first').focus();
}

/**
 * Function removeEquipment
 * 
 * This function not only removes and equipment block fromt the screen, but
 * also manages the id's of the onscreen equipment blocks.  Ex: if there are
 * three equipment blocks on the screen and the middle one gets removed, the
 * third will be renamed equipment_2.  Likewise, if the first is removed, the
 * second one becomes equipment_1 and the third becomes equipment_2.  If for
 * some reason jquery pulls the remaining blocks out of order, they are sorted
 * according to the integer at the end of their id and then the renaming process begins.
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
 * @since 2011-11-17
 * @version 2011-11-17
 * 
 * @param obj The button used to initiate the removal.
 * 
 */

HomeObj.removeEquipment = function(obj){
	var exRow = $(obj).closest('.equipment_row');
	exRow.remove();
	var allVisibleRows = $('.equipment_row').not('#Equipment_DEFAULT');
	var count = allVisibleRows.length;
	allVisibleRows.sort(function(a, b){
		return parseInt($(a).attr('id').match(/\d+/)) - parseInt($(b).attr('id').match(/\d+/));
	});
	for ( var i = 1; i <= count; i++ ){
		$(allVisibleRows[i-1]).attr('id', 'Equipment_'+i);
		if ( $(allVisibleRows[i-1]).find('.equipment_banner span').hasClass('unchanged') ){
			$(allVisibleRows[i-1]).find('.equipment_banner span').html('[Equipment_'+i+']');
		}
	}
}

/**
 * Function fetchBarcode
 * 
 * This funciton requests a bar code from the server based on a particular text parameter.
 * The text parameter is sanatized on the server-side function. All letters are converted
 * to uppercase and spaces are converted to hyphens. Other characters are removed.
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
 * @since 2011-11-19
 * @version 2011-11-22
 * 
 * @param text The text used to create the bar code
 * 
 * @return JQuery An Image element containing the barcode
 */

HomeObj.fetchBarcode = function(text){
	if ( text == '' || text == undefined ){
		console.log("Error: No text specified for the barcode");
		return;
	}
	if ( container == undefined ){
		console.log("Error: No container specified.");
		return;
	}
	var newImg = $('<img />');
	text = text.replace(/[^a-zA-Z0-9- ]/g, '');
	$.ajax({
		url: '/homeAjax/createBarcode',
		async: false,
		type: 'POST',
		data: {'text': text},
		dataType: 'json',
		success: function(json){
			if ( json.success != undefined && json.success ){
				$(newImg).attr('src', json.ImageLocation);
			} else {
				console.log('An error has occurred...');
			}
		}
	});
	return newImg;
}

/**
 * Function: HomeObj.setTabEvents
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
 * @since 2012-01-26
 * @version 2012-01-26
 */

HomeObj.setTabEvents = function(){
	$('legend span').each( function(){
		$(this).click( function(){
			$('legend span').removeClass('current');
			$(this).addClass('current');
			var idSplit = $(this).attr('id').split('_');
			var type = idSplit[1];
			$('div[id$=_data]').css('display','none');
			$('div#'+type+'_data').show();
		});
	});
}
