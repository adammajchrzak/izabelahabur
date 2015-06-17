<?php

/*
 * Engine Db
 * 
 * @author Adam Majchrzak
 * @author jusee.pl
 */

class Engine_Db	{
	
	private static $_instance = false;
	private $_select;
	private $_cache;
	private $_config;
	private $_timeout = 0;
	private $_tags = array();
	private $_cacheTurnOff = false;
	
	public static function instance()	{
		if(self::$_instance == false)	{
			self::$_instance = new Engine_Db();
		}
		
		return self::$_instance;
	}
	
	private function __construct()	{
		
		$session = new Zend_Session_Namespace('cacheTurnOff');
		if($session->turnOff == true)	{
			$this->_cacheTurnOff = true;
		}
		
		$this->_cache 	= Zend_Registry::get('cache');
		$this->_config 	= Zend_Registry::get('config');
		$this->restoreTimeout();
	}
	
	public function setTags($tags)	{
		$this->_tags = $tags;
	}
	
	public function getTags()	{
		return $this->_tags;
	}
	
	public function setTimeout($timeout)	{
		if($this->_config->mode != 'staging')	{
			$this->_timeout = $timeout; 
		}
	}
	
	public function getTimeout()	{
		return $this->_timeout;
	}
	
	public function restoreTimeout()	{
		
		if($this->_config->mode == 'staging')	{
			
			$this->_timeout = 0;
			
		}	else	{
			
			if($this->_config->cache->timeout == null)	{
				$this->_timeout = null;
			}	else	{
				$this->_timeout = (int)$this->_config->cache->timeout;
			}
		}
	}
	
	public function fetchAll($select)	{
		$this->_select = $select;
		if($this->_select instanceof Zend_Db_Select)	{
			return $this->_cache(__FUNCTION__);
		}
	}
	
	public function fetch($select)	{
		$this->_select = $select;
		if($this->_select instanceof Zend_Db_Select)	{
			return $this->_cache(__FUNCTION__);
		}
	}
	
	public function clearAll()	{
		$this->_clear(Zend_Cache::CLEANING_MODE_ALL);
	}
	
	public function clearMatchingAll($tags = array())	{
		$this->_clear(Zend_Cache::CLEANING_MODE_MATCHING_TAG, $tags);
	}
	
	public function clearMatchingAny($tags = array())	{
		$this->_clear(Zend_Cache::CLEANING_MODE_MATCHING_ANY_TAG, $tags);
	}
	
	public function clearMatchingNot($tags = array())	{
		$this->_clear(Zend_Cache::CLEANING_MODE_NOT_MATCHING_TAG, $tags);
	}
	
	private function _clear($type = '', $tags = array())	{
		$this->_cache->clean($type, $tags);
	}
	
	private function _cache($cacheType)	{
		
		if($this->_timeout === 0)	{
			return $this->_select->query()->$cacheType();
		}
		
		$cacheName = $cacheType .'_'.md5($this->_select->assemble());
		
		if($this->_cacheTurnOff || (($result = $this->_cache->load($cacheName)) === false))	{
			$result = $this->_select->query()->$cacheType();
			$this->_cache->save($result, $cacheName, $this->_tags, $this->_timeout);
		}
		
		return $result;
	}
}

?>