<?php

namespace Core\Http {

	class Request {
		
		public $ip;
		public $user_agent;
		public $method;
		public $url;
	    
		public function __construct() {
			
		    if (getenv('HTTP_X_FORWARDED_FOR')) {
				$this->ip = getenv('HTTP_X_FORWARDED_FOR');
			} elseif (getenv('REMOTE_ADDR')) {
				$this->ip = getenv('REMOTE_ADDR');
			}

			$this->user_agent = getenv('HTTP_USER_AGENT');
			$this->method = getenv('REQUEST_METHOD');
			$this->url = getenv('REQUEST_URI');    
		}	
		
		public function post($key, $default = null) {
			
			return isset($_POST[$key]) ? $_POST[$key] : $default;
		}	
		
		public function get($key, $default = null) {
			
			return isset($_GET[$key]) ? $_GET[$key] : $default;
		}    
	} 
}

?>