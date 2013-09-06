<?php

/**
 * ResourceDataVideo form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     fiberbunny
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ResourceDataVideoForm extends BaseResourceDataVideoForm
{
  /**
   * @see ResourceDataForm
   */
  public function configure()
  {
    parent::configure();

    $this->setDefaults(array(
		'type' => ResourceDataVideo::TYPE
    ));
  }
}
