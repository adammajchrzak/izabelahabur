<?php 

/*
 * sliderController
 * 
 * @author Adam Majchrzak
 * @jusee.pl
 */

class sliderController extends Engine_Controller	{
	
	public $_slider;
	
	public function __construct($engine)	{
		
		parent::__construct($engine);
		
		$session_uid = $this->_router->getItemSegments(3); // upload auth
		
		if(!$this->_auth->hasIdentity() && ($this->_acl->checkSessionUid($session_uid) == false ))	{
			
			$this->_engine->addHttpHeader("Location: ".$this->_router->getUrl('cms', 'auth'));
			exit();
		}
		
		$this->_slider = SliderModel::Instance();
		
		$this->dir = dirname(__FILE__)."/";
        
		if($this->_config->multi_locale == '1')	{
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

		$this->_view->list = $this->_slider->getSliderList($this->_session->lang_code);
		
		print $this->_view->render('modules/slider/cms/templates/list.tpl');
		exit();
	}
	
	public function active() {
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			$this->_slider->activeSlider($_POST);
		}
		
		exit();
	}
	
	public function add()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'add'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
        
		$item['lang_code']	=	$this->_session->lang_code;
        
		$this->_view->item	=	$item;
	 	print $this->_view->render('modules/slider/cms/templates/add.tpl');
		exit();
	}

	public function edit()
    {
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			if($_POST['slider_id'] == '0' || $_POST['slider_id'] == '')	{
                $data = $_POST;
                $filename = $this->upload();
                $data['_file'] = $filename;
				$slider_id = $this->_slider->addItemDetails($data);
				$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms#','cms','slider'));				
			}	else {
				$this->_slider->saveItemDetails($_POST);	
			}

			$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms#','cms','slider'));
			exit();
		}
		
		$this->_view->item = $this->_slider->getItemDetails((int)$this->_router->getItemSegments(3));
		
		print $this->_view->render('modules/slider/cms/templates/edit.tpl');
		exit();
	}
	
	private function upload()
    {
		if (!empty($_FILES)) {
            $tempFile   = $_FILES['_file']['tmp_name'];
			$extension  = strtolower($this->getExtension($_FILES['_file']['name']));
			$filename   = pathinfo($_FILES['_file']['name']);
			$filename   = date("Y-m-d_His_").$this->_slider->ToSlug($filename['filename']).'.'.$extension;
            $targetFile = $_SERVER['DOCUMENT_ROOT'].$this->_config->slider->folder.$filename;
            
			move_uploaded_file($tempFile, $targetFile);
		}
        
		return $filename;
	}
	
	private function getExtension($str)
    {
		$i = strrpos($str, ".");
		if (!$i) { return ""; }
		$l= strlen($str) - $i;
		$ext = substr($str, $i+1, $l);
		
		return $ext;
	}

	public function delete()
    {
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'delete'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isAjaxRequest())	{
			$this->_slider->deleteSlider($_REQUEST);
		}
		
		exit();
	}
    
    
}
