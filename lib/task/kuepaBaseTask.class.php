<?php

abstract class kuepaBaseTask extends sfBaseTask
{

  protected function preConfigure()
  {

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'kuepa', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));
    
    $this->namespace        = 'kuepa';
    $this->briefDescription = '';
    
  }
  
  protected function execute($arguments = array(), $options = array())
  {
  	// Inicializo el logger
  	$file_logger = new sfFileLogger
  						(
	  						$this->dispatcher,
	  						array( 'file' => $this->configuration->getRootDir().'/log/tasks.log' )
  						);
  						
	$this->dispatcher->connect('command.log', array($file_logger, 'listenToLogEvent'));
	
  	// Inicializo la conexion a base de datos
  	$databaseManager = new sfDatabaseManager($this->configuration);
	$connection = $databaseManager->getDatabase($options['connection'])->getConnection();
	
  	// Inicializo el contexto
  	sfContext::createInstance($this->configuration);
  	
  	$this->doExecute($arguments, $options);
  }
  
    
  abstract function doExecute($arguments = array(), $options = array());
	
  
}

