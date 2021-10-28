<?php

namespace App\Entities {

	class ProductCategory extends \Core\Storage\DatabaseObject {

		public function __construct() {
			
			parent::__construct();
			
			$this->table = 'product_category';
		}
		
		public function getProductsByCategory(int $category_id) {
			
			if (!$category_id) return false;
			
			$rows = $this->select(array(
				'where' => array(
					'category_id' => $category_id,
				)
			));	
			    
			$result = array();
			foreach($rows as $row) {
				$result[] = $row['product_id'];
			}
			
			return $result;
		}
		
		public function addProductToCategory(int $product_id, int $category_id) {
			
			if (!$product_id || !$category_id) return false;
			                           
			$result = $this->insert(array(
				'product_id' => $product_id,
				'category_id' => $category_id,
			));	

			return $result;
		}
	}
}