<?php 

class AttachmentModel extends Engine_Model {
	
	static 	$_instance = null;
	private $_locales;
	
	public function __construct()	{
		parent::__construct();
		
		$this->_locales = $this->getSiteLocaleList();
	}
	
	public function Instance()	{
		
		if(!isset(AttachmentModel::$_instance))	{
			AttachmentModel::$_instance = new AttachmentModel();
		}
		
		return AttachmentModel::$_instance;
	}
	
	public function getLocalesList($search = array())	{
		
		$select = $this->_db->select()
									->from(array('cp' => 'cms_price'))
									->joinLeft(
										array('cpc' => 'cms_price_category'),
										'cp._floor = cpc.item_id',
										array('_name' => '_name')
									)
									->order('_index');
		if((int)$search['floorId'] != '0') {
			$select->where('_floor = ?', $search['floorId']);
		}
		if((int)$search['roomId'] != '0') {
			$select->where('_room = ?', $search['roomId']);
		}
		if((int)$search['areaId'] != '0') {
			$select->where('_area <= ?', $search['areaId']);
		}
		$result = $this->_db->fetchAll($select);
		
		return $result;
	}
	
	public function getLocalDetails($item_id)	{
		
		$select = $this->_db->select()
									->from(array('cp' => 'cms_price'))
									->where('item_id = ?', $item_id);
									
		$result = $this->_db->fetchRow($select);
		
		return $result;
	}
	
	public function getLocalDetailsByIndex($item_id)	{
		
		$select = $this->_db->select()
									->from(array('cp' => 'cms_price'))
									->where('_index = ?', $item_id);
									
		$result = $this->_db->fetchRow($select);
		
		return $result;
	}
	
	public function getLocalRooms($item_id)	{
		
		$select = $this->_db->select()
									->from(array('cr' => 'cms_price_room'))
									->where('_parent = ?', $item_id)
									->order('item_id');
									
		$result = $this->_db->fetchAll($select);
		
		return $result;
	}
	
	public function getLocalesCategoryList()	{
		
		$select = $this->_db->select()
									->from(array('cpc' => 'cms_price_category'))
									->order('item_id');
		
		$result = $this->_db->fetchAll($select);

		return $result;
	}

	public function getCategoryDetails($item_id) {
		
		$select = $this->_db->select()
									->from(array('cpc' => 'cms_price_category'))
									->where('item_id = ?', (int)$item_id);
		$result = $this->_db->fetchRow($select);
		return $result;
	}
	
	
	public function activeLocal($data) {
		
		$item = $this->getLocalDetails($data['item_id']);
		
		$item['_available'] == '1' ? $active = '0' : $active = '1'; 
		
		$update = array(
				"_available"	=>	$active
		);
		
		$this->_db->update("cms_price", $update, "item_id = '".(int)$data['item_id']."'");
		return true;
	}
	
	public function addLocaleDetails($data)	{
		
		$insert = array(
				"_local"			=>	$data['_local'],
				"_floor"			=>	$data['_floor'],
				"_room"				=>	$data['_room'],
				"_area"				=>	$data['_area'],
				"_credit"			=>	$data['_credit'],
				"_balcony"			=>	$data['_balcony'],
				"_entresol"			=>	@(int)$data['_entresol'],
				"_terrace"			=>	@(int)$data['_terrace'],
				"_garden"			=>	@(int)$data['_garden'],
				"_available"		=>	@(int)$data['_available'],
				"_file"				=>	$data['_file']
		);		
		$this->_db->insert("cms_price", $insert);

		return true;
	}
	
	public function saveLocaleDetails($data)	{
		
		$update = array(
				"_local"			=>	$data['_local'],
				"_floor"			=>	$data['_floor'],
				"_room"				=>	$data['_room'],
				"_area"				=>	$data['_area'],
				"_credit"			=>	$data['_credit'],
				"_balcony"			=>	$data['_balcony'],
				"_entresol"			=>	@(int)$data['_entresol'],
				"_terrace"			=>	@(int)$data['_terrace'],
				"_garden"			=>	@(int)$data['_garden'],
				"_available"		=>	@(int)$data['_available'],
				"_file"				=>	$data['_file']
		);
		
		$this->_db->update("cms_price", $update, "item_id='".(int)$data['item_id']."'");
		
		return true;
	}
	
	public function deleteLocal($data)	{
		
		$this->_db->delete("cms_price", "item_id = '".(int)$data['item_id']."'");

		return true;
	}
	
	public function activeCategory($data) {
		
		$category = $this->getCategoryDetails($data['item_id']);
		
		$category['_active'] == '1' ? $active = '0' : $active = '1'; 
		
		$update = array(
				"_active"	=>	$active
		);
		
		$this->_db->update("cms_price_category", $update, "item_id = '".(int)$data['item_id']."'");
		return true;
	}
	
	public function addCategory($data) {
		
		$insert = array(
				"_name"				=>	$data['_name'],
				"_description"		=>	$data['_description'],
				"_active"			=>	@(int)$data['_active'],
				"_file"				=>	$data['_file']
		);
		
		$this->_db->insert("cms_price_category", $insert);
		
		return true;
	}
	
	public function saveCategory($data) {
		
		$update = array(
				"_name"				=>	$data['_name'],
				"_description"		=>	$data['_description'],
				"_active"			=>	@(int)$data['_active'],
				"_file"				=>	$data['_file']
		);
		
		$this->_db->update("cms_price_category", $update, "item_id='".(int)$data['item_id']."'");
		
		return true;
	}
}
?>