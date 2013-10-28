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
  	unset($this['components_list'], $this['created_at'], $this['updated_at'], $this['deleted_at']);

  	$this->setWidget('sf_guard_user_id', new sfWidgetFormInputHidden());
  	// $this->setWidget('birthdate', new sfWidgetFormJQueryDate());
  	// $this->setWidget('valid_until', new sfWidgetFormJQueryDate());

 	// $this->widgetSchema['colleges_list']->addOption('expanded', true);
  }
}
