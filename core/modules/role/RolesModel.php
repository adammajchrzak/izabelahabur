<?php 

/**
 * RolesModel.php
 * 
 * @author Adam Majchrzak
 */

class RolesModel extends Engine_Model {
	
	static $_instance = null;
	
	public function __construct()	{
		parent::__construct();
	}
	
	public function Instance()	{
		
		if(!isset(RolesModel::$_instance))	{
			RolesModel::$_instance = new RolesModel();
		}
		
		return RolesModel::$_instance;
	}
	
	public function getRolesList()	{
		
		$select = $this->_db->select()
									->from('cms_role')
									->where('role_show = 1')
									->order('role_name');
					
		$this->_cSelect->setTags(array('roles', 'getRolesList' , 'list'));
		$result = $this->_cSelect->fetchAll($select);
		
		return $result;
	}
	
	public function getRoleData($role_id)	{
		
		$select = $this->_db->select()
									->from('cms_role')
									->where('role_id = ?', (int)$role_id);

		$this->_cSelect->setTags(array('roles', 'getRoleData' , 'data_'.(int)$role_id));							
		$result = $this->_cSelect->fetch($select);
		
		return $result;
	}
	
	public function roleDataAdd($data)	{
		
		$insert = array(
			"role_name" 		=> $data['role_name'],
			"role_code" 		=> $data['role_code'],
			"role_description" 	=> $data['role_description']
		);
		
		$this->_db->insert("cms_role", $insert);
		
		$this->_cSelect->clearMatchingAll(array('roles', 'getRolesList' , 'list'));
		$this->_cSelect->clearMatchingAll(array('roles', 'getRoleData' , 'data_'.(int)$role_id));
		
		return true;
	}
	
	public function roleDataSave($data)	{
		
		$update = array(
			"role_name" 		=> $data['role_name'],
			"role_code" 		=> $data['role_code'],
			"role_description" 	=> $data['role_description']
		);
		
		$this->_db->update("cms_role", $update, "role_id='".(int)$data['role_id']."'");
		
		$this->_cSelect->clearMatchingAll(array('roles', 'getRolesList' , 'list'));
		$this->_cSelect->clearMatchingAll(array('roles', 'getRoleData' , 'data_'.(int)$data['role_id']));
		
		return true;
	}
	
	public function rolePrivilegesSave($data)	{
		
		
		$this->_db->delete("cms_role_privileges", "role_id='".(int)$data['role_id']."'");
		
		$this->_cSelect->clearMatchingAll(array('privileges', 'getPrivilegesForRole' , 'list_'.(int)$data['role_id']));
		
		foreach($data['role'] as $key=>$value)	{
			
			list($module_code, $module_privilege, $privilege_id) = explode("-", $key);
			
			$insert = array(
				"role_id"			=> (int)$data['role_id'],
				"privilege_id"		=> $privilege_id,
				"module_code"		=> $module_code,
				"module_privilege" 	=> $module_code."-".$module_privilege,
				"acl"				=> $value
			);
			
			$this->_db->insert("cms_role_privileges", $insert);
		}
		
		return true;
	}
	
	public function getModulesList()	{
		
		$select = $this->_db->select()
									->from('cms_module')
									->order('module_id');
		$this->_cSelect->setTags(array('modules', 'getModulesList', 'list'));
		
		$result = $this->_cSelect->fetchAll($select);
		
		return $result;
	}
	
	public function getPrivilegesList()	{
		
		$select = $this->_db->select()
									->from('cms_privileges')
									->order('privilege_id');
		$this->_cSelect->setTags(array('privileges', 'getPrivilegesList', 'list'));
		
		$result = $this->_cSelect->fetchAll($select);
		
		return $result;
	}
	
	
	public function getPrivilegesForRole($role_id)	{
		
		$select = $this->_db->select()
									->from('cms_role_privileges')
									->where('role_id = ?', (int)$role_id);
		
		$this->_cSelect->setTags(array('privileges', 'getPrivilegesForRole' , 'list_'.(int)$role_id));							
		$result = $this->_cSelect->fetchAll($select);
									
		return $result;
	}
}
?>