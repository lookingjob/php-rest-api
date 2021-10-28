<?php

use \Core\Patterns;

namespace Core\Storage {

	final class Config extends \Core\Patterns\Singleton {

	    private $data = false;

	    public function load($filename): void {

	    	if (!file_exists($filename)) {
				throw new Exeption('Config load error');
	    	}
	    	
	    	$this->data = include($filename);  
	    }
	    
	    public function get(string $key, $default = null) {

    		return isset($this->data[$key]) ? $this->data[$key] : null;		
	    }
	}
}

?>