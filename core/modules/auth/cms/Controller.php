<?php 

class authController extends Engine_Controller {

	private $_storage;
	private $_roles;
	
	public function __construct($engine)	{
		
		parent::__construct($engine);

		$this->_storage = $this->_auth->getStorage();
		
		$this->_head->addStyleFile('login.css?v=1', 'screen', true, '/files4cms/css/');
		
		$this->_engine->_templateFile = 'cms_login';
	}
	
	public function index()	{
		
		$cache =  Zend_Registry::get('cache');
		
		print_r($this->_auth->getIdentity());
		
		if($this->_auth->hasIdentity())	{
			
			die('test');
			
		}	else	{
			
			$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms','auth','login'));
		}
	}
	
	public function login()	{
		
		if($this->_router->isAjaxRequest())	{
			
			if($_REQUEST['login'] != '' && $_REQUEST['passwd'] != '')	{
			
				$db = Zend_Db_Table::getDefaultAdapter();
				
				// tworzymy instancję adaptera autoryzacji
				$authAdapter = new Zend_Auth_Adapter_DbTable($db, 'cms_user', 'user_login', 'user_passwd');
				
				$authAdapter->setIdentity($_REQUEST['login']);
				$authAdapter->setCredential(sha1($_REQUEST['passwd'].$this->_config->salt));
				
				// sprawdzamy, czy użytkownik jest aktywny
				$authAdapter->setCredentialTreatment("? AND user_active = '1'");
				
				// autoryzacja
				$result = $authAdapter->authenticate();
	
				if($result->isValid())	{
			
					$user_data = $authAdapter->getResultRowObject();
					
					/*	zapisanie roli zalogowanego uzytkownika	*/
					$this->_roles = RolesModel::Instance();
					$role = $this->_roles->getRoleData($user_data->role_id);				
					$user_data->role_code = $role['role_code'];
					$this->_storage->write($user_data);
					
					// ustawienie ACL dla użytkownika
					//$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms','index'));
					
					print "logged";
					
				}	else	{
					
					print "error";
				}
				
			}	else	{
				
				print "error";
			}
			exit();	
		}
		
		$this->_engine->setToRender('login.tpl');
	}
	
	public function logout()	{
		
		$this->_auth->clearIdentity();
		$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms', 'auth', 'login'));
		exit();
	}
}
?>