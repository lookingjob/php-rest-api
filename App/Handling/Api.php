<?php

use Core\Http\Request;
use Core\Http\Response;
use Core\Storage\Config as Config;
use Core\Storage\Database as Database;
use App\Handling\Api as Api;

$response = new Request();
$response = new Response();

if ($request->method != 'POST') {
	$response->setStatus(405);
	$response->send();
	exit();
} 

$config = Config::getInstance();
$config->load('App/config.php');

$api_settings = $config->get('api');
 if ($request->post['auth_key'] != $api_settings['auth_key']) {
	$response->setStatus(401);
	$response->send();
	exit();
}






use App\Handling\Dispatcher as Dispatcher;
$dispatcher = new Dispatcher($request->url);
$dispatcher->execute();



use App\Entities\Member as Member;
use App\Entities\Occupation as Occupation;

 


$response = new Response('application/json', 200, )

$product = new Product();
/*$product->insert(array(
	'name' => 'test 1',
	'description' => 'test 11',
	'price' => 111,
));*/
/*$productRow = $product->select(array(
	'where' => array(
		'id' => 3,
	)
));*/

$productCategory = new ProductCategory();
$productRows = $product->select(array(
	'where' => array(
		'id' => $productCategory->getProductsByCategory(3),
	)
));

$category = new Category();

echo'<pre>';var_dump($category);echo'</pre>';die('stop2');
?>