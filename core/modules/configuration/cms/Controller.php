<?php
/*
 * configurationController
 * 
 * @author Adam Majchrzak
 * @jusee.pl
 */

class configurationController extends Engine_Controller	{
	
	public $_configuration;
	
	public function __construct($engine)	{
		
		parent::__construct($engine);
		
		if(!$this->_auth->hasIdentity())	{
			$this->_engine->addHttpHeader("Location: ".$this->_router->getUrl('cms', 'auth'));
			exit();
		}
		
		$this->_configuration = ConfigurationModel::Instance();
		
		$this->_head->addStyleFile('jquery.ui.all.css', 'screen', true, '/css/jquery-ui/'); 	// JqueryUI CSS
		$this->_head->addStyleFile('jquery.ui.uniform.css', 'screen', true, '/css/jquery-ui/'); 	// JqueryUI CSS
		$this->_head->addStyleFile('base.css', 'screen', true, '/css/cms/'); 	
		
		$this->_head->addScriptFile('jquery-ui-'.$this->_config->jqueryui.'.min.js', true, '/scripts/jquery-ui/');		// JqueryUI JS
		$this->_head->addScriptFile('base.js', true, '/scripts/cms/');		// JqueryUI JS
		$this->_head->addScriptFile('jquery.uniform.min.js', true, '/scripts/cms/');		// JqueryUI JS
	}
	
	public function index()	{

		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'view'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		$this->_view->item_list = $this->_configuration->getConfigurationList();

		print $this->_view->render('modules/configuration/cms/templates/index.tpl');
		exit();
	}
	
	public function add()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'add'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		print $this->_view->render('modules/configuration/cms/templates/add.tpl');
		exit();
	}
	
	public function edit()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			
			if(empty($_POST['id']) || $_POST['id'] == '0' || $_POST['id'] == '')	{
				$this->_configuration->addConfigurationItem($_POST);
			}	else {
				$this->_configuration->saveConfigurationItem($_POST);	
			}
			
			$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms#','cms', 'configuration'));
			exit();
		}
		
		$this->_view->item_details = $this->_configuration->getConfigurationDetails((int)$this->_router->getItemSegments(3));
		
		print $this->_view->render('modules/configuration/cms/templates/edit.tpl');
		exit();
	}
	
	public function delete()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'delete'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			$this->_configuration->deleteConfiguration($_POST);
		}
		exit();
	}
	
}
	
?>