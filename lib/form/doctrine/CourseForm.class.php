<?php

/**
 * Course form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     fiberbunny
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CourseForm extends BaseCourseForm
{
  /**
   * @see ComponentForm
   */
  public function configure()
  {
    parent::configure();

    $this->setWidget('type', new sfWidgetFormInputHidden());

    $this->setValidator('name', new sfValidatorString(array('required' => true)));

    $this->setDefaults(array(
    	'type' => Course::TYPE
	  ));
  }
}
