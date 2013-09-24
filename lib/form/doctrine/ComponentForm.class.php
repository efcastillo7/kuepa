<?php

/**
 * Component form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     fiberbunny
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ComponentForm extends BaseComponentForm {

    public function configure() {
        unset($this['deleted_at'], $this['updated_at'], $this['created_at'], $this['parents_list'], $this['children_list'], $this['profiles_list'], $this['node_id']
        );

        $this->setWidget('description', new sfWidgetFormTextarea());
        $this->widgetSchema['duration']->setAttribute("class", "spinner");

        $this->setWidget('profile_id', new sfWidgetFormInputHidden());

        $this->setWidget('thumbnail', new sfWidgetFormInputFileEditable(array(
            'label' => 'Image',
            'file_src' => '',
            'is_image' => false,
            'edit_mode' => (!$this->isNew()),
            'with_delete' => true,
        )));

        $this->setValidator('thumbnail', new sfValidatorFile(
                array(
            'path' => sfConfig::get('sf_upload_dir') . '/thumbnail',
            // 'validated_file_class' => 'LocalValidatedFile',
            'max_size' => 7000000, // 7MB
            'required' => false), array(
            'max_size' => "Tamaño de imagen demasiado grande",
        )));
        
        $this->getWidgetSchema()->setIdFormat('%s'.($this->isNew() ? "" : "-" . $this->getObject()->getId()));
    }

}
