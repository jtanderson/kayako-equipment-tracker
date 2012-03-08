/**
 * File: Settings.js
 * 
 * This file contains the javascript exclusive to the /Home/Settings module
 * 
 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
 * @since 2011-12-24
 * @version 2011-12-24
 */

var SettingsObj = {};

/**
 * Function: setPrefTableInputs
 * 
 * This function sets the fields on the "Settings" page to change to 
 * inputs when they are clicked and back to <span> elements when the focus
 * is lost.
 * 
 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
 * @since 2011-12-23
 * @version 2011-12-24
 */

SettingsObj.setPrefTableInputs = function(){
    $('.pref_table').find('td.pref_value.hybrid').each( function(){
        $(this).click( function(el){
            return function(){
            	$('.active').removeClass('active');
    			el.addClass('active');
                var span = el.find('span');
				var classes = span.attr('class');
                var val = span.html();
                var fieldId = span.attr('id');
                var inp = $('<input type="text"></input>');
                inp.attr('id', fieldId);
                inp.val(val);
                inp.focus( function(){
                   $(this).select(); 
                });
                inp.keydown( function(e){
                	switch ( e.which ){
                		case 13:
                			$(this).change();
							$(this).blur();
                			break;
                		case  9:
                			event.preventDefault();
							var elements = $('.pref_table:visible').find('td.pref_value.hybrid');
							var counter = 0;
							elements.each(function(){
								if ( $(this).is('.active') ){
									if ( e.shiftKey ){
										if ( counter == 0 ){
											$(elements[elements.length - 1]).click();
										} else {
											$(elements[counter-1]).click();
										}
									} else { // No Shift Key
										if( counter == elements.length - 1 ){
											$(elements[0]).click();
										} else {
											$(elements[counter+1]).click();
										}
									}
									return false;
								}
								counter++;
							});
                			break;
                		default:
                			break;
                	}
                });
				inp.change( function(){
					SettingsObj.updateSetting($(this));
				});
                inp.blur( function(){
                    var newSpan = $('<span><span>');
                    newSpan.attr('id', fieldId);
					newSpan.attr('class', classes);
                    var html = MainObj.removeScriptTags($('#'+fieldId).val());
                    newSpan.html( html );
                    $('#'+fieldId).replaceWith(newSpan);
                });
                span.replaceWith(inp);
                inp.focus();
            }
        }($(this)));
    });
}

/**
 * Function: saveSettings
 * 
 * This function handles the submission of setting values to the server.
 * 
 * @author Joseph T. Anderson <joe.anderson@email.stvincent.edu>
 * @since 2011-12-24
 * @version 2011-12-24
 */

SettingsObj.saveSettings = function(){
	postData = {};
	$('.pref_table').find('td.pref_value.hybrid input').blur();
	$('#prefs_user .pref_value > span').each( function(){
		postData['UserData[' + $(this).attr('id') + ']'] = $(this).html();
	});
	$('.pref_table').not('#prefs_user').find('.pref_value > span').each( function(){
		postData['Settings[' + $(this).attr('id') + ']'] = $(this).html();
	});
	postData['PK_UserNum'] = $('#PK_UserNum').val();
	$.post('/homeAjax/updateSettings', postData, function(json){
		if ( json.success != undefined && json.success == true ){
			console.log('Success');
		} else {
			console.log("FAILURE");
		}
	}, 'json');
	// console.log( postData );
}


SettingsObj.updateSetting = function(el){
	var postData = {};
	postData[$(el).attr('id')] = $(el).val();
	console.log(postData);
	$.post('/homeAjax/updateSetting', postData, function(json){
		console.log(json);
	}, 'json');
}

SettingsObj.setTabEvents = function(){
	$('legend span').each( function(){
		$(this).click( function(){
			$('legend span').removeClass('current');
			$(this).addClass('current');
			var idSplit = $(this).attr('id').split('_');
			var type = idSplit[1];
			$('table[id^=prefs_]').css('display','none');
			$('table#prefs_'+type).show();
		});
	});
}
