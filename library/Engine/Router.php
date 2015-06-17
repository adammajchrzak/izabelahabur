<?php 

/*
 * Engine Router
 * 
 * @author Adam Majchrzak
 * @author jusee.pl
 */


class Engine_Router	{
	
	private $_db;
	private $_config;
	private $segments = array();
	private $firstSegmentIndex = 0;
	public	$accepted_locale;
	
	public function __construct()	{
		
		$this->config	=	Zend_Registry::get('config');
		$this->_db 		=   Zend_Registry::get('db');
		$this -> _parseUrlString();
	}
	
	private function _getUrlString()	{
		
		return isset($_SERVER['HTTP_X_ORIGINAL_URL']) ?  $_SERVER['HTTP_X_ORIGINAL_URL'] :  $_SERVER['REQUEST_URI'] ;
	}
	
	private function _parseUrlString()	{
		
		list($path) = explode('?', $this->_getUrlString());
		
		/*	parsowanie adresu	*/
		if(($url = $this->config->baseUrl ? substr($path, strlen($this->config->baseUrl)) : $path ))	{
			
			if($this -> config -> suffix)	{
				$clear = array($this -> config -> suffix => '');
				$url = strtr($url, $clear);
			}
			
			if($url{0} == '/')	{
				$url = substr($url, 1);
			}
			
			$tmp = explode($this -> config -> delimiter ,$url);
			
			foreach($tmp as $value)	{
				if(preg_match('/^[a-z_0-9\-]{0,256}$/i', $value)){
					$this->segments[] = $value;
				}	else	{
					continue;
				}
			}
			
			if( isset($this->segments[0]) && preg_match('/^[a-z]{2}_[a-z]{2}$/i', $this->segments[0] ) ){
				$this -> langCode =  strtolower($this->segments[0]);
				$this -> firstSegmentIndex = 1;
			}
		}
	}
	
	public function getUrl()	{
	
		$url = '';
		
		if(func_num_args())	{
			foreach(func_get_args() as $value)	{
				if(is_array($value))	{
					
					/*	sprawdzenie poprawnosci podanego parametru - nazwy modulu jako stringa	*/

					//$url .= implode($this->config->delimiter, is_string($value)) . $this->config->delimiter;
					$url .= implode($this->config->delimiter, $value) . $this->config->delimiter;
					// delimiter jako "," lub "-"
					
				}	else	{
					
					/*	sprawdzenie podanego parametru jako stringa	*/
					//$url .= is_string($value) . $this->config->delimiter;
					$url .= $value . $this->config->delimiter;
				}
			}
			
			$url = (substr($url, -strlen( $this -> config -> delimiter )) == $this -> config -> delimiter  ? substr($url, 0 ,-strlen( $this -> config -> delimiter )) : $url).$this-> config -> suffix ;
		
		}	else	{
			
			$url = $_SERVER['REQUEST_URI'];
		}
		
		return $url;
	}
	
	public function getItemCode($id = '', $lang_code = '') {
			
		$select = $this->_db->select()
							->from(array('site_node'), array('node_code'))
							->where('page_id = ?', $id)
							->where('lang_code = ?', $lang_code);
		$result = $this->_db->fetchRow($select);
		
		return $result['node_code'];
	}
	
	public function getFullUrl()	{
		
		return (func_num_args() == 0 ? $this->getBaseHref(true) : $this->getBaseHref()) . (func_num_args() == 0 ? $this->getUrl() :  $this->getUrl(func_get_args()));
	}
	
	public function getBaseHref($noSubdir = false,$protocol=null)	 {

		if($protocol)
	    	$protocol.='://';
	    else
			$protocol = $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
			
	    $dir = $this -> config -> baseUrl == '/' || $this -> config -> baseUrl == '' ? '/' : ( substr($this -> config -> baseUrl, -1) == '/' ? $this -> config -> baseUrl : $this -> config -> baseUrl . '/') ;
	    $host = substr($_SERVER['HTTP_HOST'], -1) == '/' ? substr($_SERVER['HTTP_HOST'], 0, -1) : $_SERVER['HTTP_HOST'];
        $address  = $host . ( $noSubdir ? '' : $dir);
	    
	    return $protocol . $address;
	}
	
	public function getItemSegments($index)	{
		
		if($this->config->multi_locale == '1') {
			if($index == '0' && $this->segments[$this->firstSegmentIndex + $index] != 'cms')	{
				if(!empty($this->segments[$this->firstSegmentIndex + $index]) && !in_array($this->segments[$this->firstSegmentIndex + $index], $this->accepted_locale)) {
					die('NIEPRAWIDŁOWA WARTOŚĆ WERSJI JĘZYKOWEJ!!!');
				}
				$this->config->current_locale = $this->segments[$this->firstSegmentIndex + $index];
				if(empty($this->segments[$this->firstSegmentIndex + $index]))	{
					$this->config->current_locale = $this->config->default_locale;
				}
				Zend_Registry::set('config', $this->config);
			}
			if($this->segments[$this->firstSegmentIndex] != 'cms'){ 
				$index++; 
			}
		}	else {
			$this->config->current_locale = $this->config->default_locale;
		}
		
		return isset($this->segments[$this->firstSegmentIndex + $index]) ? $this->segments[$this->firstSegmentIndex + $index] : '';
	}
	
	public function getSegments()	{
		
		return $this->segments;
	}
	
	public function getRequestMethod()	{

		return $_SERVER['REQUEST_METHOD'];
	}
	
	public function isPostRequest()	{
		
		return $this->getRequestMethod() == 'POST' ? true : false;
	}
	
	public function isAjaxRequest()	{
		
		return  isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ? true : false;
	}
	
	public function redirect($address)	{
		
		$url = strpos($address, 'http://') === false && strpos($address, 'https://') === false ? $this -> getUrl($address) : $address;
		header('Location:' . $url);
		exit;
	}

	public function getProtocol()	{
		
		return $_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http';	
	}
	
	public function getUrlVar()	{
		
		if(!func_num_args()) return '';
		
		$get = '';
		foreach(func_get_args() as $item)	{
			
			list($k, $v) = explode(":", $item);
			if($v)	{
				$get .= ($get ? '?&amp;' : '?').$k."=".urlencode($v);
			}
		}
		return $get; 
	}
	
	
}
?>