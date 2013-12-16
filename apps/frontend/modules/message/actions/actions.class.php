<?php

/**
 * message actions.
 *
 * @package    kuepa
 * @subpackage message
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class messageActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	//create new message
    //$message = MessagingService::getInstance()->sendMessage(22, array(1,2), "hola probando", "Esto es una prueba :)");
    $profile_id = 1;

    $message = Message::getRepository()->find(3);

	// MessagingService::getInstance()->replyMessage($profile_id, $message->getId(), "Esta es la respuesta de 1 " . rand(1,10));

    $this->messages = MessagingService::getInstance()->getThread($message->getId());
  }

  public function executeFetch(sfWebRequest $request){
  	// $profile_id = $this->getUser()->getProfile()->getId();
  	$profile_id = 1;

  	$this->messages = MessagingService::getInstance()->getMessagesForUser($profile_id, array('params' => array($profile_id), 'hydration_mode' => Doctrine::HYDRATE_ARRAY));

  	return $this->renderText(json_encode($this->messages));

  }
}
