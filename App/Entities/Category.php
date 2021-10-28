<?php

use \Core\Storage;

namespace App\Entities {
     
	class Category extends \Core\Storage\DatabaseObject {
		
		public function __construct() {
			
			parent::__construct();
			
			$this->table = 'category';
		}
	} 
}