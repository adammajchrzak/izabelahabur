<?php 
class SearchModel extends Engine_Model {
	
	static 	$_instance = null;
	private	$_pages_tree = array();
	
	public function __construct()	{
		parent::__construct();
	}
	
	public function Instance()	{
		
		if(!isset(SearchModel::$_instance))	{
			SearchModel::$_instance = new SearchModel();
		}
		
		return SearchModel::$_instance;
	}
	
	public function getSearchListPagination($word = '1', $page = '0')	{
		
		$select = $this->_db->select()
									->from(array('cc' => 'cms_content'))
									->where("cc.content_title LIKE '%".mysql_escape_string($word)."%' OR cc.content_text LIKE '%".mysql_escape_string($word)."%'")	
									->where('cc.content_active = ?', '1')	
									->order('cc.content_id DESC');
		
		$result = Zend_Paginator::factory($select)
        	->setCurrentPageNumber($page)
        	->setItemCountPerPage($this->_config->pagination->itemsPerPage)
        	->setPageRange($this->_config->pagination->pagesInRange);
        Zend_Paginator::setDefaultScrollingStyle('Sliding');
		
		return $result;
	}
}
?>