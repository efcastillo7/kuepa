<?php

/**
 * sfGuardUser form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     kibind
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfRegisterUserForm extends sfForm
{
  public function configure()
  {
    $sex = array('M' => 'Masculino', 'F' => 'Femenino');

    $validate_code = $this->getOption('validate-code', true);

    $years = range(date("Y"), 1960);

  	$this->setWidgets(array(
      'first_name' => new sfWidgetFormInputText(),
      'last_name' => new sfWidgetFormInputText(),
      'email_address' => new sfWidgetFormInputText(),
      'sex' => new sfWidgetFormChoice(array('choices' => $sex)),
      'birthdate' => new sfWidgetFormDate(array('format' => "%day% / %month% / %year%", "years" => $years)),
      'nickname' => new sfWidgetFormInputText(),
      'password' => new sfWidgetFormInputPassword(),
      'repassword' => new sfWidgetFormInputPassword(),
      'code' =>  new sfWidgetFormInputText(),
      'program' => new sfWidgetFormInputHidden()
    ));

    $this->setValidators(array(
      'first_name' => new sfValidatorString(array('required' => true)),
      'last_name' => new sfValidatorString(array('required' => true)),
      'email_address' => new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => 'email_address')),
        new sfValidatorEmail(array('required' => true))
        )),
      'sex' => new sfValidatorChoice(array('choices' => array('M', 'F'))),
      'birthdate' => new sfValidatorDate(array('required' => false)),
      'nickname' => new sfValidatorString(array('required' => true)),
      'password' => new sfValidatorString(array('required' => true)),
      'repassword' => new sfValidatorString(array('required' => true)),
      'program' => new sfValidatorString(array('required' => false)),
      'code' => new sfValidatorString(array('required' => true)),
    ));

    $this->getWidgetSchema()->setLabels(array(
      'first_name' => 'Nombre',
      'last_name' => 'Apellidos',
      'email_address' => 'Email',
      'sex' => 'Sexo',
      'birthdate' => 'Fecha de Nacimiento',
      'nickname' => 'Usuario',
      'password' => 'Contraseña',
      'repassword' => 'Confirmar Contraseña',
      'code' =>  'Codigo',
      'program' => 'Programa'
    ));

    $this->widgetSchema->setNameFormat('register[%s]');



    // add a post validator
    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'checkPassword')))
    );

    if($validate_code){
      $this->validatorSchema->setPostValidator(
        new sfValidatorCallback(array('callback' => array($this, 'checkCode')))
      );
    }
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
