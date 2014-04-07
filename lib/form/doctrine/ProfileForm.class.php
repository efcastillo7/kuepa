<?php

/**
 * Profile form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     fiberbunny
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProfileForm extends BaseProfileForm
{
  public function configure()
  {
  	unset($this['created_at'], $this['updated_at'], $this['deleted_at'], $this['sf_guard_user_id'],
        $this['current_module'], $this['current_action'], $this['colleges_list'], 
        $this['groups_list'], $this['google_id'], $this['components_list']);

    //set decorator
    $decorator = new sfWidgetFormSchemaFormatterLocal($this->getWidgetSchema(), $this->getValidatorSchema());
    $this->widgetSchema->addFormFormatter('custom', $decorator);
    $this->widgetSchema->setFormFormatterName('custom');
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');

  	// $this->setWidget('sf_guard_user_id', new sfWidgetFormInputHidden());

  	// $this->setWidget('components_list', new sfWidgetFormDoctrineChoice(array('multiple' => true, 'table_method' => 'getCourses', 'model' => 'Component')));

  	//date
    $years = range(1900, 2000);
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

  	// $this->setWidget('birthdate', new sfWidgetFormJQueryDate());
  	// $this->setWidget('valid_until', new sfWidgetFormJQueryDate());

 	// $this->widgetSchema['colleges_list']->addOption('expanded', true);
  }
}
