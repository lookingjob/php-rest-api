<?php

use \Core\Patterns;

namespace Core\Storage {

	final class Database extends \Core\Patterns\Singleton {

	    private $connection = false;
	    
	    public $connected = false;

	    public function connect(string $driver, string $host, string $database, string $username, string $password): void {

	        try {
        		$dsn = sprintf('%s:host=%s;dbname=%s', $driver, $host, $database);
	            $this->connection = new \PDO($dsn, $username, $password); 
	            $this->connection->exec('SET NAMES UTF8');
	            $this->connected = true;  
	        } catch (PDOException $exception) {
	            echo 'Database connection error';
	        }
	    }
	    
	    public function query(string $dbq): bool {

    		if (!$this->connected) return false;
    		
    		return $this->connection->query($dbq);		
	    }
	    
	    public function fetch(string $stmt) {

    		if (!$this->connected) return false;
    		
    		return $this->connection->fetch($stmt);		
	    }
	    
	    public function fetchAll(string $dbq) {
    		
    		if (!$this->connected) return false;
    		
    		$stmt = $this->connection->query($dbq);
    		
    		return $stmt->fetchAll();		
	    }
	    
	    public function prepare(string $dbq) {
    		
    		if (!$this->connected) return false;
    		
    		$result = false;
    		$this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    		try {      
			    $result = $this->connection->prepare($dbq); 
			} catch(PDOException $e) {  
			    throw new Exception($e->getMessage());
			}
    		
    		return $result;		
	    }
	    
	    public function execute(\PDOStatement $stmt, array $params = [])  {
    		
    		if (!$this->connected) return false;
			              
			$result = true;
			if (!empty($params)) {
				if (count($params) == count($params, COUNT_RECURSIVE)) {
					foreach($params as $field => $value) {   
						$stmt->bindValue(":$field", $value);   
					}	
				} else {
					foreach($params as $pair) {
						$stmt->bindValue(":{$pair['field']}", $pair['value']);	
					}
				}
			}
				
			$result = $stmt->execute();
			
			return $result;
	    }
	    
	    public function lastInsertId() {
			
			return $this->connection->lastInsertId();
	    }
	}
}

?>