<?php 
/*	smarty w wersji 2.6.x 	*/				
require_once "../library/Smarty/Smarty.class.php";

/*
 * Engine Smarty
 * 
 * @author Adam Majchrzak
 * @author jusee.pl
 * 
 */

class Engine_Smarty extends Smarty	{
	
	public function __construct()	{
		parent::__construct();
	}
	
	private function _getTemplateFileName($template)	{
		
		$pathinfo = pathinfo($template);
		if(is_file($pathinfo['dirname']."/".$pathinfo['basename']))	{
			$template = $pathinfo['dirname']."/".$pathinfo['basename'];
		}
		
		return $template;
	}
	
	public function fetch($template, $cache_id = null, $compile_id = null, $display = false)	{
		return parent::fetch($this->_getTemplateFileName($template), $cache_id, $compile_id, $display);
	}
}
?>