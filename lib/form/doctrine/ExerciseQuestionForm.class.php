<?php

/**
 * ExerciseQuestion form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     fiberbunny
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ExerciseQuestionForm extends BaseExerciseQuestionForm {

    public function configure() {
        parent::configure();

        unset(
            $this['deleted_at'], $this['updated_at'], $this['created_at']
        );

        $this->setWidget('type', new sfWidgetFormInputHidden());

        $this->setWidgets(array(
            'title' => new sfWidgetFormInputText(array(), array("class" => "input-xxlarge")),
            'description' => new sfWidgetFormTextarea(array(), array("class" => "input-xxlarge tinymce")),
            'value' => new sfWidgetFormInputText(array(), array("class" => "input-medium")),
            'type' => new sfWidgetFormInputHidden()
        ));

        $this->widgetSchema->setLabels(array(
            'title' => 'Título',
            'description' => 'Descripción',
            'value' => 'Valor'
        ));

        $this->setValidators(array(
            'title' => new sfValidatorString(array('required' => true), array('required' => 'Ingrese un título.')),
            'description' => new sfValidatorString(array('required' => true), array('required' => 'Ingrese una descripción.')),
            'type' => new sfValidatorPass(),
            'value' => new sfValidatorPass(),
        ));

        $this->getWidgetSchema()->setIdFormat('%s' . ($this->isNew() ? "" : "-" . $this->getObject()->getId()));

        $this->widgetSchema->setNameFormat('exerciseQuestion[%s]');
    }

}
