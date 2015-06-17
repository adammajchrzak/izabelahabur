<?php 

/*
 * Engine Engine
 * 
 * @author Adam Majchrzak
 * @author jusee.pl
 */

class Engine_Engine	{
	
	/**
	 * połączenie z bazą danych
	 * @var object
	 */
	private $_db;
	
	/**
	 * konfiguracja
	 * @var object
	 */
	private $_config;
	
	/**
	 * routing
	 * @var object
	 */
	private $_router;
	
	/**
	 * tablica modułów - katalogi /core/modules
	 * @var array
	 */
	private $_modules = array();
	
	/**
	 * tablica modułów niechronionych - kontrola na poziomie katalogów
	 * @var array
	 */
	private $_unprotected_modules = array();
	
	/**
	 * tablica danych wywołania
	 * @var array
	 */
	private $_requestParams = array();
	
	/**
	 * tablica nagłówków 
	 * @var array
	 */
	private $_headers = array();
	
	/**
	 * aktualnie wybrany moduł
	 * @var string
	 */
	private $_module;
	
	/**
	 * aktualnie wybrany kontroler
	 * @var string
	 */
	private $_controller;
	
	/**
	 * aktualnie wybrana akcja
	 * @var string
	 */
	private $_action;
	
	/**
	 * aktualnie wybrana wersja językowa
	 * @var string
	 */
	
	private $_current_locale;
	
	/**
	 * widok
	 * @var object
	 */
	private $_view;
	
	private $_function;
	
	public function __construct()	{
		
		$this->_config		= Zend_Registry::get('config');
		$this->_router 		= Zend_Registry::get('router');
		$this->_db 			= Zend_Registry::get('db');
		$this->_function	= Functions::Instance();
		
		$this->_router->accepted_locale = $this->_function->flattenArray($this->_function->getSiteLocaleList(),'lang_code');
		
		$this->_getModulesDirs();		
		$this->_getRequestParams();
	}
	
	private function _getModulesDirs()	{
		
		/*	zczytanie katalogu /core/modules */
		foreach(new DirectoryIterator($this->_config->serviceDir."core/modules") as $fileInfo)	{
			if($fileInfo->isDot()) continue;
			if($fileInfo->isDir())	{
				$this->_modules[$fileInfo->getFilename()] = 1;
				set_include_path(get_include_path() 
						. PATH_SEPARATOR . $this->_config->serviceDir.'core/modules/'.$fileInfo->getFilename()
						);
			}
		}
		
		if(!count($this->_modules))	{
			$this->addHttpHeader('404', true, false);
			$this->_templateFile = 'error404';
			$this->_render('static');
			exit;
		}
	} 
	
	private function _getRequestParams()	{
		
		/**
		 * początkowo 0=>4, dodano 0=>5 do obsługi kodu wersji językowej
		 */
		
		for($i = 0; $i < 5; $i++)	{
			$this->_requestParams[] = $this->_router->getItemSegments($i);
		}
		
		if($this->_requestParams[0] == '')	{
			
			$module_type = 'site';
			$module = $controller = $action =  'index';
			
		}	else	{

			if(isset($this->_requestParams[0]) && $this->_requestParams[0] == 'cms')	{
				
				$module_type = 'cms';
				$this->_requestParams = array_slice($this->_requestParams,1);
				
				if($this->_requestParams[0] == '')	{
					$module = $controller = $action =  'index';
				}	else	{
					if(isset($this->_modules[$this->_requestParams[0]]) && $this->_modules[$this->_requestParams[0]] == 1)	{
						$module	= $controller = $this->_requestParams[0];
						$action = $this->_requestParams[1];
					}	else	{
						$module = $controller = $action =  'index';
						die('brak takiego modułu administracyjnego, skontaktuj się z administratorem!');
					}
				}
				
			}	else {
				
				if(isset($this->_modules[$this->_requestParams[0]]) && $this->_modules[$this->_requestParams[0]] == 1)	{
		
					$module_type = 'site';
					$module	= $controller = $this->_requestParams[0];
					$action = $this->_requestParams[1];
					
				}	else	{
					
					$module_type = 'site';
					$module = $controller = $action =  'index';
					die('brak takiego modułu, skontaktuj się z administratorem!');
				}
				
				/*	
				if($this->_config->multi_locale == '0')	{	
				}	else {
					
					if(isset($this->_modules[$this->_requestParams[0]]) && $this->_modules[$this->_requestParams[0]] == 1)	{
			
						$module_type = 'site';
						$module	= $controller = $this->_requestParams[0];
						$action = $this->_requestParams[1];
						
					}	else	{
						
						$module_type = 'site';
						$module = $controller = $action =  'index';
						die('brak takiego modułu, skontaktuj się z administratorem!');
					}
				}
				*/
			}
			
			
			
			/*	elseif(isset($this->_modules[$this->_requestParams[0]]) && $this->_modules[$this->_requestParams[0]] == 1)	{
			
				$module_type = 'site';
				$module	= $controller = $this->_requestParams[0];
				$action = $this->_requestParams[1];
				
			}	else	{
				
				$module_type = 'site';
				$module = $controller = $action =  'index';
				die('brak takiego modułu, skontaktuj się z administratorem!');
			}
			*/ 
		}
		
		$this->_module 			= $module;
		$this->_module_type 	= $module_type;
		$this->_controller 		= $controller;
		$this->_action 			= $action;
		
		set_include_path(get_include_path() . PATH_SEPARATOR . $this->_config->serviceDir . 'core/modules/' . $this -> _module);
		
		$this->_config->module     		= $this->_module;
		$this->_config->module_type 	= $this->_module_type;
		$this->_config->controller 		= $this->_controller;
		$this->_config->action     		= $this->_action;

		Zend_Registry::set('config', $this->_config);
		
		$this -> _initView();
		
		$params = array(
					"module_type" 	=>	$this->_module_type,
					"module" 		=>	$this->_module, 
					"controller" 	=>	$this->_controller,
					"action"		=>	$this->_action,
					"locale"		=>	$this->_current_locale);
		
		//$this->_templateFile   = $this->_module_type.'_'.$this->_controller;
		$this->_templateFile   = $this->_module_type.'_default';
		$this->_loadAction($params);
	}
	
