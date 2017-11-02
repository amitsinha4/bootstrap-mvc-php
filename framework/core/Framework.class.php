<?php

class Framework
{

    // Bootstrap function to kick-start things
    public static function run()
    {
        
        // Intitalization of three function which is the basis of a framework
        self::init();
        self::autoload();
        self::dispatch();
    }

    private static function init()
    {
        define("HOST", $_SERVER['HTTP_HOST']);
        
        define("DS", DIRECTORY_SEPARATOR);
        
        define("ROOT", getcwd() . DS);
        
        define("APP_PATH", ROOT . 'application' . DS);
        
        define("FRAMEWORK_PATH", ROOT . "framework" . DS);
        
        define("PUBLIC_PATH", ROOT . "public" . DS);
        
        define("CONFIG_PATH", APP_PATH . "config" . DS);
        
        define("CONTROLLER_PATH", APP_PATH . "controllers" . DS);
        
        define("MODEL_PATH", APP_PATH . "models" . DS);
        
        define("VIEW_PATH", APP_PATH . "views" . DS);
        
        define("CORE_PATH", FRAMEWORK_PATH . "core" . DS);
        
        define('DB_PATH', FRAMEWORK_PATH . "database" . DS);
        
        define("LIB_PATH", FRAMEWORK_PATH . "libraries" . DS);
        
        define("HELPER_PATH", FRAMEWORK_PATH . "helpers" . DS);
        
        define("UPLOAD_PATH", PUBLIC_PATH . "uploads" . DS);
        
        define("PLATFORM", isset($_REQUEST['p']) ? $_REQUEST['p'] : 'home');
        
        define("CONTROLLER", isset($_REQUEST['c']) ? $_REQUEST['c'] : 'Index');
        
        define("ACTION", isset($_REQUEST['a']) ? $_REQUEST['a'] : 'index');
        
        define("CURR_CONTROLLER_PATH", CONTROLLER_PATH . PLATFORM . DS);
        
        define("CURR_VIEW_PATH", VIEW_PATH . PLATFORM . DS);
        
        // Load core classes
        
        require CORE_PATH . "Controller.class.php";
        
        require CORE_PATH . "Loader.class.php";
        
        require DB_PATH . "Mysql.class.php";
        
        require CORE_PATH . "Model.class.php";
        
        // Load configuration file
        
        $GLOBALS['config'] = include CONFIG_PATH . "config.php";
        
        // Start session
        
        session_start();
    }

    private static function autoload()
    {
        spl_autoload_register(array(
            __CLASS__,
            'load'
        ));
    }

    private static function dispatch()
    {
        
        // Instantiate the controller class and call its action method
        $controller_name = CONTROLLER . "Controller";
        
        $action_name = ACTION . "Action";
        
        $controller = new $controller_name();
        
        $controller->$action_name();
    }

    private static function load($classname)
    {
        
        // Here simply autoload app’s controller and model classes
        if (substr($classname, - 10) == "Controller") {
            
            // Controller
            
            require_once CURR_CONTROLLER_PATH . "$classname.class.php";
        } elseif (substr($classname, - 5) == "Model") {
            
            // Model
            
            require_once MODEL_PATH . "$classname.class.php";
        }
    }
}
?>