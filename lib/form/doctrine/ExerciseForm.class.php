<?php

/**
 * Exercise form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     fiberbunny
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ExerciseForm extends BaseExerciseForm {

    public function configure() {
        parent::configure();

        unset(
            $this['deleted_at'],
            $this['updated_at'],
            $this['created_at']
        );

        $this->setWidget('type', new sfWidgetFormInputHidden());

        $anios = range(date("Y"), (int)date("Y")+1);

        $this->setWidgets(array(
            'course_id'    => new sfWidgetFormInputHidden(),
            'title'      => new sfWidgetFormInputText(array(),array("class"=>"input-xxlarge")),
            'description'          => new sfWidgetFormTextarea(array(),array("class" => "input-xxlarge tinymce")),
            'type'     => new sfWidgetFormChoice(array(
                "choices"   => array(
                    "single"    => "Todas las preguntas en una página",
                    "secuential"   => "Una pregunta por página"
                )
            )),
            'max_attemps'     => new sfWidgetFormChoice(array(
                "choices"   => array(
                    ""    => "Infinitos",
                    "1"   => "1",
                    "2"   => "2",
                    "3"   => "3"
                )
            )),
            'start_time' => new sfWidgetFormDateTime(
                array(
                    "date"  =>
                        array(
                            "format"    => '%day%/%month%/%year%',
                            'years'     => array_combine($anios, $anios)
                        )
                )
            ),
            'end_time' => new sfWidgetFormDateTime(
                array(
                    "date"  =>
                        array(
                            "format"    => '%day%/%month%/%year%',
                            'years'     => array_combine($anios, $anios)
                        )
                )
            )
        ));

        $this->widgetSchema->setLabels(array(
            'title'         => 'Título',
            'description'   => 'Descripción',
            'type'     => 'Tipo',
            'max_attemps'    => 'Intentos',
            'start_time' => 'Fecha inicial',
            'end_time'    => 'Fecha final'
        ));

        $this->setDefaults(array(
            "start_time" => date("c", time() ),
            "end_time" => date("c", time() ),
        ));

        $this->setValidators(array(
            'title'         => new sfValidatorString(   array('required' => true),  array('required' => 'Ingrese un título.')),
            'description'   => new sfValidatorString(   array('required' => true),  array('required' => 'Ingrese una descripción.')),
            'course_id'    => new sfValidatorPass(),
            'type'          => new sfValidatorPass(),
            'max_attemps'    => new sfValidatorPass(),
            'start_time' => new sfValidatorDateTime(
                array(
                    'required'  => true,
                ),
                array(
                    'required'  => "Ingrese la fecha y hora de inicio de la ejercitación",
                )),
            'end_time' => new sfValidatorDateTime(
                array(
                    'required'  => true,
                ),
                array(
                    'required'  => "Ingrese la fecha y hora de inicio de la ejercitación",
                ))
        ));

        $this->getWidgetSchema()->setIdFormat('%s' . ($this->isNew() ? "" : "-" . $this->getObject()->getId()));

        $this->widgetSchema->setNameFormat('exercise[%s]');

    }

}
