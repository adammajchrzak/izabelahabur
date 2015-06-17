<?php 

/*
 * indexController
 * 
 * @author Adam Majchrzak
 * @jusee.pl
 */

class indexController extends Engine_Controller	{
	
	public $_cms;
	
	public function __construct($engine)	{
		
		parent::__construct($engine);
		
		if(!$this->_auth->hasIdentity())	{
			$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms', 'auth'));
			exit();
		}
		
		$this->_cms 	= IndexModel::Instance();
		$this->_gallery	= GalleryModel::Instance();
		
		if($this->_config->multi_locale == '1')	{
			$this->_view->locale_list = $this->_function->getSiteLocaleList();
		}	else {
			$this->_view->locale_list = $this->_function->getSiteLocaleList();
		}
		
		$this->_view->sidebar =  $this->_view->render('modules/index/cms/templates/sidebar.tpl');
	}
	
	public function index()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'view'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		$this->_view->structure_tree = $this->_cms->getSiteStructure('0');
		
		$this->_engine->setToRender('index.tpl');
	}
	
	public function tree()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'view'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		$this->_view->structure_tree = $this->_cms->getSiteStructure('0');
		
		print $this->_view->render('modules/index/cms/templates/tree.tpl');
		exit();
	}
	
	public function active() {
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			$this->_cms->activePage($_POST);
		}
		
		exit();
	}
	
	public function add()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'add'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}

		$page_details['page_id']		=	'0';
		$page_details['parent_id']		=	(int)$this->_router->getItemSegments(3);
		
		$this->_view->template_list		=	$this->_cms->getTemplateList();
		$this->_view->page_details		=	$page_details;
		
		print $this->_view->render('modules/index/cms/templates/add.tpl');
		exit();
	}
	
	public function edit()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			
			if($_POST['page_id'] == '0' || $_POST['page_id'] == '')	{
				$this->_cms->addPageDetails($_POST);
			}	else {
				$this->_cms->savePageDetails($_POST);	
			}
			
			$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms#','cms', 'index','tree'));
			exit();
		}
		
		$this->_view->template_list		=	$this->_cms->getTemplateList();
		$page_details					=	$this->_cms->getPageDetails((int)$this->_router->getItemSegments(3));
		$this->_view->page_details		=	$page_details;
		
		$this->_view->sidebar = $this->_view->render('modules/index/cms/templates/sidebar.edit.tpl');
		
		print $this->_view->render('modules/index/cms/templates/edit.tpl');
		exit();
	}

	public function editnode()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			if($_POST['node_id'] == '0' || $_POST['node_id'] == '')	{
				$this->_cms->addPageDetails($_POST);
			}	else {			
				$this->_cms->saveNodeDetails($_POST);	
			}
			$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms#','cms', 'index','edit',$_POST['page_id']));
			exit();
		}
		
		$page_details = $this->_cms->getNodeDetails((int)$this->_router->getItemSegments(3), $this->_router->getItemSegments(4));
		$this->_view->page_details = $page_details;
		
		$this->_view->node_items	=	$this->_cms->getNodeItems((int)$page_details['node_id']);
		
		// $this->_view->sidebar = $this->_view->render('modules/index/cms/templates/sidebar.edit.tpl');
		
		print $this->_view->render('modules/index/cms/templates/edit.node.tpl');
		exit();
	}

	public function editnodeitem() {
		
		if($this->_router->isPostRequest())	{
			// IMPORTANT saveNodeItem ##############
			if($_POST['item_id'] == '0' || $_POST['item_id'] == '')	{
				$this->_cms->addItemDetails($_POST);
			}	else {
				$this->_cms->saveItemDetails($_POST);		
				//$this->_cms->saveTextContent($_POST);	
			}
			exit();
		}
		
		$item_details = $this->_cms->getNodeItem((int)$this->_router->getItemSegments(3));

		switch($item_details['module_id']) { // do sparametryzowania w ramach pliku konfiguracyjnego
			
			case "1": // text
				$item_content = $this->_cms->getTextContent((int)$item_details['object_id']);
				$this->_view->item_details = $item_details;
				$this->_view->item_content = $item_content;
				print $this->_view->render('modules/index/cms/templates/edit.node.item.tpl');
				break;
				
			case "2": // gallery
				$gallery_list = $this->_gallery->getGalleryList($item_details['lang_code']);
				$this->_view->item_details = $item_details;
				$this->_view->gallery_list = $gallery_list;
				print $this->_view->render('modules/gallery/cms/templates/edit.node.item.tpl');
				break;
		}
		
		exit();
	}
	
	public function viewnodeitem() {
		
		$item_details = $this->_cms->getNodeItem((int)$this->_router->getItemSegments(3));
		
		switch($item_details['module_id']) { // do sparametryzowania w ramach pliku konfiguracyjnego
			
			case "1": // text
				$item_content = $this->_cms->getTextContent((int)$item_details['object_id']);
				$this->_view->item_details = $item_details;
				$this->_view->item_content = $item_content;
				print $this->_view->render('modules/index/cms/templates/view.node.item.tpl');
				break;
			case "2": // gallery
				$this->_view->picture_list 	=	$this->_gallery->getPictureForGalleryList((int)$item_details['object_id']);
				print $this->_view->render('modules/gallery/cms/templates/view.node.item.tpl');
				break;	
		}
		
		
		exit();
	}
	
	public function deletenodeitem() {
		
		if($this->_router->isAjaxRequest())	{
			$this->_cms->deleteNodeItem($_REQUEST);
		}
		
		exit();
	}
	
	public function sort() {
		
		$this->_engine->_templateFile = '';
		$this->_engine->unsetToRender();
		
		if($this->_router->isAjaxRequest())	{
					
			foreach ($_REQUEST['item'] as $position => $item) {
				$sql[] = "UPDATE `table` SET `position` = $position WHERE `id` = $item"; 
			}
			
			print_r ($sql);
			print "OK";
		}
		
		
		exit(); 
	}
	
	public function move()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isAjaxRequest())	{
			$this->_cms->movePageInStructure($_REQUEST);
		}
		
		exit();
	}
	
	public function delete()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'delete'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isAjaxRequest())	{
			$this->_cms->deletePage($_REQUEST);
		}
		
		exit();
	}
	
	public function restricted()	{
		
		$this->_engine->setToRender('restricted.tpl');
	}
}
?>