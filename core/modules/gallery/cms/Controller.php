<?php 

/*
 * galleryController
 * 
 * @author Adam Majchrzak
 * @jusee.pl
 */

class galleryController extends Engine_Controller	{
	
	public $_gallery;
	
	public function __construct($engine)	{
		
		parent::__construct($engine);
		
		$session_uid = $this->_router->getItemSegments(3); // upload auth
		
		if(!$this->_auth->hasIdentity() && ($this->_acl->checkSessionUid($session_uid) == false ))	{
			
			$this->_engine->addHttpHeader("Location: ".$this->_router->getUrl('cms', 'auth'));
			exit();
		}
		
		$this->_gallery = GalleryModel::Instance();
		
		$this->dir = dirname(__FILE__)."/";
		$galleryConfig = new Zend_Config_Xml($this -> dir . '../config.xml','gallery', true);
		
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

		$this->_view->gallery_list = $this->_gallery->getGalleryList($this->_session->lang_code);
		
		print $this->_view->render('modules/gallery/cms/templates/list.tpl');
		exit();
	}
	
	public function latest() {
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			$this->_gallery->latestGallery($_POST);
		}
		
		exit();
	}
    
    public function featured() {
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			$this->_gallery->featuredGallery($_POST);
		}
		
		exit();
	}
    
    public function active() {
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			$this->_gallery->activeGallery($_POST);
		}
		
		exit();
	}
    
    
    public function gmove()
    {
        if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isAjaxRequest())	{
			$this->_gallery->moveGalleryInStructure($_REQUEST);
		}
		
		exit();
    }
	
    
	public function add()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'add'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
        
		$gallery_details['lang_code']	=	$this->_session->lang_code;
        
		$this->_view->gallery_details	=	$gallery_details;
        $this->_view->category_list	    =	$this->_gallery->getGalleryCategoryList($this->_session->lang_code);
	 	print $this->_view->render('modules/gallery/cms/templates/add.tpl');
		exit();
	}

	public function edit()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			
			if($_POST['gallery_id'] == '0' || $_POST['gallery_id'] == '')	{
				
				$gallery_id = $this->_gallery->addGalleryDetails($_POST);
				$this->createGalleryDir(str_pad($gallery_id,4,'0',STR_PAD_LEFT));
				
				$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms#','cms','gallery','edit', $gallery_id));
				
			}	else {

                $data = $_POST;
                
                $this->_gallery->deleteKeywordFromGallery($data['gallery_id']);
                
                if($data['keyword_list'] !== '') {
                    $list = explode(',', $data['keyword_list']);
                    
                    foreach($list as $value) {
                        $isKeyword = $this->_gallery->isKeywordExist(strtoupper($value));
                        if($isKeyword) {
                            $this->_gallery->saveKeywordForGallery(array('gallery_id' => $data['gallery_id'], 'keyword_id' => $keywordId));
                        } else {
                            $keywordId = $this->_gallery->saveKeyword(trim(strtoupper($value)));
                            $this->_gallery->saveKeywordForGallery(array('gallery_id' => $data['gallery_id'], 'keyword_id' => $keywordId));
                        }
                    }
                }
                
                if(is_array($data['keywords'])) {                    
                    foreach($data['keywords'] as $value) {
                        $this->_gallery->saveKeywordForGallery(array('gallery_id' => $data['gallery_id'], 'keyword_id' => $value));
                    }
                }
                
				$this->_gallery->saveGalleryDetails($data);	
			}

			$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms#','cms','gallery'));
			exit();
		}
		
		$this->_head->addStyleFile('uploadify.css', 'screen', true, '/files4cms/js/uploadify/');
		//$this->_head->addScriptFile('swfobject.js', true, '/scripts/cms/uploadify/');
		$this->_head->addScriptFile('jquery.uploadify.js', true, '/files4cms/js/uploadify/');
		
		$this->_view->gallery_details = $this->_gallery->getGalleryDetails((int)$this->_router->getItemSegments(3));
		
		$this->_view->picture_list      =	$this->_gallery->getPictureForGalleryList((int)$this->_router->getItemSegments(3));
		$this->_view->category_list	    =	$this->_gallery->getGalleryCategoryList($this->_session->lang_code);
        $this->_view->gallery_keywords	=	$this->_function->flattenArray($this->_gallery->getKeywordsForGallery((int)$this->_router->getItemSegments(3)), 'keyword_id');
        $this->_view->keywords          =	$this->_gallery->getKeywordsFullList();
        
		print $this->_view->render('modules/gallery/cms/templates/edit.tpl');
		exit();
	}
	
	public function upload() {
		if (!empty($_FILES)) {
			
			$dirname	=	str_pad((int)$this->_router->getItemSegments(4),4,'0',STR_PAD_LEFT);
			
			$extension = $this->getExtension($_FILES['filedata']['name']);
			$extension = strtolower($extension);
			
			$filename	=	pathinfo($_FILES['filedata']['name']);
			$basename	=	$this->_gallery->ToSlug($filename['filename']).'.'.$extension;
			$filename	=	date("His").$this->_gallery->ToSlug($filename['filename']).'.'.$extension;
            
            
            $source_image = $_FILES['filedata']['tmp_name'];
            $quality = 100;
            $wmsource = $_SERVER['DOCUMENT_ROOT'].'/img/picture-bg.png';
            $success  = $this->image_handler($source_image, $dirname, $quality, $wmsource);

            $data = array('gallery_id' => $this->_router->getItemSegments(4), 'file_name' => $filename, 'file_basename' => $basename);
			
			$this->_gallery->addPictureToGallery($data);
			
			echo str_replace($_SERVER['DOCUMENT_ROOT'],'', $basename);
		}
        
		exit();
	}
	
	private function getExtension($str) {
			
		$i = strrpos($str, ".");
		if (!$i) { return ""; }
		$l = strlen($str) - $i;
		$ext = substr($str, $i+1, $l);
		
		return $ext;
	}
	
	private function createGalleryDir($dirname)	{
		
		if(!mkdir($_SERVER['DOCUMENT_ROOT'].$this->_config->gallery->dir.$dirname, 0755))	{
	    	$ErrorTxt .= "Nie mozna  utworzyć jednego z katalogów";
		   	return 0;
	    }
        
        $folders = explode(',', $this->_config->gallery->folders);
        
        foreach ($folders as $value) {
            if(!mkdir($_SERVER['DOCUMENT_ROOT'].$this->_config->gallery->dir.$dirname."/".$value, 0755))	{
                $ErrorTxt .= "Nie można utworzyć jednego z katalogów";
                return 0;
            }
        }
		
	    return 1;
	}

	public function delete()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'delete'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isAjaxRequest())	{
			$this->_gallery->deleteGallery($_REQUEST);
            
            $folders = explode(',', $this->_config->gallery->folders);
        
            foreach ($folders as $value) {
                rmdir($_SERVER['DOCUMENT_ROOT'].$this->_config->gallery_dir.str_pad($_REQUEST['gallery_id'],4,'0',STR_PAD_LEFT)."/".$value);
            }
			rmdir($_SERVER['DOCUMENT_ROOT'].$this->_config->gallery_dir.str_pad($_REQUEST['gallery_id'],4,'0',STR_PAD_LEFT));
		}
		
		exit();
	}
	
	public function picture_list()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'view'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		$this->_view->gallery_id	=	(int)$this->_router->getItemSegments(3);
		$this->_view->picture_list 	=	$this->_gallery->getPictureForGalleryList((int)$this->_router->getItemSegments(3));
		print $this->_view->render('modules/gallery/cms/templates/picture.list.tpl');
		exit();
	}
	
	public function picture_edit()	{
			
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{								
			$this->_gallery->savePictureDetails($_POST);	
			
			$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms#','cms','gallery','edit',$_POST['gallery_id']));
			exit();
		}
		
		$this->_view->picture_details =  $this->_gallery->getPictureDetails((int)$this->_router->getItemSegments(3));
		
		print $this->_view->render('modules/gallery/cms/templates/picture.edit.tpl');
		exit();
	}
	
	public function picture_delete()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'delete'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}

		$this->_gallery->deletePicture((int)$this->_router->getItemSegments(3));
		
		exit();
	}
    
    
    public function editlinks()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
            $data = $_POST;
            
            foreach($data as $key => $value) {
                $update = array();
                if(preg_match('/image/i', $key)) {
                    $imageId = str_replace('image', '', $key);
                    $update['istock_link'] = $value;
                }
                
                $update['_level1'] = (int)$data['level1'.$imageId];
                $update['_level2'] = (int)$data['level2'.$imageId];
                
                $update['picture_id'] = $imageId;
                
                $this->_gallery->saveImagesLinks($update);
            }
			$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms#','cms','gallery','edit',$_POST['gallery_id']));
			exit();
		}

	}
    
    
    
    /*	category */
	
	public function category()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'view'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}

		if(in_array($this->_router->getItemSegments(3), $this->_locale_codes)) {
			$this->_session->lang_code = $this->_router->getItemSegments(3);
		}

		$this->_view->category_list = $this->_gallery->getGalleryCategoryList($this->_session->lang_code);

		print $this->_view->render('modules/gallery/cms/templates/category.list.tpl');
		exit();
	}
	
	public function cactive() {
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			$this->_gallery->activeGalleryCategory($_POST);
		}
		
		exit();
	}
    
    
    public function cmove()
    {
        if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isAjaxRequest())	{
			$this->_gallery->moveCategoryInStructure($_REQUEST);
		}
		
		exit();
    }
	
	
	public function cadd()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'add'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		$category_details['category_id']	=	'0';
		$category_details['lang_code']		=	$this->_session->lang_code;
		$this->_view->category_details		=	$category_details;
		
		print $this->_view->render('modules/gallery/cms/templates/category.add.tpl');
		exit();
	}
	
	public function cedit()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'edit'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isPostRequest())	{
			
			if($_POST['category_id'] == '0' || $_POST['category_id'] == '')	{
				$this->_gallery->addGalleryCategory($_POST);
			}	else {
				$this->_gallery->saveGalleryCategory($_POST);	
			}
			
			$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('cms#', 'cms', 'gallery', 'category', $this->_session->lang_code));
			exit();
		}

		$category_details = $this->_gallery->getCategoryDetails((int)$this->_router->getItemSegments(3));
		$this->_view->category_details 	= $category_details;
		
		print $this->_view->render('modules/gallery/cms/templates/category.edit.tpl');
		exit();
	}
	
	public function cdelete()	{
		
		if(	!$this->_acl->isAllowed($this->_auth->getIdentity()->role_code, $this->_engine->getModuleName(), 'delete'))	{
			$this->_acl->aclMessage($this->_auth->getIdentity()->user_id, __CLASS__, __METHOD__, 'brak uprawnień');
		}
		
		if($this->_router->isAjaxRequest())	{
			$this->_gallery->deleteGalleryCategory($_REQUEST);
		}
		
		exit();
	}

    
    function image_handler($source_image, $dirname, $quality = 80, $wmsource = false) {
        
        $info = getimagesize($source_image);
        $imgtype = image_type_to_mime_type($info[2]);

        switch ($imgtype) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($source_image);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($source_image);
                break;
            case 'image/png':
                $source = imagecreatefrompng($source_image);
                break;
            default:
                die('Invalid image type.');
        }

        $src_w = imagesx($source);
        $src_h = imagesy($source);
        $src_ratio = $src_h / $src_w;
        
        $extension = $this->getExtension($_FILES['filedata']['name']);
		$extension = strtolower($extension);
        
        $filename	=	pathinfo($_FILES['filedata']['name']);
        $basename	=	$this->_gallery->ToSlug($filename['filename']).'.'.$extension;
        $filename	=	date("His").$this->_gallery->ToSlug($filename['filename']).'.'.$extension;
        $postfix = '';
        $alias   = $filename;

        list($width, $height) = getimagesize($_FILES['filedata']['tmp_name']);
        $scale                =	$height / $width;

        $folders = explode(',', $this->_config->gallery->folders);
        foreach ($folders as $value) {                    
            $widthNew  = $this->_config->gallery->{$value}->width;
            $heightNew = $widthNew * $src_ratio;

            $final = imagecreatetruecolor($widthNew, $heightNew);            
            imagecopyresampled($final, $source, 0, 0, 0, 0, $widthNew, $heightNew, $src_w, $src_h);

            if ($wmsource) {
                $info = getimagesize($wmsource);
                $imgtype = image_type_to_mime_type($info[2]);

                #assuming the mime type is correct
                switch ($imgtype) {
                    case 'image/jpeg':
                        $watermark = imagecreatefromjpeg($wmsource);
                        break;
                    case 'image/gif':
                        $watermark = imagecreatefromgif($wmsource);
                        break;
                    case 'image/png':
                        $watermark = imagecreatefrompng($wmsource);
                        break;
                    default:
                        die('Invalid watermark type.');
                }

                $wm_w = imagesx($watermark);
                $wm_h = imagesy($watermark);

                $img_paste_x = 0;
                while($img_paste_x < $widthNew){
                    $img_paste_y = 0;
                    while($img_paste_y < $heightNew){
                        imagecopy($final, $watermark, $img_paste_x, $img_paste_y, 0, 0, $wm_w, $wm_h);
                        $img_paste_y += $wm_h;
                    }
                    $img_paste_x += $wm_w;
                }
            }
            $destination = $_SERVER['DOCUMENT_ROOT'].$this->_config->gallery->dir.$dirname.'/'.$value.'/'.$alias;
            if (!Imagejpeg($final, $destination, $quality)) {
                return false;
            }

			$image = new Imagick($final);
			$image->setProperty('Author', 'Izabela Habur');

			$image->writeImage ("test_0.jpg"); // fails with no error message
			//instead
			$image->setImageFormat ("jpeg");
			file_put_contents ("test_1.jpg", $image); // works, or:
			$image->imageWriteFile (fopen ("test_2.jpg", "wb")); //also works

        }
        
        return false;
    }

}
?>