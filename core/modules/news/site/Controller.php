<?php 

/*
 * newsController
 * 
 * @author Adam Majchrzak
 * @jusee.pl
 */

 
class newsController extends Engine_Controller	{
	
	public function __construct($engine)	{
		
		parent::__construct($engine);
		
		$this->_cms 	= IndexModel::Instance();
		$this->_news 	= NewsModel::Instance();
		$this->_gallery	= GalleryModel::Instance();
		
		$this->_head->addStyleFile('reset.css', 'screen', true, '/css/');
        $this->_head->addStyleFile('bootstrap.min.css', 'screen', true, '/css/');
        $this->_head->addStyleFile('style.css', 'screen', true, '/css/');
		
		$this->_head->title 		= $this->_config->meta_data->title;
		$this->_head->keywords 		= $this->_config->meta_data->keywords;
		$this->_head->description	= $this->_config->meta_data->description;
		$this->_head->metascripts	= '';
	}
	
	public function index()	{
		
		$parent_page			  =	$this->_cms->getPageRoot('2', $this->_config->current_locale);
		$this->_view->parent_page =	$parent_page;
		$this->_view->breadcrumb  =	$this->_cms->getPageBreadcrumb('2', $this->_config->current_locale);
		$this->_view->submenu     = $this->_gallery->getGalleryCategoryList('pl', 1);
		
		if(is_numeric($this->_router->getItemSegments(2))){
			
			$news_details				= $this->_news->getNewsContent((int)$this->_router->getItemSegments(2));
			
			if($news_details['_redirect'] != '') {
				$this->_engine->addHttpHeader("Location: ".$news_details['_redirect']);
				exit();
			}

			if($news_details['_metatitle'] != '')		{	$this->_head->title 		=	$news_details['_metatitle'];	}
			if($news_details['_metakeywords'] != '')	{	$this->_head->keywords 		=	$news_details['_metakeywords'];	}
			if($news_details['_metadescription'] != '')	{	$this->_head->description 	=	$news_details['_metadescription'];	}
			if($news_details['_metascripts'] != '')		{	$this->_head->metascripts 	=	$news_details['_metascripts'];	}
			
			if($news_details['gallery_id'] != '0')	{
				//$news_details['gallery_details']	=	$this->_gallery->getGalleryDetails((int)$news_details['gallery_id']);
				//$news_details['picture_list'] 	=	$this->_gallery->getPictureForGalleryList((int)$news_details['gallery_id']);
			}
			
			$this->_view->news_details 	=	$news_details;
			
			$this->_view->news_list		=	$this->_news->getSidebarNewsList($this->_config->current_locale);
				
			$this->_engine->setToRender('view.tpl');
			
		}	else {
			
			$this->_view->paginationUrl = array($this->_config->current_locale, $this->_config->module);
			
			$this->_page    = (int)$this->_router->getItemSegments(1);
			
			$paginator = $this->_news->getNewsListPagination('0', $this->_page, $this->_config->current_locale);
			$this->_view->news_list 	= $paginator;
			$this->_view->pages 		= $paginator->getPages();
		
			$this->_engine->setToRender('index.tpl');
		}
	}
	
	public function category()	{
		
		$category_id = '1';
		
		if(is_numeric($this->_router->getItemSegments(2))){
			$category_id = (int)$this->_router->getItemSegments(2);
		}	
			
		$this->_view->paginationUrl = array($this->_config->module, 'category', $category_id);
			
		$this->_page    = (int)$this->_router->getItemSegments(3);
			
		$paginator = $this->_news->getNewsListPagination($category_id, $this->_page);
		$this->_view->news_list 	= $paginator;
		$this->_view->pages 		= $paginator->getPages();
		$this->_engine->setToRender('index.tpl');
	}
}
?>