<?php

/**
 * userProfile form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     kibind
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserProfileForm extends ProfileForm
{
  public function configure()
  {
    unset($this['created_at'],$this['updated_at'],$this['deleted_at'],
        $this['valid_until'], $this['colleges_list'], $this['components_list'],
        $this['sf_guard_user_id']);

    $this->setWidget("password", new sfWidgetFormInputPassword());
    $this->setValidator("password", new sfValidatorString(array('required' => false, 'min_length' => 8)));

    $this->setWidget("repassword", new sfWidgetFormInputPassword());
    $this->setValidator("repassword", new sfValidatorString(array('required' => false)));

    $this->setWidget("email_address", new sfWidgetFormInputText());
    $this->setValidator("email_address", new sfValidatorString(array('required' => false)));

    //date
    $years = range(1900, 2000);
    $this->setWidget('birthdate', new sfWidgetFormDate(array(
        'format' => '%day%/%month%/%year%',
        'years' => array_combine($years, $years)
    )));

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'checkPassword')))
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

  public function save($conn = null)
  {
    $obj = parent::save($conn);
    $values = $this->getValues();

    //update guard user if password or email address is set
    if($values['password'] != "" || $values['email_address'] != ""){
        $sf_guard = $obj->getSfGuardUser();

        if($values['password'] != ""){
            $sf_guard->setPassword($values['password']);
        }

        if($values['email_address'] != ""){
            $sf_guard->setEmailAddress($values['email_address']);
        }

        $sf_guard->save();
    }
 
    return $obj;
  }
}
