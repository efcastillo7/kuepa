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
  public function executeLogintoken(sfWebRequest $request)
  {
    header('Access-Control-Allow-Origin: *');
    
    $username = trim($request->getPostParameter("username", ""));
    $password = trim($request->getPostParameter("password", ""));

    if (!empty($username) && !empty($password) && $request->isMethod('post')){
      $user = ProfileService::getInstance()->isValidUser($username,$password);
      if($user){
        // $this->getUser()->signin($user);
        $token = ProfileService::getInstance()->generateLoginToken($user->getProfile());
        $this->getResponse()->setStatusCode(200);

        return $this->renderText(json_encode(array('status' => 'ok', 'token' => $token)));
      }
    }

    $this->getResponse()->setHeaderOnly(true);
    $this->getResponse()->setStatusCode(401);

    return sfView::NONE;
  }
}
