<?php

use Core\Http\Request;
use Core\Http\Response;
use Core\Storage\Config as Config;
use Core\Storage\Database as Database;
use App\Handling\Dispatcher as Dispatcher;

$request = new Request();
$response = new Response();

if ($request->method != 'POST') {
	$response->sendJSON(['error' => 'Invalid query method']);
	exit();
}

$config = Config::getInstance();
$config->load('App/config.php');

$api_config = $config->get('api');
 if ($request->post('auth_key') != $api_config['auth_key']) {
	$response->sendJSON(['error' => 'Invalid API key']);
	exit();
} 

$db_config = $config->get('db');
$db = Database::getInstance();
$db->connect($db_config['driver'], $db_config['host'], $db_config['dbname'], $db_config['username'], $db_config['password']);
     
$dispatcher = new Dispatcher();
$dispatcher->execute();

?>