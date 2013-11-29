<?php

/**
 * RegisterCode form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     fiberbunny
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class RegisterCodeForm extends BaseRegisterCodeForm
{
  public function configure()
  {
  	$this->setWidget("id", new sfWidgetFormInputText());
  	$this->setWidget('profile_id', new sfWidgetFormInputHidden());
  	$this->setWidget('in_use', new sfWidgetFormInputHidden());
  	$this->setWidget('course_list', new sfWidgetFormInputHidden());

  	$this->setValidator('id', new sfValidatorPass());

  	$hash = substr(strtoupper(MD5(time())),1,10);
  	$this->setDefault('id', $hash);
  }
}
