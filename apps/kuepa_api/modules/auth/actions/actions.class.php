<?php

/**
 * auth actions.
 *
 * @package    kuepa
 * @subpackage auth
 * @author     CristalMedia
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class authActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeLogin(sfWebRequest $request)
  {
  	header('Access-Control-Allow-Origin: *');
  	
	$username = trim($request->getPostParameter("username", ""));
	$password = trim($request->getPostParameter("password", ""));

	if (!empty($username) && !empty($password) && $request->isMethod('post')){
    // if (!empty($username) && !empty($password)){
    	$user = Doctrine::getTable('sfGuardUser')->retrieveByUsername($username);
    	if($user)
        {
	        // password is ok?
	        if ($user->getIsActive() && $user->checkPassword($password))
	        {
	        	$this->getUser()->signin($user, false);
	            $this->getResponse()->setStatusCode(200);
	            return $this->renderText(json_encode(array('status' => 'ok')));
	        }
	    }
    }

    $this->getResponse()->setHeaderOnly(true);
    $this->getResponse()->setStatusCode(401);

    return sfView::NONE;
  }
}
