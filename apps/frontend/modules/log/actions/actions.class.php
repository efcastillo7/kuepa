<?php

/**
 * log actions.
 *
 * @package    kuepa
 * @subpackage log
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class logActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeResource(sfWebRequest $request)
  {
    $resource_id = $request->getParameter("resource_id");

    $time = LogService::getInstance()->viewResource(Resource::TYPE, $resource_id, $this->getUser()->getProfile()->getId());

    $time_lapse = strtotime($time->getUpdatedAt()) - strtotime($time->getCreatedAt());

    $response = array('status' => 'success', 'time_lapse' => $time_lapse);

    return $this->renderText(json_encode($response));
  }
}
