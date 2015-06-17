<?php 

/**
 * RolesModel.php
 * 
 * @author Adam Majchrzak
 */

class UsersModel extends Engine_Model {
	
	static $_instance = null;
	
	public function __construct()	{
		parent::__construct();
	}
	
	public function Instance()	{
		
		if(!isset(UsersModel::$_instance))	{
			UsersModel::$_instance = new UsersModel();
		}
		
		return UsersModel::$_instance;
	}
	
	public function getUsersList()	{
		
		$select = $this->_db->select()
									->from(array('cu' => 'cms_user'))
									->joinLeft(
												array('cr' => 'cms_role'),
												'cr.role_id = cu.role_id',
												array('cr.role_name')
									)
									->where('cr.role_show = ?', '1')
									->order('user_firstname');
		
		$result = $this->_db->fetchAll($select);
		
		return $result;
	}
	
	public function getUserDetails($user_id)	{
		
		$select	= $this->_db->select()
									->from(array('cu' => 'cms_user'))
									->where('cu.user_id = ?', (int)$user_id);
		$result = $this->_db->fetchRow($select);
		
		return $result;				
	}
	
	
	public function getAlertsList()	{
		
		$select = $this->_db->select()
									->from(array('ca' => 'cms_logs_error'))
									->order('log_date DESC');
		
		$result = $this->_db->fetchAll($select);
		
		return $result;
	}
	
	
	public function addUserDetails($data)	{
		
		$insert	=	array(
		
			'user_login'		=>	$data['user_login'],
			'user_passwd'		=>	sha1($data['user_passwd']),
			'user_firstname'	=>	$data['user_firstname'],
			'user_lastname'		=>	$data['user_lastname'],
			'user_email'		=>	$data['user_email'],
			'user_active'		=>	(int)$data['user_active'],
			'role_id'			=>	(int)$data['role_id']
		);
		
		$this->_db->insert('cms_user', $insert);
		return true;
	}
	
	public function saveUserDetails($data)	{
		
		$update	=	array(
			'user_login'		=>	$data['user_login'],
			'user_firstname'	=>	$data['user_firstname'],
			'user_lastname'		=>	$data['user_lastname'],
			'user_email'		=>	$data['user_email'],
			'user_active'		=>	(int)$data['user_active'],
			'role_id'			=>	(int)$data['role_id']
		);
		
		if($data['user_passwd'] != '')	{
			$update['user_passwd']	= sha1($data['user_passwd']);
		}
		
		$this->_db->update("cms_user", $update, "user_id = '".(int)$data['user_id']."'");
		
		return true;
	}
	
	public function deleteUser($data) {
		
		$this->_db->delete("cms_user", "user_id = '".(int)$data['user_id']."'");
		
		return true;
	}
	
}
?>