<?php 
class GalleryModel extends Engine_Model {
	
	static 	$_instance = null;
	
	public function __construct()	{
		parent::__construct();
	}
	
	public static function Instance()	{
		
		if(!isset(GalleryModel::$_instance))	{
			GalleryModel::$_instance = new GalleryModel();
		}
		
		return GalleryModel::$_instance;
	}
	
	public function getGalleryList($lang_code = '', $_active = '')	{
		
		$select = $this->_db->select()
								->from(array('cg' => 'cms_gallery'))
								->order('_name')
								->order('_created DESC');
		
		if($lang_code != '')	{
			$select->where('cg.lang_code = ?', $lang_code);
		}
		
		if($_active == '1') {
			$select->where('cg._active = ?', (int)$_active);
		}
		
		$result = $this->_db->fetchAll($select);
		
		return $result;
	}
    
    
    public function getGalleryListForCategory($categoryId, $lang_code = '', $_active = '')	{
		
		$select = $this->_db->select()
								->from(array('cg' => 'cms_gallery'))
								->order('_name')
								->order('_created DESC');
		
		if($lang_code != '')	{
			$select->where('cg.lang_code = ?', $lang_code);
		}
		
		if($_active == '1') {
			$select->where('cg._active = ?', (int)$_active);
		}
		
        $select->where('cg.category_id = ?', (int)$categoryId);
        
		$result = $this->_db->fetchAll($select);
		
		return $result;
	}
	
	public function getGalleryDetails($gallery_id)	{
		
		$select	=	$this->_db->select()
										->from(array('cg' => 'cms_gallery'))
										->where('cg.gallery_id = ?', (int)$gallery_id);
		$result = $this->_db->fetchRow($select);
		
		return $result;
	}
    
    public function getGalleryDetailsByCode($code = '')	{
		
		$select	=	$this->_db->select()
										->from(array('cg' => 'cms_gallery'))
										->where('cg._code = ?', $code);
		$result = $this->_db->fetchRow($select);
		
		return $result;
	}
	
	public function getPictureDetails($picture_id)	{
		
		$select	=	$this->_db->select()
										->from(array('cgp' => 'cms_gallery_picture'))
										->where('cgp.picture_id = ?', (int)$picture_id);
		$result = $this->_db->fetchRow($select);
		
		return $result;
	}
	
	public function getPictureForGalleryList($gallery_id)	{
		
		$select	=	$this->_db->select()
										->from(array('cgp' => 'cms_gallery_picture'))
										->where('cgp.gallery_id = ?', (int)$gallery_id);
		$result = $this->_db->fetchAll($select);
		
		return $result;
	}
    
    public function getRandomPictureFromCategory($categoryId)	{
		
		$select = $this->_db->select()
                    ->from(array('cgp' => 'cms_gallery_picture'))
                    ->joinLeft(
                        array('cg' => 'cms_gallery'),
                        'cgp.gallery_id = cg.gallery_id',
                        array('category_id', '_code')
                    )
                    ->joinLeft(
                        array('cgc' => 'cms_gallery_category'),
                        'cgc.category_id = cg.category_id',
                        array('category_code' => '_code')
                    )
                    ->where('cg.category_id = ?', (int)$categoryId)
                    ->order('RAND()')
                    ->limit(20);
        $result = $this->_db->fetchAll($select);

        return $result;
	}
    
    public function getRandomPictureFromTags($code)	{
		
		print $select = $this->_db->select()
                    ->from(array('cgp' => 'cms_gallery_picture'))
                    ->joinLeft(
                        array('cgk' => 'cms_gallery_keyword'),
                        'cgp.gallery_id = cgk.gallery_id',
                        array('keyword_id')
                    )
                    ->joinLeft(
                        array('ck' => 'cms_keyword'),
                        'cgk.keyword_id = ck.keyword_id',
                        array('_keyword')
                    )
                    ->joinLeft(
                        array('cg' => 'cms_gallery'),
                        'cgp.gallery_id = cg.gallery_id',
                        array('category_id', '_code')
                    )
                    ->joinLeft(
                        array('cgc' => 'cms_gallery_category'),
                        'cgc.category_id = cg.category_id',
                        array('category_code' => '_code')
                    )
                    ->where('ck._keyword = ?', $code)
                    ->order('RAND()')
                    ->limit(20);
        $result = $this->_db->fetchAll($select);
print_r($result);
        return $result;
	}
    
