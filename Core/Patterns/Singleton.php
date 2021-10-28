<?php 

namespace Core\Patterns {

	class Singleton {
		
		protected static $instances = array();
		
		public function __construct() {
			
			$calledClassName = get_called_class();
			
			if (empty($calledClassName))
				throw new Exception('Unable resolve called class name');

			if (isset(self::$instances[$calledClassName])) {   
				throw new Exception('Attempt to call __construct method of '.get_class($this).' class twice');
			} else
				self::$instances[$calledClassName] = $this;
		}
		
		function __clone() {
			
			throw new Exception('Attempt to call __clone method of '.get_class($this).' class');
		}

		final public static function getInstance() {

			$calledClassName = get_called_class();

			if (empty($calledClassName)) {
				throw new Exception('Unable resolve called class name');
			}
							  
			if (!isset(self::$instances[$calledClassName])) {
				$calledFuncArgs = func_get_args();
				if (count($calledFuncArgs)) {
					if (version_compare(phpversion(), '5.6.0', '>=')) {
						self::$instances[$calledClassName] = new $calledClassName($calledFuncArgs);
					} else {
						$rc = new ReflectionClass($calledClassName);
						self::$instances[$calledClassName] = $rc->newInstanceArgs($calledFuncArgs);
					}
				}  else
					self::$instances[$calledClassName] = new $calledClassName();
			}

			return self::$instances[$calledClassName];
		}

		final public static function dropInstance() {

			$calledClassName = get_called_class();

			if (empty($calledClassName)) {
				throw new Exception('Unable resolve class name');
			}

			if (isset(self::$instances[$calledClassName])) {
				unset(self::$instances[$calledClassName]);
			}

			return true;
		}
	}

}