<?php
/*
 * userController
 * 
 * @author Adam Majchrzak
 * @jusee.pl
 */

class userController extends Engine_Controller	{
	
	public $_user;
	
	public function __construct($engine)	{
		
		parent::__construct($engine);
		
		if(!$this->_auth->hasIdentity())	{
			$this->_engine->addHttpHeader("Location: ".$this->_router->getUrl('cms', 'auth'));
			exit();
		}
		
		$this->_user = UsersModel::Instance();
		
		$this->_head->addStyleFile('jquery.ui.all.css', 'screen', true, '/css/jquery-ui/'); 	// JqueryUI CSS
		$this->_head->addStyleFile('jquery.ui.uniform.css', 'screen', true, '/css/jquery-ui/'); 	// JqueryUI CSS
		$this->_head->addStyleFile('base.css', 'screen', true, '/css/cms/'); 	
		
		$this->_head->addScriptFile('jquery-ui-'.$this->_config->jqueryui.'.min.js', true, '/scripts/jquery-ui/');		// JqueryUI JS
		$this->_head->addScriptFile('base.js', true, '/scripts/cms/');		// JqueryUI JS
		$this->_head->addScriptFile('jquery.uniform.min.js', true, '/scripts/cms/');		// JqueryUI JS
		$this->_head->addScriptFile('user.js', true, '/scripts/cms/');		// JqueryUI JS
	}
	
	public function index()	{

		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'view'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		$this->_view->users_list = $this->_user->getUsersList();

		print $this->_view->render('modules/user/cms/templates/index.tpl');
		exit();
	}

	public function alert()	{
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'view'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		$this->_view->alerts_list = $this->_user->getAlertsList();
		print $this->_view->render('modules/user/cms/templates/alert.list.tpl');
		exit();
	}
	
	public function add()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'add'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		print $this->_view->render('modules/user/cms/templates/add.tpl');
		exit();
	}
	
	public function edit()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			
			if(empty($_POST['user_id']) || $_POST['user_id'] == '0' || $_POST['user_id'] == '')	{
				$data = $_POST;
				$data['user_passwd'] = $data['user_passwd'].$this->_config->salt;
				$this->_user->addUserDetails($data);
			}	else {
				$data = $_POST;
				if($data['user_passwd'] != '')	{
					$data['user_passwd'] = $data['user_passwd'].$this->_config->salt;
				}
				$this->_user->saveUserDetails($data);	
			}
			
			$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms#','cms', 'user'));
			exit();
		}
		
		$this->_view->user_details = $this->_user->getUserDetails((int)$this->_router->getItemSegments(3));
		
		print $this->_view->render('modules/user/cms/templates/edit.tpl');
		exit();
	}
	
	public function delete()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'delete'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			$this->_user->deleteUser($_POST);
		}
		exit();
	}
	
}
	
?>