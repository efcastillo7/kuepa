<?php
class sendEmailsTask extends sfBaseTask
{
  public function configure()
  {
    $this->namespace = 'send';
    $this->name      = 'emails';
    $this->addArgument('limit', sfCommandArgument::OPTIONAL, '', '');
  }
 
  public function execute($arguments = array(), $options = array())
  {
/*    $configuration = ProjectConfiguration::getApplicationConfiguration('frontend', '', true);
    $databaseManager = new sfDatabaseManager($configuration);*/
//    $configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', false);
// sfContext::createInstance($configuration)->dispatch();
    $configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);
    sfContext::createInstance($configuration)->dispatch();

    $databaseManager = new sfDatabaseManager($configuration);
   // $connection = $databaseManager->getDatabase()->getConnection();
    MailService::getInstance()->sendBatch( $arguments['limit'] );
  }
}