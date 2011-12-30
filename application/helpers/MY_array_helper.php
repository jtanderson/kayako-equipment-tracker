<?php
/**
 * This helper extends the CodeIgniter Array Helper
 * 
 * @author Joseph T. Anderson <jtanderson@ratiocaeli.com>
 * @since 2011-12-29
 * @version 2011-12-29
 */

 function associate_by($field, Array $array){
     foreach ( $array as $key => $row ){
         if ( is_array($row) && isset($row[$field]) && ! isset($array[$row[$field]]) ){
             $array[$row[$field]] = $row;
             unset($array[$key]);
         }
     }
     return $array;
 }
