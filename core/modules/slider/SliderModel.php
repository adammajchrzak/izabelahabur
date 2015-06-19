<?php 
class SliderModel extends Engine_Model {
	
	static $_instance = null;
	
	public function __construct()	{
		parent::__construct();
	}
	
	public static function Instance()	{
		
		if(!isset(SliderModel::$_instance))	{
			SliderModel::$_instance = new SliderModel();
		}
		
		return SliderModel::$_instance;
	}
	
	public function getSliderList($lang_code = '', $_active = '')	{
		
		$select = $this->_db->select()
								->from(array('cs' => 'cms_slider'))
								->order('_order');
		
		if($lang_code != '')	{
			$select->where('cs.lang_code = ?', $lang_code);
		}
		
		if($_active == '1') {
			$select->where('cs._active = ?', (int)$_active);
		}
		
		$result = $this->_db->fetchAll($select);
		
		return $result;
	}

	
	public function getItemDetails($item_id)
    {	
		$select = $this->_db->select()
									->from(array('cs' => 'cms_slider'))
									->where('slider_id = ?', (int)$item_id);
		$result = $this->_db->fetchRow($select);
		return $result;
	}
	
	public static function ToSlug($string, $maxLength=255, $separator='_')
    {	
		$url = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
		$url = preg_replace('/[^a-zA-Z0-9 -]/', '', $url);
		$url = trim(substr(strtolower($url), 0, $maxLength));
		$url = preg_replace('/\s+/', $separator, $url);
		return $url;
	}
	
	public function activeSlider($data)
    {	
		$item = $this->getItemDetails($data['slider_id']);
		
		$item['_active'] == '1' ? $active = '0' : $active = '1'; 
		
		$update = array(
				"_active"	=>	$active,
				"_changed"	=>	date("Y-m-d H:i:s")
		);
		
		$this->_db->update("cms_slider", $update, "slider_id = '".(int)$data['slider_id']."'");
		return true;
	}
    
    
    public function moveSliderInStructure($data)
    {
		$select = $this->_db->select()
                ->from(array('cs' => 'cms_slider'))
                ->order('cs._order');
        
		$result = $this->_db->fetchAll($select);
		$y = '0';
		
		$beforePage	= array();
		$afterPage	= array();
		
		foreach ($result as $key=>$value)	{
			if($result[$key]['slider_id'] == $data['item_id'])	{
				$y = 1;
			}	elseif ($y == '0')	{
				array_push($beforePage, $result[$key]['slider_id']);
			}	else {
				array_push($afterPage, $result[$key]['slider_id']);
			}
		}
		
		if($data['direction'] == 'UP')	{
			array_unshift($afterPage, array_pop($beforePage));
		}	else {
			array_push($beforePage, array_shift($afterPage));
		}
		
		array_push($beforePage, $data['item_id']);
		$pagesList = array_merge($beforePage, $afterPage);
		
		$_order = 10;
		foreach ($pagesList as $key=>$value)	{
			
			$this->_db->update("cms_slider", array('_order' => $_order, '_changed' => date('Y-m-d H:i:s')), "slider_id='".$value."'");
			$_order += 10; 
		}
		
		return true;
    }
	
	public function addItemDetails($data)
    {	
		$insert	= array(
			'lang_code'		=>	$data['lang_code'],
			'_name' 		=>	$data['_name'],
			'_description'	=>	$data['_description'],
            '_file'         =>	$data['_file'],
            '_link'         =>	$data['_link'],
			'_active'		=>	(int)$data['_active'],
			'_created'		=>	date("Y-m-d H:i:s"),
			'_changed'		=>	date("Y-m-d H:i:s")	
		);
		
		$this->_db->insert('cms_slider', $insert);
		
		return $this->_db->lastInsertId();
	}
	
	public function saveItemDetails($data)
    {	
		$update	= array(
			'_name' 	   => $data['_name'],
			'_description' => $data['_description'],
            '_link'        =>	$data['_link'],
			'_active'	   => (int)$data['_active'],
			'_changed'	   => date("Y-m-d H:i:s")	
		);
		
		$this->_db->update("cms_slider", $update, "slider_id = '".(int)$data['slider_id']."'");
		
		return true;
	}
	
	public function deleteSlider($data)
    {	
        $item = $this->getItemDetails((int)$data['slider_id']);
        unlink($_SERVER['DOCUMENT_ROOT'].$this->_config->slider->folder.$item['_file']);
        
		$this->_db->delete("cms_slider", "slider_id = '".(int)$data['slider_id']."'");

		return true;
	}
	
}
