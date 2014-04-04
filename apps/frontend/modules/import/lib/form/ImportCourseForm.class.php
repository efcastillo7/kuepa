<?php

/**
 * userProfile form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     kibind
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ImportCourseForm extends sfForm
{
  public function configure()
  {
    $this->setWidget('file', new sfWidgetFormInputFile(array(
            'label' => 'Course',
        )));

    $this->setValidator('file', new sfValidatorFile(
            array(
        'path' => sfConfig::get('sf_upload_dir') . '/tmp',
        // 'validated_file_class' => 'LocalValidatedFile',
        'max_size' => 524288, // 7MB
        'required' => false), array(
        'max_size' => "Tamaño de curso demasiado grande",
    )));

    // $this->disableLocalCSRFProtection();
    $this->widgetSchema->setNameFormat('import[%s]');
  }
}
