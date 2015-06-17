<?php 
class NewsModel extends Engine_Model {
	
	static 	$_instance = null;
	
	public function __construct()	{
		parent::__construct();
	}
	
	public function Instance()	{
		
		if(!isset(NewsModel::$_instance))	{
			NewsModel::$_instance = new NewsModel();
		}
		
		return NewsModel::$_instance;
	}
	
	public function getNewsListPagination($category_id = '0', $page = '0', $lang_code)	{
		
		$select = $this->_db->select()
									->from(array('cn' => 'cms_news'))
									->where('cn._active = ?', '1')
									->where('cn.lang_code = ?', $lang_code)	
									->order('_publish DESC')
									->order('news_id DESC');
		if($category_id != '0') {
			$select->where('category_id = ?', (int)$category_id);
		}
		
		$result = Zend_Paginator::factory($select)
        	->setCurrentPageNumber($page)
        	->setItemCountPerPage($this->_config->pagination->itemsPerPage)
        	->setPageRange($this->_config->pagination->pagesInRange);
        Zend_Paginator::setDefaultScrollingStyle('Sliding');
		
		return $result;
	}
	
	public function getHomePageNewsList($lang_code)	{
		
		$select = $this->_db->select()
									->from(array('cn' => 'cms_news'))
									->where('cn.lang_code = ?', $lang_code)
									->order('_publish DESC')
									->order('news_id DESC')
									->limit('2');
		
		$result = $this->_db->fetchAll($select);
		return $result;
	}
	
	public function getSidebarNewsList($lang_code)	{
		
		$select = $this->_db->select()
									->from(array('cn' => 'cms_news'))
									->where('cn.lang_code = ?', $lang_code)
									->order('_publish DESC')
									->order('news_id DESC')
									->limit('3');
		
		$result = $this->_db->fetchAll($select);
		return $result;
	}
	
	public function getNewsList($lang_code, $_active = '')	{
		
		$select = $this->_db->select()
									->from(array('cn' => 'cms_news'))
									->joinLeft(
										array('cnc' => 'cms_news_category'),
										'cn.category_id = cnc.category_id',
										array('_category' => '_name')
									)
									->where('cn.lang_code = ?', $lang_code)
									->order('_publish DESC')
									->order('news_id DESC');
		
		if($_active == '1') {
			$select->where('cn._active = ?', (int)$_active);
		}
		
		$result = $this->_db->fetchAll($select);
		
		return $result;
	}
	
	public function getNewsContent($news_id)	{
		
		$select = $this->_db->select()
									->from(array('cn' => 'cms_news'))
									->where('news_id = ?', (int)$news_id);
		
		$result = $this->_db->fetchRow($select);
		
		return $result;
	}
	
	public function getNewsDetails($news_id)	{
		
		$select = $this->_db->select()
									->from(array('cn' => 'cms_news'))
									->where('news_id = ?', (int)$news_id);
		
		$result = $this->_db->fetchRow($select);
		
		return $result;
	}
	
	public function getNewsCategoryList($lang_code = '', $_active = '')	{
		
		$select = $this->_db->select()
									->from(array('cnc' => 'cms_news_category'))
									->order('category_id');
		if($lang_code != '') {
			$select->where('cnc.lang_code = ?', $lang_code);
		}

		if($_active == '1') {
			$select->where('cnc._active = ?', (int)$_active);
		}
		
		$result = $this->_db->fetchAll($select);
		
		return $result;
	}
	
	public function getCategoryDetails($category_id) {
		
		$select = $this->_db->select()
									->from(array('cnc' => 'cms_news_category'))
									->where('category_id = ?', (int)$category_id);
		$result = $this->_db->fetchRow($select);
		return $result;
	}
	
	/*

	 iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
	 preg_replace('/[^a-zA-Z0-9 -]/', '', $url);
	 trim(substr(strtolower($url), 0, $maxLength));
	 preg_replace('/[s' . $separator . ']+/', $separator, $url); 
	 
	 */
	public static function ToSlug($string, $maxLength=255, $separator='_') {
		
		$url = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
		$url = preg_replace('/[^a-zA-Z0-9 -]/', '', $url);
		$url = trim(substr(strtolower($url), 0, $maxLength));
		//$url = preg_replace('/[' . $separator . ']+/', $separator, $url);
		$url = preg_replace('/\s+/', $separator, $url);
		return $url;
	}
	
