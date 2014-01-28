<?php

/**
 * ResourceDataText form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     fiberbunny
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ResourceDataTextForm extends BaseResourceDataTextForm
{
  /**
   * @see ResourceDataForm
   */
  public function configure()
  {
    parent::configure();

    unset($this['document_type'], $this['video_type']);

    $this->setWidget('content', new sfWidgetFormTextarea());
    $this->widgetSchema['content']->setAttribute("class","settinymce");

    $this->setDefaults(array(
		  'type' => ResourceDataText::TYPE
    ));
  }
}
