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
    // unset($this['created_at'],$this['updated_at'],$this['deleted_at'],
    //     $this['valid_until'], $this['colleges_list'], $this['components_list'],
    //     $this['sf_guard_user_id'], $this['google_id'], 
    //     $this['country'], $this['district'], $this['institution'], 
    //     $this['local_id_type'], $this['local_id'], $this['phone']);

    $this->useFields(array('nickname', 'first_name', 'last_name', 'sex', 'birthdate'));

    //set decorator
    $decorator = new sfWidgetFormSchemaFormatterLocal($this->getWidgetSchema(), $this->getValidatorSchema());
    $this->widgetSchema->addFormFormatter('custom', $decorator);
    $this->widgetSchema->setFormFormatterName('custom');
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');

    $this->setWidget("password", new sfWidgetFormInputPassword());
    $this->setValidator("password", new sfValidatorString(array('required' => false, 'min_length' => 8)));

    $this->setWidget("repassword", new sfWidgetFormInputPassword());
    $this->setValidator("repassword", new sfValidatorString(array('required' => false)));

    $this->setWidget("email_address", new sfWidgetFormInputText());
    $this->setValidator("email_address", new sfValidatorString(array('required' => false)));

    $this->setWidget('avatar', new sfWidgetFormInputFileEditable(array(
            'label' => 'Profile picture',
            'file_src' => 'uploads/avatars/' . $this->getObject()->getAvatar(),
            'is_image' => true,
            'edit_mode' => (!$this->isNew()),
            'with_delete' => false,
        )));

    $this->setValidator('avatar', new sfValidatorFile(
            array(
        'path' => sfConfig::get('sf_upload_dir') . '/avatars',
        // 'validated_file_class' => 'LocalValidatedFile',
        'max_size' => 524288, // 7MB
        'required' => false), array(
        'max_size' => "Tamaño de imagen demasiado grande",
    )));

    //date
    $years = range(1900, 2010);
    $this->setWidget('birthdate', new sfWidgetFormDate(array(
        'format' => '%day%/%month%/%year%',
        'years' => array_combine($years, $years)
    )));

    //timezone
    $this->setWidget('timezone', new sfWidgetFormI18nChoiceTimezone());
    $this->setValidator('timezone', new sfValidatorI18nChoiceTimezone());

    //Culture
    $culture_choices = array("es_AR" => "Argentina", "es_CO" => "Colombia", "es_MX" => "México", "es_PE" => "Perú");

    $this->setWidget('culture', new sfWidgetFormChoice(array('choices' => $culture_choices)));
    $this->setValidator('culture', new sfValidatorChoice(array('choices' => array_keys($culture_choices))));

    $this->validatorSchema->setPostValidator(
      new sfValidatorCallback(array('callback' => array($this, 'checkPassword')))
    );

    //get email
    $this->getWidgetSchema()->setDefaults(array('email_address' => $this->getObject()->getSfGuardUser()->getEmailAddress()));
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