	/*	CMS FUNCTION	*/
	
	public function activeNews($data) {
		
		$news = $this->getNewsDetails($data['news_id']);
		
		$news['_active'] == '1' ? $active = '0' : $active = '1'; 
		
		$update = array(
				"_active"	=>	$active,
				"_changed"	=>	date("Y-m-d H:i:s")
		);
		
		$this->_db->update("cms_news", $update, "news_id = '".(int)$data['news_id']."'");
		return true;
	}
	
	public function addNewsDetails($data)	{
		
		$insert = array(
				"category_id"		=>	$data['category_id'],
				"lang_code"			=>	$data['lang_code'],
				"_title"			=>	$data['_title'],
				"_code"				=>	$this->ToSlug($data['_title']),
				"_lead"				=>	$data['_lead'],
				"_content"			=>	$data['_content'],
				"_picture"			=>	$data['_picture'],
				"_gallery"			=>	$data['_gallery'],
				"_redirect"			=>	$data['_redirect'],
				"_active"			=>	@(int)$data['_active'],
				"_publish"			=>	$data['_publish'],
				"_metatitle"		=>	$data['_metatitle'],
				"_metakeywords"		=>	$data['_metakeywords'],
				"_metadescription"	=>	$data['_metadescription'],
				"_metascripts"		=>	$data['_metascripts'],
				"_created"			=>	date("Y-m-d H:i:s"),
				"_changed"			=>	date("Y-m-d H:i:s")
		);		
		$this->_db->insert("cms_news", $insert);

		return true;
	}
	
	public function saveNewsDetails($data)	{
		
		$update = array(
				"category_id"		=>	$data['category_id'],
				"lang_code"			=>	$data['lang_code'],
				"_title"			=>	$data['_title'],
				"_code"				=>	$this->ToSlug($data['_title']),
				"_lead"				=>	$data['_lead'],
				"_content"			=>	$data['_content'],
				"_picture"			=>	$data['_picture'],
				"_gallery"			=>	$data['_gallery'],
				"_redirect"			=>	$data['_redirect'],
				"_active"			=>	@(int)$data['_active'],
				"_publish"			=>	$data['_publish'],
				"_metatitle"		=>	$data['_metatitle'],
				"_metakeywords"		=>	$data['_metakeywords'],
				"_metadescription"	=>	$data['_metadescription'],
				"_metascripts"		=>	$data['_metascripts'],
				"_changed"			=>	date("Y-m-d H:i:s")
		);
		$this->_db->update("cms_news", $update, "news_id='".(int)$data['news_id']."'");
		
		return true;
	}
	
	public function deleteNews($data)	{
		
		$this->_db->delete("cms_news", "news_id = '".(int)$data['news_id']."'");

		return true;
	}
	
	public function activeNewsCategory($data) {
		
		$category = $this->getCategoryDetails($data['category_id']);
		
		$category['_active'] == '1' ? $active = '0' : $active = '1'; 
		
		$update = array(
				"_active"	=>	$active,
				"_changed"	=>	date("Y-m-d H:i:s")
		);
		
		$this->_db->update("cms_news_category", $update, "category_id = '".(int)$data['category_id']."'");
		return true;
	}
	
	public function addNewsCategory($data) {
		
		$insert = array(
				"lang_code"			=>	$data['lang_code'],
				"_name"				=>	$data['_name'],
				"_code"				=>	$this->ToSlug($data['_name']),
				"_description"		=>	$data['_description'],
				"_active"			=>	@(int)$data['_active'],
				"_created"			=>	date("Y-m-d H:i:s"),
		);
		
		$this->_db->insert("cms_news_category", $insert);
		
		return true;
	}
	
	public function saveNewsCategory($data) {
		
		$update = array(
				"lang_code"			=>	$data['lang_code'],
				"_name"				=>	$data['_name'],
				"_code"				=>	$this->ToSlug($data['_name']),
				"_description"		=>	$data['_description'],
				"_active"			=>	@(int)$data['_active'],
				"_changed"			=>	date("Y-m-d H:i:s")
		);
		
		$this->_db->update("cms_news_category", $update, "category_id='".(int)$data['category_id']."'");
		
		return true;
	}
	
	public function deleteNewsCategory($data)	{
		
		$this->_db->delete("cms_news_category", "category_id = '".(int)$data['category_id']."'");

		return true;
	}
}
?>