<?php 

/*
 * 
 * obsługa znacznika HEAD generowanego szablonu HTML
 * 
 * @author Adam Majchrzak
 * @author jusee.pl
 */

class HtmlHead	{
	
	private static $_instance = false;
	
	private $_styles 			= array();
	private $_styles_to_import 	= array();
	private $_scripts 			= array();
	
	public static function Instance()	{
		
		if (self::$_instance === false) {
			self::$_instance = new HtmlHead();
		}
		return self::$_instance;
	} 
	
	private function __construct()	{
		
	}
	
	public function addStyleFile($file = '', $media = 'screen', $append = true, $subPath = '')	{
		
		if($append)	{
			$this->_styles[] = array('file' => $file, 'media' => $media, 'path' => $subPath);
		}	else	{
			array_unshift($this->_styles, array('file' => $file, 'media' => $media, 'path' => $subPath));
		}
	}
	
	public function addStyleToImport($module = '', $mode = '', $file = '')	{		
		$this->_styles_to_import[] = array('module' => $module, 'mode' => $mode, 'file' => $file);

	}
	
	public function addScriptFile($file = '', $append = true, $subPath = '')	{
		
		if($append)	{
			$this->_scripts[] = array('file' => $file, 'path' => $subPath);
		}	else	{
			array_unshift($this->_scripts, array('file' => $file, 'path' => $subPath));
		}
	}

	public function getStyles()	{
		return $this->_styles;
	}
	
	public function getStylesToImport()	{
		return $this->_styles_to_import;
	}
	
	public function getScripts()	{
		return $this->_scripts;
	}
}
?>