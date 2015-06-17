<?php

/*
 * priceController
 * 
 * @author Adam Majchrzak
 * @jusee.pl
 */

 class priceController extends Engine_Controller	{
	
	public $_price;
	public $_locale_codes;
	
	public function __construct($engine)	{
		
		parent::__construct($engine);
		
		if(!$this->_auth->hasIdentity())	{
			$this->_engine->addHttpHeader("Location: ".$this->_router->getUrl('cms', 'auth'));
			exit();
		}
		
		$this->_price	= PriceModel::Instance();
		
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

		$this->_view->locales_list	=	$this->_price->getLocalesList($this->_session->search);

		print $this->_view->render('modules/'.$this->_engine->getModuleName().'/cms/templates/list.tpl');
		exit();
	}
	
	public function active() {
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			$this->_price->activeLocal($_POST);
		}
		
		exit();
	}

	public function add()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'add'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}

		$item['item_id']	=	'0';
		$this->_view->category_list	=	$this->_price->getLocalesCategoryList();
		$this->_view->item			=	$item;
		
		print $this->_view->render('modules/'.$this->_engine->getModuleName().'/cms/templates/add.tpl');
		exit;
	}

	public function edit()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			
			if($_POST['item_id'] == '0' || $_POST['item_id'] == '')	{
				$this->_price->addLocaleDetails($_POST);
				
			}	else {
				$this->_price->saveLocaleDetails($_POST);	
			}
			
			$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms#', 'cms', 'price', $this->_session->lang_code));
			exit();
		}

		$this->_view->item			=	$this->_price->getLocalDetails((int)$this->_router->getItemSegments(3));
		$this->_view->category_list	=	$this->_price->getLocalesCategoryList();
		
		print $this->_view->render('modules/'.$this->_engine->getModuleName().'/cms/templates/edit.tpl');
		exit();
	}
	
	public function delete()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'delete'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isAjaxRequest())	{
			$this->_price->deleteLocal($_REQUEST);
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

		$this->_view->floors_list = $this->_price->getLocalesCategoryList();

		print $this->_view->render('modules/'.$this->_engine->getModuleName().'/cms/templates/category.list.tpl');
		exit();
	}
	
	public function cactive() {
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			$this->_price->activeCategory($_POST);
		}
		
		exit();
	}
	
	
	public function cadd()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'add'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		$category_details['category_id']	=	'0';
		$category_details['lang_code']		=	$this->_session->lang_code;
		$this->_view->category_details		=	$category_details;
		
		print $this->_view->render('modules/'.$this->_engine->getModuleName().'/cms/templates/category.add.tpl');
		exit();
	}
	
	public function cedit()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			
			if($_POST['item_id'] == '0' || $_POST['item_id'] == '')	{
				$this->_price->addCategory($_POST);
				
			}	else {
				$this->_price->saveCategory($_POST);	
			}
			
			$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms#', 'cms', 'price', 'category', $this->_session->lang_code));
			exit();
		}

		$category_details = $this->_price->getCategoryDetails((int)$this->_router->getItemSegments(3));
		$this->_view->category_details 	= $category_details;
		
		print $this->_view->render('modules/'.$this->_engine->getModuleName().'/cms/templates/category.edit.tpl');
		exit();
	}
}
?>