<?php
/*
 * This function will be used to convert the post variable naming convention to the
 * database naming convetion.  The post variable names are typically lower case, spaces
 * represented by hyphens.  The database Capitalizes each word and does not use spaces for
 * coumn names.
 * 
 * @author Joseph T. Anderson
 * @since 2011-11-30
 * @version 2011-11-30
 * 
 * @param PostArray The array of post variables to be transformed - should only be a one dimentonal array
 * 
 * @return InsertArray The array formatted to match database naming conventions
 */

 function transformPost($PostArray){
 	$InsertArray = array();
	foreach ( $PostArray as $key => $row ){
		if ( gettype($PostArray[$key]) != 'array' ){
			$newKey = preg_replace('/[-]/', ' ', $key);
			$newKey = ucwords($newKey);
			$newKey = preg_replace('/[ ]/', '', $newKey);
			$InsertArray[$newKey] = $PostArray[$key];
		}
	}
	return $InsertArray;
 }
