<?php

/**
 * VideoSession form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     CristalMedia
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class VideoSessionForm extends BaseVideoSessionForm {

    public function configure() {
        unset(
            $this['deleted_at'],
            $this['updated_at'],
            $this['created_at']
        );

        $anios = range(date("Y"), (int)date("Y")+1);

        $this->setWidgets(array(
            'profile_id'    => new sfWidgetFormInputHidden(),
            'platform'      => new sfWidgetFormInputHidden(),
            'type'          => new sfWidgetFormInputHidden(),
            'course_id'     => new sfWidgetFormChoice(array(
                "choices"   => $this->getCoursesForChoiceWidget() )
            ),
            'chapter_id'    => new sfWidgetFormChoice(array("choices" => array())),
            'title'         => new sfWidgetFormInputText(),
            'description'   => new sfWidgetFormTextarea(),
            'visibility'    => new sfWidgetFormChoice(array(
                "choices"   => array(
                    "public"    => "Público",
                    "private"   => "Privado"
                )
            )
            ),
            'scheduled_for' => new sfWidgetFormDateTime(
                array(
                    "date"  =>
                        array(
                            "format"    => '%day%/%month%/%year%',
                            'years'     => array_combine($anios, $anios)
                        )
                )
            ),
            'scheduled_end' => new sfWidgetFormDateTime(
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
            'course_id'     => 'Curso',
            'chapter_id'    => 'Lección',
            'scheduled_for' => 'Fecha y hora de inicio',
            'scheduled_end' => 'Fecha y hora de fin',
            'visibility'    => 'Visibilidad'
        ));

        $this->setDefaults(array(
            "scheduled_for" => date("c", time() ),
            "scheduled_end" => date("c", strtotime("+1 hour") ),
            'profile_id'    => $this->getObject()->getProfileId(),
            'type'          => VideoSessionService::TYPE_CLASS,
            'platform'      => VideoSessionService::PLATFORM_HANGOUTS,
            'visibility'    => 'public'
        ));

        $this->setValidators(array(
            'title'         => new sfValidatorString(   array('required' => true),  array('required' => 'Ingrese un título.')),
            'description'   => new sfValidatorString(   array('required' => true),  array('required' => 'Ingrese una descripción.')),
            'profile_id'    => new sfValidatorPass(),
            'type'          => new sfValidatorPass(),
            'platform'      => new sfValidatorPass(),
            'course_id'     => new sfValidatorInteger(  array('required' => true),  array('required' => 'Seleccione un curso relacionado.')),
            'chapter_id'    => new sfValidatorPass(),
            'visibility'    => new sfValidatorPass(),
            'scheduled_for' => new sfValidatorDateTime(
                array(
                    'required'  => true,
                    'min'       => date("c", time() ),
                    'max'       => date("c", strtotime("+1 month"))
                ),
                array(
                    'required'  => "Ingrese la fecha y hora en la que se realizará la sesión de video",
                    'min'       => "La fecha debe ser mayor a la actual.",
                    'max'       => "La fecha no puede ser más de un mes posterior a la actual"
                )),
            'scheduled_end' => new sfValidatorDateTime(
                array(
                    'required'  => true,
                    'min'       => date("c", strtotime("+1 hour") ),
                    'max'       => date("c", strtotime("+1 month"))
                ),
                array(
                    'required'  => "Ingrese la fecha y hora en la que se finalizará la sesión de video",
                    'min'       => "La fecha debe ser mayor a la de inicio más una hora.",
                    'max'       => "La fecha no puede ser más de un mes posterior a la actual"
                ))
        ));

        //Url is shown only for modification OR IF PLATFORM_EXTERNAL
        //if(!$this->isNew()){
            $this->setWidget('url', new sfWidgetFormInputText() );
            $this->setValidator('url', new sfValidatorPass() );
            $this->widgetSchema->setLabel('url', 'Url');
            //$this->getWidget("url")->setHidden(true);
        //}

        $this->getWidgetSchema()->setIdFormat('%s' . ($this->isNew() ? "" : "-" . $this->getObject()->getId()));

        $this->widgetSchema->setNameFormat('video_session[%s]');

    }
    
    public function bind(array $taintedValues = null, array $taintedFiles = null) {
        parent::bind($taintedValues, $taintedFiles);
        
        #hide url if hangouts
        if($taintedValues["platform"] == VideoSessionService::PLATFORM_HANGOUTS) {
            $this->getWidget("url")->setAttribute("style", "display:none;");
        }
    }

    /**
     *
     * @return array the list of courses for the professor formatted as assoc array.
     */
    private function getCoursesForChoiceWidget(){
        $data       = ComponentService::getInstance()->getCoursesForUser($this->getObject()->getProfileId());
        $as_array   = array();

        foreach($data as $course){
            $as_array[ $course->getId() ] = $course->getName();
        }

        return $as_array;
    }

}
