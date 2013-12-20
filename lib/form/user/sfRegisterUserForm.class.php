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
      'password' => new sfWidgetFormInputPassword(),
      'repassword' => new sfWidgetFormInputPassword(),
      'code' =>  new sfWidgetFormInputText(),
      'program' => new sfWidgetFormInputHidden()
    ));

    $this->setValidators(array(
      'first_name' => new sfValidatorString(array('required' => true)),
      'last_name' => new sfValidatorString(array('required' => true)),
      'email_address' => new sfValidatorString(array('required' => true)),
      'sex' => new sfValidatorChoice(array('choices' => array('M', 'F'))),
      'birthdate' => new sfValidatorDate(array('required' => false)),
      'nickname' => new sfValidatorString(array('required' => true)),
      'password' => new sfValidatorString(array('required' => true)),
      'repassword' => new sfValidatorString(array('required' => true)),
      'program' => new sfValidatorString(array('required' => false)),
      'code' => new sfValidatorString(array('required' => true)),
    ));

    $this->widgetSchema->setNameFormat('register[%s]');

    // add a post validator
    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'checkPassword')))
    );

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'checkCode')))
    );
  }

  public function checkPassword($validator, $values)
  {
    if ($values['password'] != $values['repassword'])
    {
      $error = new sfValidatorError($validator, 'Passwords dont match');
 
      // throw an error bound to the password field
      throw new sfValidatorErrorSchema($validator, array('password' => $error));
      }
 
    // password is correct, return the clean values
    return $values;
  }

  public function checkCode($validator, $values)
  {
    if ($values['code'] != "")
    {
      $code = RegisterCode::getRepository()->find($values['code']);

      if($code == null || !$code->isValidCode()){
        $error = new sfValidatorError($validator, 'Invalid code');
 
        // throw an error bound to the password field
        throw new sfValidatorErrorSchema($validator, array('code' => $error));
      }
    }
 
    // password is correct, return the clean values
    return $values;
  }
}
