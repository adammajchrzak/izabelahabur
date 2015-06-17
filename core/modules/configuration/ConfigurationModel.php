<?php 

/**
 * ConfigurationModel.php
 * 
 * @author Adam Majchrzak
 */

class ConfigurationModel extends Engine_Model {
	
	static $_instance = null;
	
	public function __construct()	{
		parent::__construct();
	}
	
	public static function Instance()	{
		
		if(!isset(ConfigurationModel::$_instance))	{
			ConfigurationModel::$_instance = new ConfigurationModel();
		}
		
		return ConfigurationModel::$_instance;
	}
	
	public function getConfigurationList()	{
		
		$select = $this->_db->select()
									->from(array('cc' => 'cms_configuration'))
									->order('id');
		
		$result = $this->_db->fetchAll($select);
		
		return $result;
	}
	
	public function getConfigurationDetails($id)	{
		
		$select	= $this->_db->select()
									->from(array('cc' => 'cms_configuration'))
									->where('cc.id = ?', (int)$id);
		$result = $this->_db->fetchRow($select);
		
		return $result;				
	}
	
	public function addConfigurationItem($data)	{
		
		$insert	=	array(
			'_key'          =>	$data['_key'],
			'_name'         =>	$data['_name'],
            '_value'        =>	$data['_value'],
			'_description'	=>	$data['_description'],
			'_created'		=>	date('Y-m-d H:i:s'),
			'_changed'		=>	date('Y-m-d H:i:s')
		);
		
		$this->_db->insert('cms_configuration', $insert);
		return true;
	}
	
	public function saveConfigurationItem($data)	{
		
		$update	=	array(
			'_key'          =>	$data['_key'],
			'_name'         =>	$data['_name'],
            '_value'        =>	$data['_value'],
			'_description'	=>	$data['_description'],
			'_changed'		=>	date('Y-m-d H:i:s')
		);
		
		$this->_db->update("cms_configuration", $update, "id = '".(int)$data['id']."'");
		
		return true;
	}
	
	public function deleteConfiguration($data) {
		
		$this->_db->delete("cms_configuration", "id = '".(int)$data['id']."'");
		
		return true;
	}
	
}
?>