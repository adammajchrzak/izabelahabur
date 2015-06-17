<?php
/*	smarty w wersji 3.x 	*/				
require_once "../library/Smarty/Smarty.class.php";
 
/*
 * Engine View
 * rozszerzenie Zend_view, wykorzystanie Smarty
 * 
 * @author Adam Majchrzak
 * @author jusee.pl
 */

class Engine_View implements Zend_View_Interface	{
	
	/**
     * Smarty object
     * @var Smarty
     */
    public 	$_smarty;
	private $_config;
	private $_router;
	private $_auth;
	
    /**
     * Constructor
     *
     * @param string $tmplPath
     * @param array $extraParams
     * @return void
     */
    public function __construct($tmplPath = null, $extraParams = array()) {
        	
        $this->_smarty = new Smarty;
		
		$this->_config	= Zend_Registry::get('config');
		$this->_router 	= Zend_Registry::get('router');
		
		$templates_dir = $this->_config->serviceDir. "core";
		$this->_smarty->addPluginsDir($templates_dir.'/modules/calendar/site/smarty');
		
		$this->setScriptPath( $templates_dir );
		
		$this->_smarty->template_dir 	= $templates_dir;
		$this->_smarty->compile_dir 	= $this->_config->serviceDir . $this->_config->view->compile_dir;
		
		/*	 dostep do _router z poziomu szablonow	*/
		$this->_smarty->assign('router', $this->_router);
		$this->_smarty->assign('config', $this->_config);
		
        foreach ($extraParams as $key => $value) {
            $this->_smarty->$key = $value;
        }
		
		//$this->_smarty->registerPlugin("function","import_css", "import_css");
    }
	
	
	
	

    /**
     * Return the template engine object
     *
     * @return Smarty
     */
    public function getEngine()
    {
        return $this->_smarty;
    }

    /**
     * Set the path to the templates
     *
     * @param string $path The directory to set as the path.
     * @return void
     */
    public function setScriptPath($path)
    {
        if (is_readable($path)) {
            $this->_smarty->template_dir = $path;
            return;
        }

        throw new Exception('Invalid path provided');
    }

    /**
     * Retrieve the current template directory
     *
     * @return string
     */
    public function getScriptPaths()
    {
        return array($this->_smarty->template_dir);
    }

    /**
     * Alias for setScriptPath
     *
     * @param string $path
     * @param string $prefix Unused
     * @return void
     */
    public function setBasePath($path, $prefix = 'Zend_View')
    {
        return $this->setScriptPath($path);
    }

    /**
     * Alias for setScriptPath
     *
     * @param string $path
     * @param string $prefix Unused
     * @return void
     */
    public function addBasePath($path, $prefix = 'Zend_View')
    {
        return $this->setScriptPath($path);
    }

    /**
     * Assign a variable to the template
     *
     * @param string $key The variable name.
     * @param mixed $val The variable value.
     * @return void
     */
    public function __set($key, $val)
    {
        if($key == 'content') $key = 'CONTENT';	
        $this->_smarty->assign($key, $val);
    }

    public function setTemplateCompilePath($path)
    {
        $this->_smarty->compile_dir = $path;
    }

    public function setTemplateCompileID($id)
    {
        $this->_smarty->compile_id = $id;
    }

    /**
     * Allows testing with empty() and isset() to work
     *
     * @param string $key
     * @return boolean
     */
    public function __isset($key)
    {
        return (null !== $this->_smarty->get_template_vars($key));
    }

    /**
     * Allows unset() on object properties to work
     *
     * @param string $key
     * @return void
     */
    public function __unset($key)
    {
        $this->_smarty->clear_assign($key);
    }

    public function getTemplateVars($var = NULL) {
        return $this->_smarty->get_template_vars($var);
    }

    /**
     * Assign variables to the template
     *
     * Allows setting a specific key to the specified value, OR passing
     * an array of key => value pairs to set en masse.
     *
     * @see __set()
     * @param string|array $spec The assignment strategy to use (key or
     * array of key => value pairs)
     * @param mixed $value (Optional) If assigning a named variable,
     * use this as the value.
     * @return void
     */
    public function assign($spec, $value = null)
    {
        if (is_array($spec)) {
            $this->_smarty->assign($spec);
            return;
        }

        $this->_smarty->assign($spec, $value);
    }

    public function append($spec, $value = NULL) {
        if (is_array($spec)) {
            $this->_smarty->append($spec);
            return;
        }

        $this->_smarty->append($spec, $value);
    }

    /**
     * Clear all assigned variables
     *
     * Clears all variables assigned to Zend_View either via
     * {@link assign()} or property overloading
     * ({@link __get()}/{@link __set()}).
     *
     * @return void
     */
    public function clearVars()
    {
        $this->_smarty->clear_all_assign();
    }

    /**
     * Processes a template and returns the output.
     *
     * @param string $name The template to process.
     * @return string The output.
     */
    public function render($name) {
        return $this->_smarty->fetch($name);
    }
}

?>