<?php

define('BASE_PATH', realpath(dirname(__FILE__)));

function autoloader($classname) {
	
    $filename = BASE_PATH . '/' . str_replace('\\', '/', $classname) . '.php';
    if (!file_exists($filename)) {
		throw new Exception(sprintf('Class %s not found, path %s', $classname, $filename));
    }    
    require_once($filename);
}
spl_autoload_register('autoloader');

require('App/api.php');                                

?>