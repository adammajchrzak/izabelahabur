<?php 
class FormsModel extends Engine_Model {
	
	static 	$_instance = null;
	
	public function __construct()	{
		parent::__construct();
	}
	
	public function Instance()	{
		
		if(!isset(FormsModel::$_instance))	{
			FormsModel::$_instance = new FormsModel();
		}
		
		return FormsModel::$_instance;
	}
	
	public function saveNewsletterData($data) {
		
		$insert = array(
			'_email'	=>	$data['_email'],
			'_ip'		=>	$_SERVER['REMOTE_ADDR'],
			'_created'	=>	date('Y-m-d H:i:s')
		);
		
		$this->_db->insert('cms_newsletter', $insert);
		
		return true;
	}
	
	public function saveFormData($data) {
		
		$insert = array(
			'_email'	=>	$data['_email'],
			'_name'		=>	$data['_name'],
			'_phone'	=>	$data['_phone'],
			'_message'	=>	$data['_message'],
			'_ip'		=>	$_SERVER['REMOTE_ADDR'],
			'_created'	=>	date('Y-m-d H:i:s')
		);
		
		$this->_db->insert('cms_forms_data', $insert);
		
		return true;
	}
	
	public function getFormsDataList($_lang)	{
			
		$select = $this->_db->select()
									->from(array('cfd' => 'cms_forms_data'))
									->where('cfd._lang = ?', $_lang)
									->order('cfd._created DESC');
									
		$result = $this->_db->fetchAll($select);
		
		return $result;
	}
	
	public function deleteFormsData($data)	{
		
		$this->_db->delete("cms_forms_data", "item_id = '".(int)$data['item_id']."'");

		return true;
	}
}
?>