    public function getGalleryCategoryList($lang_code = '', $_active = '')	{
		
		$select = $this->_db->select()
									->from(array('cgc' => 'cms_gallery_category'))
									->order('category_id');
		if($lang_code != '') {
			$select->where('cgc.lang_code = ?', $lang_code);
		}

		if($_active == '1') {
			$select->where('cgc._active = ?', (int)$_active);
		}
		
		$result = $this->_db->fetchAll($select);
		
		return $result;
	}
	
	public function getCategoryDetails($category_id) {
		
		$select = $this->_db->select()
									->from(array('cgc' => 'cms_gallery_category'))
									->where('category_id = ?', (int)$category_id);
		$result = $this->_db->fetchRow($select);
		return $result;
	}
    
    public function getCategoryDetailsByCode($code) {
		
		$select = $this->_db->select()
									->from(array('cgc' => 'cms_gallery_category'))
									->where('_code = ?', $code);
		$result = $this->_db->fetchRow($select);
		return $result;
	}
	
	public static function ToSlug($string, $maxLength=255, $separator='_') {
		
		$url = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
		$url = preg_replace('/[^a-zA-Z0-9 -]/', '', $url);
		$url = trim(substr(strtolower($url), 0, $maxLength));
		//$url = preg_replace('/[' . $separator . ']+/', $separator, $url);
		$url = preg_replace('/\s+/', $separator, $url);
		return $url;
	}
	
	public function activeGallery($data) {
		
		$gallery = $this->getGalleryDetails($data['gallery_id']);
		
		$gallery['_active'] == '1' ? $active = '0' : $active = '1'; 
		
		$update = array(
				"_active"	=>	$active,
				"_changed"	=>	date("Y-m-d H:i:s")
		);
		
		$this->_db->update("cms_gallery", $update, "gallery_id = '".(int)$data['gallery_id']."'");
		return true;
	}
	
	public function addGalleryDetails($data)	{
		
		$insert	= array(
            'category_id' 		=>	$data['category_id'],
			'lang_code'			=>	$data['lang_code'],
            '_code' 			=>	$this->ToSlug($data['_name']),
			'_name' 			=>	$data['_name'],
			'_description'		=>	$data['_description'],
            '_link' 			=>	$data['_link'],
			'_active'			=>	(int)$data['_active'],
			'_created'			=>	date("Y-m-d H:i:s"),
			'_changed'			=>	date("Y-m-d H:i:s")	
		);
		
		$this->_db->insert('cms_gallery', $insert);
		
		return $this->_db->lastInsertId();
	}
	
	public function saveGalleryDetails($data)	{
		
		$update	= array(
            'category_id'  => $data['category_id'],
            '_code' 	   => $this->ToSlug($data['_name']),
			'_name' 	   => $data['_name'],
			'_description' => $data['_description'],
            '_link' 	   => $data['_link'],
			'_active'	   => (int)$data['_active'],
			'_changed'	   => date("Y-m-d H:i:s")	
		);
		
		$this->_db->update("cms_gallery", $update, "gallery_id = '".(int)$data['gallery_id']."'");
		
		return true;
	}
	
	public function deleteGallery($data)	{
		
		$this->_db->delete("cms_gallery", "gallery_id = '".(int)$data['gallery_id']."'");
		
		$pics = $this->getPictureForGalleryList((int)$data['gallery_id']);
		foreach ($pics as $key => $value) {
			$this->deletePicture($value['picture_id']);
		}

		return true;
	}
	
	public function addPictureToGallery($data)	{
		
		$insert	= array(
			'gallery_id'			=>	$data['gallery_id'],
			'picture_name'			=>	$data['file_basename'],
			'file_name'				=>	$data['file_name'],
			'file_basename'			=>	$data['file_basename'],
			'file_dir'				=>	$this->_config->gallery->dir.str_pad((int)$data['gallery_id'],4,'0',STR_PAD_LEFT),
			'_created'				=>	date("Y-m-d H:i:s"),
			'_changed'				=>	date("Y-m-d H:i:s")
		);
		
		$this->_db->insert('cms_gallery_picture', $insert);
		
		return true;
	}

