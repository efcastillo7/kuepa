<?php

class CacheHelper
{
    CONST SALT = 'KU3P4-C4CH3';
    
	static protected $instance;
	
	protected $config;
	protected $cacheDriver;

	protected function __construct()
	{
	    $manager = Doctrine_Manager::getInstance();
	    $this->cacheDriver = $manager->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
	}
		
	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new cacheHelper();
		}
		
		return self::$instance;
	}
	
	public function genKey($key)
	{
	    return sha1($key . self::SALT);
	}
	
	public function delete($key)
	{
	    $this->cacheDriver->delete( cacheHelper::getInstance()->genKey( $key ) );
	}
	
	public function deleteByPrefix($key)
	{
	    $this->cacheDriver->deleteByPrefix( $key );
	}
	
}



