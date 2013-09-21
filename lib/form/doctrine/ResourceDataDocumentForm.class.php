<?php

/**
 * ResourceDataDocument form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     fiberbunny
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ResourceDataDocumentForm extends BaseResourceDataDocumentForm {

    /**
     * @see ResourceDataForm
     */
    public function configure() {
        parent::configure();

        unset($this['video_type'], $this['content']);

        $this->setWidget('path', new sfWidgetFormInputFileEditable(array(
            'label' => 'Document',
            'file_src' => '',
            'is_image' => false,
            'edit_mode' => (!$this->isNew()),
            'with_delete' => true,
        )));

        $this->setValidator('path', new sfValidatorFile(
                array(
            'path' => sfConfig::get('sf_upload_dir') . '/documents',
            // 'validated_file_class' => 'LocalValidatedFile',
            'max_size' => 70000000, // 70MB
            'required' => false), array(
            'max_size' => "Tamaño de imagen demasiado grande",
        )));

        $this->setDefaults(array(
            'type' => ResourceDataDocument::TYPE
        ));
    }

}
