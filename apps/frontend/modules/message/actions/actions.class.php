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
  public function preExecute()
  {
    $this->setLayout("layout_v2");
  }


 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    
  }

  public function executeFetch(sfWebRequest $request){
  	// $profile_id = $this->getUser()->getProfile()->getId();
  	$profile_id = 1;

  	$this->messages = MessagingService::getInstance()->getMessagesForUser($profile_id, array('params' => array($profile_id), 'hydration_mode' => Doctrine::HYDRATE_ARRAY));

  	return $this->renderText(json_encode($this->messages));

  }
}
