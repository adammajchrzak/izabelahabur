<?php 

/**
 * zarządzanie grupami użytkowników (ROLE) 
 * 
 * @author Adam Majchrzak
 * 
 */

class roleController extends Engine_Controller	{
	
	public $_roles;
	
	public function __construct($engine)	{
		
		parent::__construct($engine);
		
		if(!$this->_auth->hasIdentity())	{
			$this->engine->addHttpHeader("Location: ".$this->router->getUrl('auth'));
			exit();
		}
		
		$this->_roles = RolesModel::Instance();
		
		$this->view->page_sidebar = $this->view->render('modules/role/sidebar.tpl');
	}
	
	public function index()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, 'role-list', '1') && 
			!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, 'role-list', '2')
		)	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		/*	ładowanie zawartosci na AJAX'ie	*/
		if($this->router->isAjaxRequest())
			die('Wywołanie AJAX!!!');
		
		$this->view->roles_list = $this->_roles->getRolesList();
		
		$this->engine->setToRender('list.tpl');
	}
	
	
	public function view()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, 'role-view', '1') && 
			!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, 'role-view', '2')
		)	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		$this->engine->addHttpHeader("Location: ".$this->router->getUrl("role"));
		exit();
	}
	
	public function add()	{ 
		
		/*	kontrola uprawnien	*/
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, 'role-access', '16'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		$this->engine->setToRender('add.tpl');
		
		$this->engine->addHttpHeader("Location: ".$this->router->getUrl("role"));
		exit();
	}
	
	public function edit()	{
		
		/*	kontrola uprawnien	*/
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, 'role-edit', '1') && 
			!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, 'role-edit', '2')
		)	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->router->isPostRequest())	{
			
			$this->_roles->roleDataSave($_POST);
			
			$this->engine->addHttpHeader("Location: ".$this->router->getUrl("role"));
			exit();
		}
		
		if($this->router->getItemSegments(2))	{
			
			$this->view->role = $this->_roles->getRoleData($this->router->getItemSegments(2));
		
			$this->engine->setToRender('edit.tpl');
			
		}	else	{
			
			$this->engine->addHttpHeader("Location: ".$this->router->getUrl("role"));
			exit();
		}
	}
	
	public function delete()	{
		
		/*	kontrola uprawnien	*/
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, 'role-delete', '1') && 
			!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, 'role-delete', '2')
		)	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		$this->engine->addHttpHeader("Location: ".$this->router->getUrl("role"));
		exit();
	}
	
	
	
	/* kontrola uprawnien dla poszczególnych grup uzytkownikow	*/
	
	public function role_privilege()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, 'role-edit', '1') && 
			!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, 'role-edit', '2')
		)	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		/**
		 * 
		 * ACCESS
		 * EDIT
		 * DELETE
		 * EXPORT
		 * IMPORT
		 * LIST
		 * VIEW
		 * 
		 * explode typów uprawnień dla poszczególnych akcji w ramach danych modułów
		 * 
		 * 
		 * ALL, OWNER, ENABLED, DISABLED, NOT SET, NONE
		 * 
		 * 
		 */
		// crm_role_privileges - zczytywanie ACL przy załadowaniu CRM'a -> po zalogowaniu się użytkownika
		
		/**
		 * 
		 * {"all":"1", "owner":"2", "none":"4", "not set":"8", "enabled":"16", "disabled":"32"}
		 * {"wszyscy":"1", "właściciel":"2", "nikt":"4", "nie ustawione":"8", "dostępne":"16", "niedostępne":"32"}
		 * 
		 * pobranie i wpisanie do tablicy uprawnień PRIVILIGES dla poszczególnych modułów dla ROLE
		 * key => module, value => {access = '1', edit = '2'}
		 * 
		 */
		
		if($this->router->isPostRequest())	{
			
			$this->_roles->rolePrivilegesSave($_POST);
			
			$this->engine->addHttpHeader("Location: ".$this->router->getUrl("role"));
			exit();
		}
		
		if($this->router->getItemSegments(2))	{
			
			$privilege_list = $this->_roles->getPrivilegesList();
			foreach($privilege_list as $key=>$value)	{
				$privilege_list[$key]['privilege_value'] = json_decode($value['privilege_value']);
			}
			$this->view->privilege_list = $privilege_list;
			
			$role_privileges = $this->_roles->getPrivilegesForRole($this->router->getItemSegments(2));
			foreach($role_privileges as $key=>$value)	{
				$lista[str_replace("-", "_", $value['module_privilege'])] = $value['acl'];
			}
			$this->view->role_privilege_list = $lista;
			
			
			$this->view->module_list = $this->_roles->getModulesList();
			
			$this->engine->setToRender("role_privilege.tpl");
		
		}	else	{
			
			
			/* 
			 *	przekierowanie na stronę główną modułu ROLE
			 * 
			 */
		}
	}
	
	public function privilege_edit()	{
		
		/**
		 * 
		 * edycja poziomu dostępu do modułów z poziomu list rozwiajnych 
		 * w tabeli zawierającej wszelkie poziomy dostępu
		 * 
		 * zapis poziomów dostępu dla uzytkowników administracyjnych
		 * 
		 * wyświetlenie edycji po rozpoznaniu użytkownika z odpowiednim poziomem dostępu do tej akcji modułu
		 * 
		 */
	}
}
?>