	private function _loadAction($params)	{
		
		$this->_loadController($params);
		$this->_view->content = $this->_view->render('modules/' . $params['module'] . '/'.$params['module_type'].'/templates/'.$this->_toRender);
		$this->_renderView();
	}
	
	private function _loadController($params)	{
		
		
		$module_type 	= $params['module_type'];
		$module 		= $params['module'];
		$controller 	= $params['controller']."Controller";
		$action			= $params['action'];
		
		/*	plik kontrolera	*/
		$controller_file   = $this->_config->serviceDir . 'core/modules/' . $module . '/'.$module_type.'/Controller.php';
		
		if(is_file($controller_file))	{
			
			include_once $controller_file;
			
			if(class_exists($controller, FALSE))	{
				
				Zend_Registry::set('engine', $this);
			    $controller = new $controller($this);
			    
			    /*	podana akcja	*/
				if($action != '' && method_exists($controller, $action) && call_user_func(array($controller, $action)) !== FALSE)	{
					return true;
								
				}	else	{
					
					/* akcja domyslna	*/
					if(method_exists($controller, 'index') && call_user_func(array($controller, 'index')) !== FALSE)	{
						return true;
					}	else	{
						die("Klasa $controller nie zawiera żądanej akcji");
			    		return false;					
					}
				}
			    
			}	else	{
				
				die("Klasa kontrolera $controller nie istnieje");
		    	return false;
			}
			
		}	else	{
			
			die("Plik $controller_file nie istnieje");
		    return false;
		}
		
	}
	
	private function _initView( ){
		
		$this->_view = new Engine_View();
		Zend_Registry::set('view', $this->_view); 	
	}
	
	private function _renderView($baseDir = 'views', $writeLog = false)	{

		foreach($this->_headers  as $header)	{
			header($header);
		}		
		
		switch ($baseDir) {
			case 'views':
				$prefix = 'views_';
				break;
			case 'static':
				$prefix = 'static_';
				break;	
			case 'boxes':
				$prefix = 'box_';
				break;
			case 'content':
				$prefix = 'content_';
				break;		
		}
		
		if ($this->_templateFile != '') {
			echo $this->_view->render ("templates/".$baseDir . '/' . $this -> _templateFile . '.tpl');
		}
	}
	
	/*
	private function _renderView($baseDir = 'views', $writeLog = false)	{

		foreach($this->_headers  as $header)	{
			header($header);
		}		
		
		switch ($baseDir) {
			case 'views':
				$prefix = 'views_';
				break;
			case 'static':
				$prefix = 'static_';
				break;	
			case 'boxes':
				$prefix = 'box_';
				break;
			case 'content':
				$prefix = 'content_';
				break;		
		}
		
		if ($this->_templateFile != '') {
			echo $this->_view->render ("templates/".$baseDir . '/' . $prefix . $this -> _templateFile . '.tpl');
		}
	}
	*/
	
	public function setToRender($name)	{
		$this->_toRender = $name;
	}
	
	public function unsetToRender()	{
		$this->_toRender = '';
	}
	
	public function addHttpHeader($header, $forceOutput = true, $redirect = true)	{
		
		switch ($header) {
			case 'json':
				$header = 'Content-type: application/json';
				break;
			case 'xml':
				$header = 'Content-Type: text/xml; charset=utf-8';
				break;
			case 'gif':
				$header = 'Content-Type: image/gif';
				break;
			case 'jpg':
				$header = 'Content-Type: image/jpeg';
				break;
			case 'png':
				$header = 'Content-Type: image/png';
				break;	
			case '200':
				$header = 'HTTP/1.1 200 OK';
				break;	
			case '301':
				$header = 'HTTP/1.1 301 Moved Permanently';
				break;	
			case '401':
				$header = 'HTTP/1.1 401 Unauthorized';
				break;
			case '403':
				$header = 'HTTP/1.1 403 Forbidden';
				break;	
			case '404':
				$header = 'HTTP/1.1 404 Not Found';
				break;	
			case '500':
				$header = 'HTTP/1.1 500 Internal Server Error';
				break;
		}
		
		if(is_string($header))
			array_push($this->_headers, $header);
		if ($forceOutput) {
			foreach ($this->_headers as $header) {
				header($header);
			}
			$this->clearHttpHeaders();
		}
		if ($redirect)
			exit;
	}

	public function clearHttpHeaders()	{
		
		$this->_headers = array();
	}
	
	public function getModuleName()	{
		return $this->_module;
	}
	
	public function getControllerName()	{
		return $this->_controller;
	}

	public function getActionName()	{
		return $this->_action;
	}
}

?>