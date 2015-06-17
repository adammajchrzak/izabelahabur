<?php 

abstract class Engine_Model	{
	
	protected $_db = null;
	protected $_config;
	
	protected $_userSession;
	
	protected $_cSelect;
	protected $_dbPrefix = '';
	
	public function __construct()	{
		
		$this->_db		= Zend_Registry::get('db');
		$this->_config	= Zend_Registry::get('config');
		
		$this->_cSelect	= Engine_Db::instance();
		$this->_cSelect->setTags(array());
	}
	
	public function getSiteLocaleList()	{
		
		$select = $this->_db->select()
									->from(array('l' => 'site_language'), array('*'))
									->order('_order');
		
		$this->_cSelect->setTags(array('core', 'getSiteLocale' , 'locales'));							
		$result = $this->_cSelect->fetchAll($select);

		return $result;
	}
}
?>