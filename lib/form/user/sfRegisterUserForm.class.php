<?php

/**
 * sfGuardUser form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     fiberbunny
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfRegisterUserForm extends sfForm
{
  public function configure()
  {
    $sex = array('M' => 'Male', 'F' => 'Female');
  	$this->setWidgets(array(
      'first_name' => new sfWidgetFormInputText(),
      'last_name' => new sfWidgetFormInputText(),
      'email_address' => new sfWidgetFormInputText(),
      'sex' => new sfWidgetFormChoice(array('choices' => $sex)),
      'birthdate' => new sfWidgetFormDate(),
      'nickname' => new sfWidgetFormInputText(),
      'password' => new sfWidgetFormInputText(),
      'repassword' => new sfWidgetFormInputText(),
      'code' =>  new sfWidgetFormInputText(),
      'program' => new sfWidgetFormInputHidden()
    ));

    $this->setValidators(array(
      'first_name' => new sfValidatorString(array('required' => true)),
      'last_name' => new sfValidatorString(array('required' => true)),
      'email_address' => new sfValidatorString(array('required' => true)),
      'sex' => new sfValidatorChoice(array('choices' => array('M', 'F'))),
      'birthdate' => new sfValidatorDate(array('required' => true)),
      'nickname' => new sfValidatorString(array('required' => true)),
      'password' => new sfValidatorString(array('required' => true)),
      'repassword' => new sfValidatorString(array('required' => true)),
      'program' => new sfValidatorString(array('required' => false)),
      'code' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('register[%s]');
  }
}
