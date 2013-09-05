<?php

/**
 * Resource form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     fiberbunny
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ResourceForm extends BaseResourceForm
{
  /**
   * @see ComponentForm
   */
  public function configure()
  {
    parent::configure();

    unset($this['profile_id']);

    $this->setWidget('type', new sfWidgetFormInputHidden());
    $this->setWidget('lesson_id', new sfWidgetFormInputHidden());

    $this->setValidator('name', new sfValidatorString(array('required' => true)));
    $this->setValidator('lesson_id', new sfValidatorInteger(array('required' => true)));

    $this->setDefaults(array(
    	'type' => Resource::TYPE,
      'lesson_id' => $this->getOption("lesson_id")
  	));
  }
}
