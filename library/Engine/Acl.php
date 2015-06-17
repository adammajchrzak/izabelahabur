<?php 

/*
 * Engine Acl
 * 
 * @author Adam Majchrzak
 * @author jusee.pl
 */

class Engine_Acl	{
	
	protected $_engine;
	protected $_router;
	protected $_config;
	protected $_db;
	protected $_acl;
	
	protected $_tmp_resource_acl = 0;
	
	
	public function __construct($engine)	{
		
		$this->_engine   	= 	$engine;
		$this->_config 		=	Zend_Registry::get('config');
		$this->_db			=	Zend_Registry::get('db');
		$this->_router   	= 	Zend_Registry::get('router');
		$this->_acl 		=	null;
	}
	
	/**
	 * pobranie obiektu ACL
	 * 
	 * @return Zend_Acl
	 * 
	 */
	
	public function _getAcl()	{
		
		if($this->_acl !== null)	{
			return $this->_acl;
		}
		
		$cache		=	Zend_Registry::get('cache');
		$cache_name =	'cms_acl_roles';
		
		if($this->_config->mode != 'staging' && ($this->_acl = $cache->load($cache_name)) !== false)	{
			return $this->_acl;
		}
		
		$acl = new Zend_Acl();
		
		$select = $this->_db->select()->from('cms_privileges')->order('privilege_name');
		$result	= $this->_db->fetchAll($select);

		foreach($result as $privilege)	{
			$privilegeArray[$privilege['privilege_name']] = (int)$privilege['privilege_value'];
		}
		
		$select = $this->_db->select()
									->from('cms_role')
									->order('role_name');
		$result = $this->_db->fetchAll($select);
		
		foreach($result as $role)	{
			
			$acl->addRole(new Zend_Acl_Role($role['role_code']));
			
			$module_select = $this->_db->select()
												->from('cms_role_privileges')
												->where('role_id = ?', (int)$role['role_id'])
												->order('module_code');
			$module_result = $this->_db->fetchAll($module_select);
			
			foreach($module_result as $resource)	{
				
				$this->_tmp_resource_acl = (int)$resource['acl'];
				if(!$acl->has($resource['module_code'])) { // module-privilege == name np. firm-access, firm-edit
					$acl->add(new Zend_Acl_Resource($resource['module_code']));
				}
				
				$p = array_keys(array_filter($privilegeArray, array($this, "_getPrivileges")));
				$acl->allow($role['role_code'], $resource['module_code'], $p ? $p : array('nop') );	
			}
		}
		
		$cache->save($acl, $cache_name, array('cms', 'cms_acl'), null);
		$this->_acl = $acl;
		return $this->_acl;
	}
	
	protected function _getPrivileges($privilege)	{
		return $privilege & $this->_tmp_resource_acl;
	}
	
	public function isAllowed($role = null, $resource = null, $privilege = null)	{
		
		if($role == 'cAMdmin')	{
			return true;
		}	

		if($resource && is_array($resource))
			$resource = $resource[0] != $this->_config->module ? $resource[0] : isset($resource[1]) ? $resource[1] : null;
		
		if($role == null || !($resource && $this->_getAcl()->has($resource)))	{
			return false;
		}
		// echo " $role  $resource  $privilege ".( $this -> _getAcl()->isAllowed($role,$resource,$privilege) ? 'tak':'nie')."\n";
		
		return $this -> _getAcl()->isAllowed($role, $resource, $privilege);
	}
	
	public function arrayFilter($role, array $array, array $privileges ){
		
		if( $role == 'cAMdmin')
			return $array;
						
		$arrayTmp = array();
		
		foreach( $array as $k => $v ){
			if(isset($privileges[$k]) && $this->isAllowed($role, $privileges[$k]['resource'], $privileges[$k]['privilege']))	{		
				$arrayTmp[$k] = $array[$k];	
			}
		}
		
		return $arrayTmp;
	}
	
	public function aclMessage($user_id, $class_name, $function_name, $message)	{

		/* logowanie zachowań użytkowników	*/
		
		$insert = array(
			"user_id"	=> (int)$user_id,
			"log_date"	=> date('Y-m-d H:i:s'),
			"log"		=> json_encode(array('class' => $class_name, 'function' => $function_name)),
			"log_ip"	=> $_SERVER['REMOTE_ADDR']
		);
		
		$this->_db->insert('cms_logs_error', $insert);
		
		$this->_engine->addHttpHeader("Location: ".$this->_router->getUrl('cms','index','restricted'));
		exit();
	}
	
	public function checkSessionUid($uid)	{
		
		return true;
	}
}


?>