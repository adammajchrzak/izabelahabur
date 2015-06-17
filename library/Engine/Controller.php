<?php 

/*
 * Engine Conrroller
 * 
 * @author Adam Majchrzak
 * @author jusee.pl
 */

abstract class Engine_Controller	{
	
	protected $_engine;
	protected $_router;
	protected $_view;
	protected $_config;
	protected $_head;
	protected $_function;
	
	protected $_acl;
	protected $_auth;
	
	protected $_session;
	
	abstract public function index ();
	
	public function __construct(Engine_Engine $engine)	{
		
		$this->_engine   	= $engine;
		$this->_router   	= Zend_Registry::get('router');
		$this->_view		= Zend_Registry::get('view');
		$this->_config   	= Zend_Registry::get('config');
		$this->_acl  		= new Engine_Acl($engine);
		$this->_auth 		= Zend_Auth::getInstance();
		$this->_session 	= new Zend_Session_Namespace('cms_session');
		$this->_head 		= HtmlHead::Instance();
		$this->_function	= Functions::Instance();
		
		$this->_head->addScriptFile($this->_config->jquery_min, true, '/js/');		// jquery.min.js
		$this->_view->head = $this->_head;
		
		$this->_view->_auth = $this->_auth;

		if($this->_config->module_type == 'cms')	{
			
			$this->_session->current_locale = $this->_config->default_locale;
			include "templates/".$this->_config->module_type."/locale/".$this->_session->current_locale.".php";
			
			if(is_file("../core/modules/".$this->_config->module."/".$this->_config->module_type."/locale/".$this->_session->current_locale.".php"))	{
				include "../core/modules/".$this->_config->module."/".$this->_config->module_type."/locale/".$this->_session->current_locale.".php";
				$locale	= array_merge($locale, $locale);
			}

			$this->_head->addStyleFile('jquery.ui.cms.css', 'screen',	true,	'/files4cms/css/jquery-ui/'); 	// JqueryUI CSS
			$this->_head->addScriptFile('jquery.CKEditor.js',			true,	'/files4cms/js/core/');				
			$this->_head->addScriptFile('ckeditor.js', 					true,	'/files4cms/js/ckeditor/');
			// $this->_head->addScriptFile('jquery.ui.datepicker-pl.js',	true,	'/files4cms/js/core/');
			
		}	elseif($this->_config->module_type = 'site')	{
			
			$this->_session->current_locale = $this->_config->current_locale;
			include "templates/".$this->_config->module_type."/locale/".$this->_session->current_locale.".php";
			
			if(is_file("../core/modules/".$this->_config->module."/".$this->_config->module_type."/locale/".$this->_session->current_locale.".php"))	{
				include "../core/modules/".$this->_config->module."/".$this->_config->module_type."/locale/".$this->_session->current_locale.".php";
				$locale	= array_merge($locale, $locale);
			}
			
			$this->_config->locale	= $locale;
		}

		$this->_view->locale	= $locale;
		
		/**
		 * END
		 */
	}
}
?>