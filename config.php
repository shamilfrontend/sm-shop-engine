<?php defined("_SMARTMEDIA") or die();

    define('HOST', 'localhost');
    define('USER', 'x93089h0_cake');
    define('PASS', 'x93089h0_cake');
    define('DB', 'x93089h0_cake');
    
	$config = [];
	$config["prefix"] = "yariko_"; //префикс таблиц в БД
	
	define('DR', __DIR__);
	define('DS', DIRECTORY_SEPARATOR);
	
	define('SALT', 'iGxE\4?mpM+zWewK.d');
	define('SECRET', '?N№Dz!52XMUrA~IIVW');
	define('UPLOAD_KEY', 'yhfv3241fa'); //UPLOAD_KEY should only containt (a-z A-Z 0-9 \ . _ -) characters
	define('GOOGLE_KEY', ''); //recaptcha key => GOOGLE_SECRET_KEY
	define('GOOGLE_HTML_KEY', ''); //recaptcha key
	
	define('SIZE', '1048576');
	define('MODEL', 'Alpha+');
	define('VERSION', '2.3.8');
   
	$config["theme"] = "/theme/"; //относительный путь до темы
	$config["settings_path"] = DR . DS . "library" . DS . "settings.json"; //настройки системы
	$config["modules_path"] = DR . DS . "library" . DS . "modules.json"; //модули системы
	$config["plugins_path"] = DR . DS . "library" . DS . "plugins.json"; //плагины системы
	$config["settings"] = []; //настройки системы
	
	$uLoginFields = "first_name,last_name,photo,photo_big,profile";
	
