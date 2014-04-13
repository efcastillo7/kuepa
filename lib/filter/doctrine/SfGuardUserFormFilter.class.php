<?php

/**
 * SfGuardUser filter form.
 *
 * @package    kuepa
 * @subpackage filter
 * @author     fiberbunny
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SfGuardUserFormFilter extends BaseSfGuardUserFormFilter
{
  public function configure()
  {
  	$this->setWidget('first_name', new sfWidgetFormFilterInput(array('with_empty' => false)));
  	$this->setWidget('last_name', new sfWidgetFormFilterInput(array('with_empty' => false)));

  	$this->disableCSRFProtection();
  }
}