	public function savePictureDetails($data)	{
		
		$update	= array(
			'picture_name' 			=>	$data['picture_name'],
			'picture_description'	=>	$data['picture_description'],
            'istock_link'           =>	$data['istock_link'],
			'_changed'				=>	date("Y-m-d H:i:s")	
		);
		
		$this->_db->update("cms_gallery_picture", $update, "picture_id = '".(int)$data['picture_id']."'");
		
		return true;
	}
	
	public function deletePicture($picture_id)	{
			
		$select	=	$this->_db->select()
										->from(array('cgp' => 'cms_gallery_picture'))
										->where('cgp.picture_id = ?', (int)$picture_id);
		$result = $this->_db->fetchRow($select);	
		$folders = explode(',', $this->_config->gallery->folders);
        foreach ($folders as $value) {
            unlink($_SERVER['DOCUMENT_ROOT'].$result['file_dir'].'/'.$value.'/'.$result['file_name']);
        }	
		$this->_db->delete("cms_gallery_picture", "picture_id = '".(int)$picture_id."'");

		return true;
	}
    
    public function getKeywordsForGallery($galleryId)
    {
        $select	=	$this->_db->select()
										->from(array('cgk' => 'cms_gallery_keyword'))
                                        ->joinLeft(
                                            array('ck' => 'cms_keyword'),
                                            'ck.keyword_id = cgk.keyword_id',
                                            array('_keyword')    
                                        )
                                        ->where('cgk.gallery_id = ?', (int)$galleryId)
										->order('_keyword');
        $result = $this->_db->fetchAll($select);
		return $result;
    }
    
    public function getKeywordsFullList()
    {
        $select	=	$this->_db->select()
										->from(array('ck' => 'cms_keyword'))
										->order('_keyword');
        $result = $this->_db->fetchAll($select);
		return $result;
    }
    
    public function isKeywordExist($keyword)
    {
        $select	=	$this->_db->select()
										->from(array('ck' => 'cms_keyword'))
										->where('_keyword = ?',$keyword);
        $result = $this->_db->fetchRow($select);
		return $result;
    }
    
    public function saveKeyword($keyword)
    {
        $insert = array(
			"_keyword" => $keyword
		);
		
		$this->_db->insert("cms_keyword", $insert);
		
		return $this->_db->lastInsertId();
    }
    
    
    public function saveKeywordForGallery($data)
    {
        $insert = array(
			"gallery_id" =>	$data['gallery_id'],
            "keyword_id" =>	$data['keyword_id'],
		);
		
		$this->_db->insert("cms_gallery_keyword", $insert);
        
        return true;
    }
    
    public function deleteKeywordFromGallery($galleryId)
    {
        $this->_db->delete("cms_gallery_keyword", "gallery_id = '".(int)$galleryId."'");
        
        return true;
    }
    
    
    public function activeGalleryCategory($data) {
		
		$category = $this->getCategoryDetails($data['category_id']);
		
		$category['_active'] == '1' ? $active = '0' : $active = '1'; 
		
		$update = array(
				"_active"	=>	$active,
				"_changed"	=>	date("Y-m-d H:i:s")
		);
		
		$this->_db->update("cms_gallery_category", $update, "category_id = '".(int)$data['category_id']."'");
		return true;
	}
	
	public function addGalleryCategory($data) {
		
		$insert = array(
				"lang_code"			=>	$data['lang_code'],
				"_name"				=>	$data['_name'],
				"_code"				=>	$this->ToSlug($data['_name']),
				"_description"		=>	$data['_description'],
				"_active"			=>	@(int)$data['_active'],
				"_created"			=>	date("Y-m-d H:i:s"),
		);
		
		$this->_db->insert("cms_gallery_category", $insert);
		
		return true;
	}
	
	public function saveGalleryCategory($data) {
		
		$update = array(
				"lang_code"			=>	$data['lang_code'],
				"_name"				=>	$data['_name'],
				"_code"				=>	$this->ToSlug($data['_name']),
				"_description"		=>	$data['_description'],
				"_active"			=>	@(int)$data['_active'],
				"_changed"			=>	date("Y-m-d H:i:s")
		);
		
		$this->_db->update("cms_gallery_category", $update, "category_id='".(int)$data['category_id']."'");
		
		return true;
	}
	
	public function deleteGalleryCategory($data)	{
		
		$this->_db->delete("cms_gallery_category", "category_id = '".(int)$data['category_id']."'");

		return true;
	}
}
?>