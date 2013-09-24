<?php

/**
 * Resource form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     fiberbunny
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ResourceForm extends BaseResourceForm {

    /**
     * @see ComponentForm
     */
    public function configure() {
        parent::configure();

        unset($this['thumbnail'], $this['color']);

        $this->setWidget('type', new sfWidgetFormInputHidden());
        $this->setWidget('lesson_id', new sfWidgetFormInputHidden());

        $this->setValidator('name', new sfValidatorString(array('required' => true)));
        $this->setValidator('lesson_id', new sfValidatorInteger(array('required' => true)));

        $this->setDefaults(array(
            'type' => Resource::TYPE,
            'lesson_id' => $this->getOption("lesson_id")
        ));

        $recourse_types = array(
            "recurse_data_text" => "Text",
            "recurse_data_document" => "Document",
            "recurse_data_video" => "Video",
            "recurse_data_embedded_web" => "Embedded Web",
        );

        $this->setWidget("recurse_type", new sfWidgetFormChoice(array('choices' => $recourse_types)));
        $this->setValidator("recurse_type", new sfValidatorChoice(array('choices' => array_keys($recourse_types), 'required' => true)));

        //$this->embedForm("text", new ResourceDataTextForm());
        //$this->embedForm("document", new ResourceDataDocumentForm());
        //$this->embedForm("video", new ResourceDataVideoForm());
        //$this->embedForm("embedded_web", new ResourceDataEmbeddedWebForm());
    }

}
