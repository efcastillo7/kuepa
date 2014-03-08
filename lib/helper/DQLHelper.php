<?php

class DQLHelper
{
	static protected $instance;
	
	protected function __construct()
	{
	}
		
	public static function getInstance()
	{
		if (!self::$instance) {
		    self::$instance = new self();
		}
		return self::$instance;
	}

	public function parseOrderBy($order)
	{
	    $order = strtolower($order);
	    
	    return ( $order == 'asc' ) ? 'ASC' : 'DESC';
	}

}
