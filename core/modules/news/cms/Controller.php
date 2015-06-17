<?php

/*
 * newsController
 * 
 * @author Adam Majchrzak
 * @jusee.pl
 */

 class newsController extends Engine_Controller	{
	
	public $_news;
	public $_gallery;
	public $_locale_codes;
	
	public function __construct($engine)	{
		
		parent::__construct($engine);
		
		if(!$this->_auth->hasIdentity())	{
			$this->_engine->addHttpHeader("Location: ".$this->_router->getUrl('cms', 'auth'));
			exit();
		}
		
		$this->_news	= NewsModel::Instance();
		$this->_gallery	= GalleryModel::Instance();
		
		if($this->_config->multi_locale == '1')	{
			$this->_view->locale_list	=	$this->_function->getSiteLocaleList();
			$this->_locale_codes		=	$this->_function->flattenArray($this->_function->getSiteLocaleList(),'lang_code');
			if(!$this->_session->lang_code) {
				$this->_session->lang_code	=	$this->_locale_codes[0];
			}
		}	else {
			$this->_view->locale_list	=	$this->_function->getSiteLocaleList();
			$this->_locale_codes		=	$this->_function->flattenArray($this->_function->getSiteLocaleList(),'lang_code');
			if(!$this->_session->lang_code) {
				$this->_session->lang_code	=	$this->_locale_codes[0];
			}
		}
		
		$this->_view->sidebar =  $this->_view->render('modules/'.$this->_engine->getModuleName().'/cms/templates/sidebar.tpl');												 
	}
	
	public function index()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'view'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}

		if(in_array($this->_router->getItemSegments(2), $this->_locale_codes)) {
			$this->_session->lang_code = $this->_router->getItemSegments(2);
		}

		$this->_view->news_list = $this->_news->getNewsList($this->_session->lang_code);

		print $this->_view->render('modules/news/cms/templates/list.tpl');
		exit();
	}
	
	public function active() {
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			$this->_news->activeNews($_POST);
		}
		
		exit();
	}

	public function add()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'add'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}

		$news_details['news_id']	=	'0';
		$news_details['lang_code']	=	$this->_session->lang_code;
		$this->_view->category_list	=	$this->_news->getNewsCategoryList($this->_session->lang_code);
		$this->_view->news_details	=	$news_details;
		$this->_view->gallery_list	=	$this->_gallery->getGalleryList($this->_session->lang_code);
		
		print $this->_view->render('modules/news/cms/templates/add.tpl');
		exit;
	}

	public function edit()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			
			if($_POST['news_id'] == '0' || $_POST['news_id'] == '')	{
				$this->_news->addNewsDetails($_POST);
				
			}	else {
				$this->_news->saveNewsDetails($_POST);	
			}
			
			$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms#', 'cms', 'news', $this->_session->lang_code));
			exit();
		}

		$news_details = $this->_news->getNewsDetails((int)$this->_router->getItemSegments(3));
		$this->_view->category_list	= $this->_news->getNewsCategoryList($news_details['lang_code']);
		$this->_view->news_details 	= $news_details;
		$this->_view->gallery_list 	= $this->_gallery->getGalleryList($news_details['lang_code']);
		
		print $this->_view->render('modules/news/cms/templates/edit.tpl');
		exit();
	}
	
	public function delete()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'delete'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isAjaxRequest())	{
			$this->_news->deleteNews($_REQUEST);
		}
		
		exit();
	}
	
	/*	category */
	
	public function category()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'view'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}

		if(in_array($this->_router->getItemSegments(3), $this->_locale_codes)) {
			$this->_session->lang_code = $this->_router->getItemSegments(3);
		}

		$this->_view->category_list = $this->_news->getNewsCategoryList($this->_session->lang_code);

		print $this->_view->render('modules/news/cms/templates/category.list.tpl');
		exit();
	}
	
	public function cactive() {
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			$this->_news->activeNewsCategory($_POST);
		}
		
		exit();
	}
	
	
	public function cadd()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'add'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		$category_details['category_id']	=	'0';
		$category_details['lang_code']		=	$this->_session->lang_code;
		$this->_view->category_details			=	$category_details;
		
		print $this->_view->render('modules/news/cms/templates/category.add.tpl');
		exit();
	}
	
	public function cedit()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			
			if($_POST['category_id'] == '0' || $_POST['category_id'] == '')	{
				$this->_news->addNewsCategory($_POST);
				
			}	else {
				$this->_news->saveNewsCategory($_POST);	
			}
			
			$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms#', 'cms', 'news', 'category', $this->_session->lang_code));
			exit();
		}

		$category_details = $this->_news->getCategoryDetails((int)$this->_router->getItemSegments(3));
		$this->_view->category_details 	= $category_details;
		
		print $this->_view->render('modules/news/cms/templates/category.edit.tpl');
		exit();
	}
	
	public function cdelete()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'delete'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isAjaxRequest())	{
			$this->_news->deleteNewsCategory($_REQUEST);
		}
		
		exit();
	}
}
?>