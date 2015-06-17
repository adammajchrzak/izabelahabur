<?php 

/*
 * priceController
 * 
 * @author Adam Majchrzak
 * @jusee.pl
 */

 
class priceController extends Engine_Controller	{
	
	public function __construct($engine)	{
		
		parent::__construct($engine);
		
		$this->_cms 	= IndexModel::Instance();
		$this->_price	= PriceModel::Instance();
		
		$this->_head->addStyleFile('reset.css',			'screen',		true, '/css/');
		$this->_head->addStyleFile('style.css',			'screen',		true, '/css/');
	
                $this->_head->addScriptFile('4cookiesmulti.js',                 true, '/js/');
		$this->_head->addScriptFile('cufon-yui.js',			true, '/js/');
		$this->_head->addScriptFile('Helvetica_Neue_Light.font.js', 	true, '/js/');
		$this->_head->addScriptFile('Helvetica_Neue_Bold.font.js', 	true, '/js/');
		$this->_head->addScriptFile('kukuczki7.js', 			true, '/js/');
		$this->_head->addScriptFile('jquery.maphilight.js', 		true, '/js/');
		
		$this->_head->title 		= $this->_config->meta_data->title;
		$this->_head->keywords 		= $this->_config->meta_data->keywords;
		$this->_head->description	= $this->_config->meta_data->description;
		$this->_head->metascripts	= '';
	}
	
	public function index()	{
		
		if($this->_router->isPostRequest())	{
			$this->_session->search['floorId']	=	(int)$_POST['floorId'];
			$this->_session->search['roomId']	=	(int)$_POST['roomId'];
			
			// określenie powierzchni lokalu
			
			switch((int)$_POST['areaId']) {
				case "0":
					$this->_session->search['areaId']	=	'0';
					break;
				case "1":
					$this->_session->search['areaId']	=	'20';
					break;
				case "2":
					$this->_session->search['areaId']	=	'30';
					break;
				case "3":
					$this->_session->search['areaId']	=	'40';
					break;				
				case "4":
					$this->_session->search['areaId']	=	'50';
					break;
				case "5":
					$this->_session->search['areaId']	=	'60';
					break;
				case "6":
					$this->_session->search['areaId']	=	'70';
					break;	
			}

			$this->_engine->addHttpHeader("Location: /".$this->_router->getUrl('price'));
			exit();
		}
		
		$this->_view->search		=	$this->_session->search;
		$parent_page				=	$this->_cms->getPageRoot('2', $this->_config->current_locale);
		$this->_view->parent_page	=	$parent_page;
		$this->_view->breadcrumb	=	$this->_cms->getPageBreadcrumb('13', $this->_config->current_locale);	
		
		$this->_view->locales_list	=	$this->_price->getLocalesList($this->_session->search);
		
		$this->_engine->setToRender('index.tpl');
	}
	
	public function floor()	{
            $this->_session->search = array();

            $this->_session->search['floorId'] = '1';

            if(is_numeric($this->_router->getItemSegments(2))){
                $this->_session->search['floorId'] = (int)$this->_router->getItemSegments(2);
            }	

            $prev = $this->_session->search['floorId'] - 1;
            $next = $this->_session->search['floorId'] + 1;

            if($this->_session->search['floorId'] == '0') {
                $prev = '0';
            }

            if($this->_session->search['floorId'] == '5') {
                $next = '5';
            }

            $this->_view->prev_floor	=	$prev;
            $this->_view->next_floor	=	$next;

            $this->_view->locales_list	=	$this->_price->getLocalesList($this->_session->search);	
            $this->_view->floor		=	$this->_session->search['floorId'];
            $this->_engine->setToRender('floor.tpl');
	}
	
    public function local(){
        if(is_numeric($this->_router->getItemSegments(2))){
            $_id = (int)$this->_router->getItemSegments(2);
        }

        $item           =   $this->_price->getLocalDetailsByIndex($_id);
        $locales_list   =   $this->_price->getLocalesList(array('floorId' => $item['_floor']));
        $locales_list   =   $this->_function->flattenArray($locales_list, '_index');
        $pn             =   $this->_function->getPNArray($locales_list, $item['_index']);
        $this->_view->pn_local  =   $pn;
        $this->_view->item      =   $item;
        $rooms                  =   $this->_price->getLocalRooms($item['item_id']);
        $this->_view->rooms     =   $rooms;

        if($this->_router->isAjaxRequest()){
            $this->_engine->_templateFile = '';
            $this->_engine->unsetToRender();
            $array = array_merge($rooms, $item);
            echo json_encode($array);
        }
        else{
            $this->_engine->setToRender('local.tpl');
        }
    }
}
?>