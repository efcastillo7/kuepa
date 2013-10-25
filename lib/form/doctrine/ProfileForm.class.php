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
  	unset($this['components_list']);

  	$this->setWidget('sf_guard_user_id', new sfWidgetFormInputHidden());
  }
}
