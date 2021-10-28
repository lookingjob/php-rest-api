<?php

namespace App\Controllers {

	class ProductController extends \App\Handling\Controller {

		public function __construct() {
			
			parent::__construct();	
		}
		
		public function create($data) {
			
			$product = new \App\Entities\Product();
			           
			$result = $product->insert(array(
				'name' => $this->request->post('name'),
				'description' => $this->request->post('description'),
				'price' => $this->request->post('price'),
			));	
			                
			if ($result) {
				$productCategory = new \App\Entities\ProductCategory();
				$productCategory->addProductToCategory((int)$result, (int)$this->request->post('category_id'));
					
				$this->response->sendJSON([
					'result' => 'success',
				]);	
			}
		}
		
		public function read() {
        	       
			if (!empty($this->request->post('product_id'))) {
	            
	            $product = new \App\Entities\Product(); 					
				$result = $product->select(array(
					'where' => array(
						'id' => (int)$this->request->post('product_id'),
					)
				));
				
				$this->response->sendJSON([
					'result' => $result,
				]);
			} elseif (!empty($this->request->post('category_id'))) {
	            
	            $result = array();
	            $product = new \App\Entities\Product();
	            $productCategory = new \App\Entities\ProductCategory();
	            $productIds = $productCategory->getProductsByCategory((int)$this->request->post('category_id')); 
	            if (!empty($productIds)) {    
					$result = $product->select(array(
						'where' => array(
							'id' => $productIds,
						)
					));
				}

				$this->response->sendJSON([
					'result' => $result,
				]);
			} else {
				$this->response->sendJSON([
					'result' => 'error',
					'error_message' => 'Wrong product id',
				]);
			} 	
		}
		
		public function update() {
		
			if (!empty($this->request->post('product_id'))) {
				$product = new \App\Entities\Product();	
				       
				$result = $product->update(array(					
						'name' => $this->request->post('name'),
						'description' => $this->request->post('description'),
						'price' => $this->request->post('price'),
					),
					array(
						'id' => (int)$this->request->post('product_id'),
					)
				);
				
				$this->response->sendJSON([
					'result' => 'success',
				]);
			} else {
				$this->response->sendJSON([
					'result' => 'error',
					'error_message' => 'Wrong product id',
				]);	
			}	
		}
		
		public function delete() {
		
			if (!empty($this->request->post('product_id'))) {
				$product = new \App\Entities\Product();	
				       
				$result = $product->delete(array(
					'where' => array(
						'id' => (int)$this->request->post('product_id'),
					)
				));
				
				$this->response->sendJSON([
					'result' => 'success',
				]);
			} else {
				$this->response->sendJSON([
					'result' => 'error',
					'error_message' => 'Wrong product id',
				]);	
			}
		}
	}
}

?>