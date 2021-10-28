<?php

namespace Core\Http {

	class Response {
	  
	  	const HTTP_OK = 200;
	  	const HTTP_BAD_REQUEST = 400;
	  	const HTTP_UNAUTHORIZED = 401;
	  	const HTTP_FORBIDDEN = 403;
	  	const HTTP_NOT_FOUND = 404;
	  	const HTTP_METHOD_NOT_ALLOWED = 405;
	  	
	  	protected $statuses = [
	        200 => 'OK',
	        400 => 'Bad Request',
	        401 => 'Unauthorized',
	        402 => 'Payment Required',
	        403 => 'Forbidden',
	        404 => 'Not Found',
	        405 => 'Method Not Allowed',
	    ];

	    private $content;
	    private $headers = [];
	    private $statusCode = '';
	    
		public function __construct(?string $content = '', int $statusCode = 200, array $headers = []) {
			
		    $this->setHeaders($headers);
		    $this->setContent($content);
		    $this->setStatusCode($statusCode);
		}	    
	    
	    public function setStatusCode(int $statusCode) {
	    	
		    $this->statusCode = $statusCode;
		}	    
	    
	    public function setContent(string $content) {
	    	
		    $this->content = $content;
		}

	    public function addHeader($name, $value) {
	        
	        $this->headers[$name][] = $value;
	    }

	    public function setHeaders($headers) {
	        
	        $this->headers = $headers;
	    }

	    public function sendContent() {
	    	
	    	if (!empty($this->content)) {     
	    		header(sprintf('Content-type: %s', $this->content));
			}
	    }

	    public function sendJSON(array $data) {
	    	
	    	if (!empty($data)) {
	    		$this->setContent('application/json; charset=UTF-8');
	    		$this->sendContent();
	    		echo json_encode($data);
			}
	    }

	    public function sendHeaders() {
	    	
	    	foreach ($this->headers as $name => $values) {
	            foreach ($values as $value) {
	                header(sprintf('%s: %s', $name, $value), (0 === strcasecmp($name, 'Content-Type')), $this->statusCode);
	            }
	        }
	    }

	    public function send() {
	    	
	    	header(sprintf('HTTP/1.0 %s %s', $this->statusCode, $this->statuses[$this->statusCode]));
	    	
	    	$this->sendContent();
	    	$this->sendHeaders();
	    }

	    public function redirect(string $url) {
	        
	        $this->setHeader('Location', $url);
	    }
	} 
}

?>