<?php

/**
 * sfGuardUser form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     kibind
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfRegisterDemoUserForm extends sfRegisterUserForm
{
  public function configure()
  {
    parent::configure();   

    unset($this['birthdate'], $this['sex'], $this['nickname']);

    $this->setWidget('code', new sfWidgetFormInputHidden());
  }
}
