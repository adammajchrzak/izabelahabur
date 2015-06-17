<?php 

/*
 * searchController
 * 
 * @author Adam Majchrzak
 * @jusee.pl
 */

 
class searchController extends Engine_Controller	{
	
	public function __construct($engine)	{
		
		parent::__construct($engine);
		
		$this->_cms 	= IndexModel::Instance();
		$this->_search 	= SearchModel::Instance();
		
		
		$this->_head->addStyleFile('jquery.ui.all.css', 'screen', true, '/css/jquery-ui/'); 	// JqueryUI CSS
		$this->_head->addStyleFile('style.main.css', 'screen', true, '/css/');
		$this->_head->addStyleFile('news.css', 'screen', true, '/css/');
		$this->_head->addStyleFile('colorbox.css', 'screen', true, '/css/');
		
		$this->_head->addScriptFile('base.js', true, '/scripts/'); 
		$this->_head->addScriptFile('jquery.colorbox.js', true, '/scripts/');
		
		$this->_head->title 		= $this->_config->meta_data->title;
		$this->_head->keywords 		= $this->_config->meta_data->keywords;
		$this->_head->description	= $this->_config->meta_data->description;
		
		$this->_view->sentence 		= $this->_cms->getSentenceForDay();
		$this->_view->bulletin		= $this->_cms->getPageContent('84'); 
	}
	
	public function index()	{

		
		$this->_page    = (int)$this->_router->getItemSegments(2);
		$word = '';
		if(!empty($_REQUEST['sw']))	{
			$word 			= $_REQUEST['sw'];
		}	elseif($this->_router->getItemSegments(1))	{
			$word 			= $this->_router->getItemSegments(1);
		}
		
		$this->_view->paginationUrl = array($this->_config->module, $word);
		
		$paginator 					= $this->_search->getSearchListPagination($word, $this->_page);
		
		foreach($paginator as $key=>$value)	{
			
			$module = 'index';
			
			if($value['type_id'] == '1')
				$module = 'index';
			elseif($value['type_id'] == '2')
				$module = 'news';
			elseif($value['type_id'] == '3')
				$module = 'calendar';
			
			$value['module'] = $module;
			$search_list[$key] = $value;  
		}
		
		$this->_view->search_list 	= @$search_list;
		$this->_view->pages 		= $paginator->getPages();
		$this->_view->word			= $word;
	
		$this->_engine->setToRender('index.tpl');
	}
}
?>