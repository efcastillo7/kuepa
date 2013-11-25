<?php

/**
 * user actions.
 *
 * @package    kuepa
 * @subpackage user
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends kuepaActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->user = $this->getUser();
    $this->form = new sfUserForm($this->getGuardUser());

    // $user = new sfGuardUser();
    // $user->setEmailAddress("email@sad.com");
    // $user->setUsername("username");
    // $user->setPassword("password");
    // $user->setFirstName("firstname");
    // $user->setLastName("lastname");
    // $user->setIsActive(true);
    // $user->setIsSuperAdmin(false);
    // $user->save();
  }
}
