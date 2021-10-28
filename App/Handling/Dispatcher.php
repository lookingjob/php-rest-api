<?php

namespace App\Handling {

	class Dispatcher {

		private $path;
		private $query;
		private $target;
		private $action;

		public function __construct() {

			$request = new \Core\Http\Request();
			
			$this->target = $request->post('target');
			$this->action = $request->post('action');
			
			/*$parsed_url = parse_url(urldecode($url));    
	        $parsed_url['path'] = trim($parsed_url['path'], '/');
	        parse_str($parsed_url['query'], $this->query);
	                
			$this->target = !empty($this->query['target']) ? $this->query['target'] : false;
			if (!empty($this->query['action'])) {
				$this->action = $this->query['action'];
				unset($this->query['action']);
			}
			if (!empty($this->query['action'])) {
				$this->action = $this->query['action'];
				unset($this->query['action']);
			}
			
			$config = \Core\Storage\Config::getInstance();
			if (!empty($parsed_url['path'][0]) && $parsed_url['path'][0] == $config->get('path')) {
				array_shift($parsed_url['path']);
			} 
			$this->path = $parsed_url['path'];*/
		}
		
		public function execute() {
			
			try {
				$classname = sprintf('\App\Controllers\%sController', ucfirst($this->target));  
				$controller = new $classname;  
				if (method_exists($controller, $this->action)) {
					$controller->{$this->action}($this->query);	
				} else {
					throw new \Exception('Method not allowed');
				}
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}

}

?>