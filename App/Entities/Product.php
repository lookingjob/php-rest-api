<?php

namespace App\Entities {

	class Product extends \Core\Storage\DatabaseObject {
		
		public function __construct() {
			
			parent::__construct();
			
			$this->table = 'product';
		}
	} 
}

?>