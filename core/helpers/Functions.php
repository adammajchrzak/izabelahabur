<?php 

/*
 * 
 * funkcje pomocnicze
 * 
 * @author Adam Majchrzak
 * 
 */

class Functions extends Engine_Model 	{
	
	static $_instance = false;
	public $month_list = array();
	
	
	public function __construct()	{
		parent::__construct();
	}
	
	public static function Instance()	{
		
		if (self::$_instance === false) {
			self::$_instance = new Functions();
		}
		return self::$_instance;
	}
	
	public function flattenArray($array, $index)	{
    	
    	foreach($array as $key=>$value )	{
    		if(is_array($index))	{
    			$elem = "";
    			foreach($index as $k=>$v)	{
    				$elem .= $value[$v]." "; 
    			}
    			$flattenArray[] = trim($elem);
    		}	else	{
    			$flattenArray[] = $value[$index];
    		} 
    	}
    	
    	return $flattenArray;
    }
	
	public function getPNArray($array, $index)	{
    	
		reset($array);
		$pn = array();
    	foreach($array as $key=>$value )	{
    		if($value == $index)	{
				if(array_key_exists(($key-1), $array))	{
					$pn['prev'] = $array[($key-1)];
				}	else	{
					$pn['prev'] = $value;
				}
				
				if(array_key_exists(($key+1), $array))	{
					$pn['next'] = $array[($key+1)];
				}	else	{
					$pn['next'] = $value;
				}
    		} 
    	}
    	
    	return $pn;
    }  
	
	public function getSiteLocaleList()	{
		
		$select = $this->_db->select()
									->from(array('l' => 'site_language'), array('*'))
									->order('_order');
		
		$this->_cSelect->setTags(array('core', 'getSiteLocale' , 'locales'));							
		$result = $this->_cSelect->fetchAll($select);

		return $result;
	}
    
    
    public function getConfiguration()	{
		
		$select = $this->_db->select()
									->from(array('c' => 'cms_configuration'), array('*'))
									->order('id');
		
		$this->_cSelect->setTags(array('core', 'getConfiguration' , 'const'));							
		$result = $this->_cSelect->fetchAll($select);

		return $result;
	}
}
?>