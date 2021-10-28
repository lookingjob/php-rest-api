<?php

namespace App\Handling {

	class Controller {
		
		protected $request;
		protected $response;
		
		public function __construct() {
			
			$this->request = new \Core\Http\Request();				
			$this->response = new \Core\Http\Response();				
		}		
	}	
}

?>