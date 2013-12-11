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

    unset($this['document_type']);

    $this->setWidget('content', new sfWidgetFormInputText());

    $form = new sfForm();

    $form->setWidget('file_src', new sfWidgetFormInputFile(array(
        'label' => 'Video File',
    )));

    $form->setValidator('file_src', new sfValidatorFile(
            array(
        'max_size' => 7000000, // 7MB
        'required' => false), array(
        'max_size' => "Tamaño de imagen demasiado grande",
    )));

    $this->embedForm('file', $form);

    $this->setDefaults(array(
        'type' => ResourceDataVideo::TYPE,
    ));
  }

  public function saveEmbeddedForms($con = null, $forms = null)
  {
    $form = $this->getValue('file');
    $file = $form['file_src'];

    if(isset($file)){
      $obj = $this->getObject();

      $filename = sha1($file->getOriginalName() . $file->getSize());
      $extension = $file->getExtension($file->getOriginalExtension());
      $resource_id = $obj->getResourceId();
      $file_path = "/resources/$resource_id/" . $filename.$extension;
      $file->save(sfConfig::get('sf_upload_dir') . $file_path);

      $obj->setContent('/uploads' . $file_path);
      $obj->save();
    }
   
    return parent::saveEmbeddedForms($con, $forms);
  }
}
