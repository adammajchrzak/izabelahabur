<?php

/*
 * attachmentController
 * 
 * @author Adam Majchrzak
 * @jusee.pl
 */

 class attachmentController extends Engine_Controller	{
	
	public $_price;
	public $_locale_codes;
	
	public function __construct($engine)	{
		
		parent::__construct($engine);
		
		if(!$this->_auth->hasIdentity())	{
			$this->_engine->addHttpHeader("Location: ".$this->_router->getUrl('cms', 'auth'));
			exit();
		}
		
		$this->_attach	= AttachmentModel::Instance();
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

		$this->_view->locales_list	=	$this->_price->getLocalesList(array());

		print $this->_view->render('modules/'.$this->_engine->getModuleName().'/cms/templates/list.tpl');
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

	public function generate()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'view'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}

		$this->_view->item			=	$this->_price->getLocalDetails((int)$this->_router->getItemSegments(3));
		$this->_view->category_list	=	$this->_price->getLocalesCategoryList();
		
		print $this->_view->render('modules/'.$this->_engine->getModuleName().'/cms/templates/generate.tpl');
		exit();
	}
}
?>