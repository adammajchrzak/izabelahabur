<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.import_css.php
 * Type:     function
 * Name:     import_css
 * Purpose:  zwraca zawartość pliku css dla modułu
 * Author: 	Adam Majchrzak jusee.pl
 * -------------------------------------------------------------
 */

function smarty_function_import_css($params){
	
	$dir = dirname(__FILE__)."/../../../core/modules/";
	if (is_array($params)) {
		if(is_file($dir.$params['module']."/".$params['mode']."/css/".$params['file'])){
			$css = file_get_contents($dir.$params['module']."/".$params['mode']."/css/".$params['file']);
			$style_block = '<style type="text/css">'.$css.'</style>';
			
			$order   = array("\r\n", "\n", "\r", "\t");
			$replace = "";
			$style_block = str_replace($order, $replace, $style_block);
			
			print $style_block;	
		}
	}	else {
		return 0;
	}
}

?>