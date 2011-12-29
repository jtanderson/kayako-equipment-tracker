<?php 

/**
 * File: MY_string_helper.php
 * 
 * This file extends the CodeIgniter string helper.  As per
 * the CodeIgniter system, any function in the file whose name
 * collides with one of the string helper will override that funciton.
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
 * @since 2011-12-20
 */

/**
 * This function will remove all CDATA encapsulation from a given string.
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocalei.com
 * @since 2011-12-20
 * @version 2011-12-20
 * 
 * @param String $string The string to be cleansed of CDATA tags
 * 
 * @return String The string without CDATA tags.
 */
function strip_cdata($string) 
{ 
    preg_match_all('/<!\[cdata\[(.*?)\]\]>/is', $string, $matches); 
    return str_replace($matches[0], $matches[1], $string); 
} 
