<?php

/*
 * Bootstrap aplikacji CMS
 *
 * @author Adam Majchrzak
 * @author jusee.pl
 */
//error_reporting(E_ALL);
class Bootstrap
{
    private static $_instance = false;

    private $_cache;
    private $_config;
    private $_modules;
    private $_db;

    public static function instance()
    {
        if (self::$_instance === false) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct()
    {
        date_default_timezone_set('Europe/Warsaw');
        setlocale(LC_ALL, 'pl_PL');
        $this->dir = dirname(__FILE__).'/';

        set_include_path(get_include_path()
                        .PATH_SEPARATOR.$this->dir.'../library/'
                        .PATH_SEPARATOR.$this->dir.'../library/Smarty/'
                        .PATH_SEPARATOR.$this->dir.'../core/'
                        .PATH_SEPARATOR.$this->dir.'../core/helpers/'
                        .PATH_SEPARATOR.$this->dir.'../core/modules/'
                        );

        /*	ZEND AUTOLOADER	*/
        require_once 'Zend/Loader/Autoloader.php';

        $loader = Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true)->pushAutoloader(null, 'Smarty_');
        $loader->registerNamespace('ZendExt_');

        $this->_initCache();
        $this->_loadConfig();
        $this->_initSession();
        $this->_initCacheControl();
        $this->_initDatabase();
        $this->_initRouting();

        /* ładowanie aplikacji 	- parametry podstawowe [modul, akcja]	*/
        $this->_initEngine();
        $this->_closeDatabase();
    }

    private function _loadConfig()
    {
        $coreConfig = new Zend_Config_Xml($this->dir.'configs/core.xml', 'core', true);

        if ($coreConfig->mode == 'staging') {
            $config = new Zend_Config_Xml($this->dir.'configs/core.xml', $coreConfig->mode, true);
            $config->merge($coreConfig);
        } else {

            /*	załadowanie konfigiracji z cache'a	*/
            if (!$config = $this->_cache->load('config')) {
                $config = new Zend_Config_Xml($this->dir.'configs/core.xml', $coreConfig->mode, true);
                $config->merge($coreConfig);
                $this->_cache->save($config, 'config', array('config'));
            }
        }

        $this->_config = $config;
        $this->_config->serviceDir = substr(__FILE__, 0, strpos(__FILE__, 'core'.DIRECTORY_SEPARATOR.'Bootstrap.php'));

        Zend_Registry::set('config', $this->_config);
    }

    private function _initCache()
    {
        $frontendOptions = array('lifetime' => null, 'automatic_serialization' => true);
        $backendOptions = array('cache_dir' => $this->dir.'../var/cache/');

        $this->_cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
        Zend_Registry::set('cache', $this->_cache);
    }

    private function _initCacheControl()
    {
        if (isset($_GET['cache'])) {
            $session = new Zend_Session_Namespace('cacheTurnOff');
            if ($_GET['cache'] == 'cacheOff_12345') {
                $session->turnOff = true;
            } elseif ($_GET['cache'] == 'cacheOn_12345') {
                $session->turnOff = false;
            }
        }
    }

    private function _initSession()
    {
        Zend_Session::setOptions(array('name' => $this->_config->sessionName, 'cookie_path' => $this->_config->baseUrl));
        Zend_Session::start();
    }

    private function _initRouting()
    {
        Zend_Registry::set('router', new Engine_Router());
    }

    private function _initDatabase()
    {
        try {
            $this->_db = Zend_Db::factory($this->_config->database);
            Zend_Db_Table_Abstract::setDefaultAdapter($this->_db);
            /* do bazy danych bez domyślnego połączenia w trybie utf8	*/
            $this->_db->query('SET NAMES utf8');
        } catch (Exception $e) {
            if ($this->_config->mode == ' staging') {
                throw $e;
            } else {
                die($e);
            }
        }

        Zend_Registry::set('db', $this->_db);

        $cSelect = Engine_Db::instance();
        if ($this->_config->mode == 'staging') {
            $cSelect->setTimeout(0);
        }
    }

    private function _closeDatabase()
    {
        $this->_db->closeConnection();
    }

    private function _initEngine()
    {
        try {
            $this->engine = new Engine_Engine();
        } catch (Exception $e) {
            if (true || $this->_config->mode == 'staging') {
                die($e);
            } else {
                die('błąd w aplikacji, skontaktuj się z administratorem');
            }
        }
    }
}
