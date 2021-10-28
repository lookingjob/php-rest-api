<?php

namespace App\Controllers {

	class CategoryController extends \App\Handling\Controller {

		public function __construct() {
			
			parent::__construct();	
		}
		
		public function create($data) {
			
			$category = new \App\Entities\Category();
			           
			$result = $category->insert(array(
				'parent_id' => $this->request->post('parent_id'),
				'name' => $this->request->post('name'),
				'description' => $this->request->post('description'),
			));
			
			$this->response->sendJSON([
				'result' => $result ? 'success' : false,
			]);	
		}
		
		public function read() {
        	       
			if ($this->request->post('parent_id') !== null && strlen($this->request->post('parent_id'))) {
	            
	            $category = new \App\Entities\Category(); 					
				$result = $category->select(array(
					'where' => array(
						'parent_id' => (int)$this->request->post('parent_id'),
					)
				));
			} elseif (!empty($this->request->post('category_id'))) {
	            
	            $result = array();
	            $category = new \App\Entities\Category();
	            $result = $category->select(array(
					'where' => array(
						'id' => (int)$this->request->post('category_id'),
					)
				));
			} else {
				
				$category = new \App\Entities\Category(); 					
				$result = $category->select([]);
			}
			
			$this->response->sendJSON([
				'result' => $result,
			]); 	
		}
		
		public function update() {
		
			if (!empty($this->request->post('category_id'))) {
				$category = new \App\Entities\Category();	
				       
				$result = $category->update(array(					
						'name' => $this->request->post('name'),
						'description' => $this->request->post('description'),
					),
					array(
						'id' => (int)$this->request->post('category_id'),
					)
				);
				
				$this->response->sendJSON([
					'result' => 'success',
				]);
			} else {
				$this->response->sendJSON([
					'result' => 'error',
					'error_message' => 'Wrong category id',
				]);	
			}	
		}
		
		public function delete() {
		
			if (!empty($this->request->post('category_id'))) {
				$category = new \App\Entities\Category();	
				       
				$result = $category->delete(array(
					'where' => array(
						'id' => (int)$this->request->post('category_id'),
					)
				));
				
				$this->response->sendJSON([
					'result' => 'success',
				]);
			} else {
				$this->response->sendJSON([
					'result' => 'error',
					'error_message' => 'Wrong category id',
				]);	
			}
		}
	}
}

?>