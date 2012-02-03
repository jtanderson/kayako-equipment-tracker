/**
 * File: Search.js
 * 
 * This file will hold the JavaScript for the search page
 * 
 * @author Joseph T. Anderson
 * @since 2012-02-01
 * @version 2012-02-01
 */

var SearchObj = {};


/**
 * Funciton: SearchObj.setSearchBarCSS
 * 
 * This funciton is used to apply even listeners and
 * CSS to the search bar when the page loads.
 * 
 * @author Joseph T. Anderson
 * @since 2012-02-01
 * @version 2010-02-01
 * 
 */
SearchObj.setSearchBarCSS = function(){
	$('input#ticket_search').focus( function(){
		if ( $(this).hasClass('default-search-text') ){
			$(this).val('');
		}
		$(this).removeClass('default-search-text');
	}).blur( function(){
		if ( $(this).val() == '' ){
			$(this).val('Ticket ID');
			$(this).addClass('default-search-text');
		}
	});
}


/**
 * Funciton: SearchObj.submitSearch
 * 
 * This function sends the Ticket ID search criteria
 * to the server which, in turn, queries the Kayako
 * Fusion system for the ticket details.
 * 
 * @author Joseph T. Anderson
 * @since 2012-02-01
 * @version 2012-02-01
 */
SearchObj.submitSearch = function(){
	var postData = {};
}
