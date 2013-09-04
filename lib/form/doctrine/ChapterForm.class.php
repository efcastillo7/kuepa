<?php

/**
 * Chapter form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     fiberbunny
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ChapterForm extends BaseChapterForm
{
  /**
   * @see ComponentForm
   */
  public function configure()
  {
    parent::configure();

    unset($this['profile_id']);

    $this->setWidget('type', new sfWidgetFormInputHidden());
    $this->setWidget('course_id', new sfWidgetFormInputHidden());

    $this->setValidator('name', new sfValidatorString(array('required' => true)));
    $this->setValidator('course_id', new sfValidatorInteger(array('required' => true)));


    $this->setDefaults(array(
    	'type' => Chapter::TYPE,
      'course_id' => $this->getOption("course_id")
	));
  }
}
