<?php

namespace Core\Storage {

	abstract class DatabaseObject {

	    protected $db;
	    protected $table;

	    public function __construct() {

	        $this->db = \Core\Storage\Database::getInstance();
	    }
	    
	    public function insert(array $data) {
			
			$dbq = 'INSERT INTO %s (%s) VALUES (%s);';
			
			if (count($data) == count($data, COUNT_RECURSIVE)) {
				$fields = array_keys($data);
				$dbq = sprintf($dbq, $this->table, implode(',', $fields), ":" . implode(",:", $fields)); 
				$stmt = $this->db->prepare($dbq);   
				$result = $this->db->execute($stmt, $data);
				$lastInsertId = $this->db->lastInsertId();
				if ($lastInsertId) {
					$result = $lastInsertId;
				}
			} else {
				$fields = array_keys($data[0]);
				$dbq = sprintf($dbq, $this->table, implode(',', $fields), ':' . implode(",:", $fields)); 
				$stmt = $this->db->prepare($dbq);   
				foreach($data as $row) {
					$result = $result && $this->db->execute($stmt, $row);		
				}
				$lastInsertId = $this->db->lastInsertId();
				if ($lastInsertId) {
					$result = $lastInsertId;
				}
			} 

			return $result;
	    }
	    
	    public function select(array $clause) {

			if (empty($clause['fields'])) {
				$fields = '*';
			} else {
				$fields = is_array($clause['fields']) ? implode(',', $clause['fields']) : $clause['fields'];
			} 
			
			$dbq = sprintf('SELECT %s FROM %s WHERE ', $fields, $this->table);
			                    
			$where = '1';
			if (!empty($clause['where'])) { 				
				if (is_array($clause['where'])) {					
					foreach($clause['where'] as $name => $value) { 
						if (is_array($value)) {
							$where .= sprintf(" AND %s IN (%s)", $name, implode(",", $value));
						} else {
							$where .= sprintf(' AND %s = :%s', $name, $name);
						}
					} 	   
					$stmt = $this->db->prepare($dbq . $where); 

            		foreach($clause['where'] as $name => $value) {   
						if (is_array($value)) {                           
							
						} else {
							$stmt->bindValue(":$name", $value);  
						}
					}            		 
					$stmt->execute();
					         
					return $stmt->fetchAll(\PDO::FETCH_ASSOC);					
				} else {
					$where .= ' AND ' . $clause['where'];
				};					
			} 
                                    
			return $this->db->fetchAll($dbq . $where);
	    }
	    
	    public function update(array $data, array $clause = []): bool {			
                         
	    	$set = '';
	    	if (!empty($data)) {
				foreach($data as $name => $value) {
					$set .= sprintf('%s %s = :s_%s', (empty($set) ? '' :','), $name, $name);
				} 		
			}	
	    	$where = '1';
	    	if (!empty($clause)) {
				foreach($clause as $name => $value) { 
					$where .= sprintf(' AND %s = :w_%s', $name, $name);
				}
			} 	                        
			$dbq = sprintf('UPDATE %s SET %s WHERE %s', $this->table, $set, $where);
			$stmt = $this->db->prepare($dbq);
			if (!empty($data)) {
				foreach($data as $name => $value) {
					$stmt->bindValue(":s_$name", $value);
				}
			}
			if (!empty($clause)) {
				foreach($clause as $name => $value) {
					$stmt->bindValue(":w_$name", $value);
				}
			}    
					
			return $stmt->execute();
		}
	    
	    public function delete(array $clause = []): bool {
			
			$where = '1';
			if (!empty($clause['where']))
				foreach($clause['where'] as $name => $value) 
					$where .= sprintf(' AND %s = :%s', $name, $name);
			$dbq = sprintf('DELETE FROM %s WHERE %s', $this->table, $where);
			$stmt = $this->db->prepare($dbq);
			if (!empty($clause['where'])) {
				foreach($clause['where'] as $name => $value) {
					$stmt->bindValue(":$name", $value);
				}
			}		
			
			$stmt->execute();
				
			return $stmt->rowCount() ? $stmt->rowCount() : false;
	    }
	    
	    private static function bindParamAsArray($name, $values, &$bind)
		{
		    $result = '';
		    foreach($values as $index => $value){
		        $result .= sprintf(':%s%s,', $name, $index);
		        $bind[$name.$index] = $value;
		    }
		    
		    return rtrim($result, ',');     
		}
	}
}

?>