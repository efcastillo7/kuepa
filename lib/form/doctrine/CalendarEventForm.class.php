<?php

/**
 * CalendarEvent form.
 *
 * @package    kuepa
 * @subpackage form
 * @author     fiberbunny
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CalendarEventForm extends BaseCalendarEventForm
{
  public function configure()
  {
      $user = sfContext::getInstance()->getUser();
      $courses = ComponentService::getInstance()->getCoursesForUser( $user->getProfile() );
      $choices = array();
        
      foreach ($courses as $course){
            $choices[$course->getId()] = $course->getName();
      }
        
      $this->setWidgets(array(
        'title'        => new sfWidgetFormInputText(
              array('label'       => 'Titulo'), 
              array('placeholder' => 'Evento sin título','class' =>'input-big')
        ),
        'start_date'  =>  new sfWidgetFormInputText(
              array('label'       => 'Fecha desde:'), 
              array('class' =>'datepicker input-small')
        ),
        'start_time'  =>  new sfWidgetFormInputText(
              array('label'       => 'Hora desde:'), 
              array('placeholder' => '10:00','class' =>'hour input-small','maxlength' => '5')
        ),
        'end_date'    =>  new sfWidgetFormInputText(
              array('label'       => 'Fecha hasta:'), 
              array('class' =>'datepicker input-small')
        ),
        'end_time'    =>  new sfWidgetFormInputText(
              array('label'       => 'Hora hasta:'), 
              array('placeholder' => '11:00','class' =>'hour input-small','maxlength' => '5')
        ),
        'address'      => new sfWidgetFormInputText(
              array('label'       => 'Donde'), 
              array('placeholder' => 'Ingresa una locación','class' =>'input-big plus')
        ),
        'component_id' => new sfWidgetFormChoice( array('label'       => 'Materia/Calendario','choices' => $choices), array('class' => 'selectpicker')),
        'description'  => new sfWidgetFormTextarea(
              array('label'       => 'Descripción'), 
              array('placeholder' => 'Descripción','class' =>'textarea-big')
        )
    ));
    
    if($user->getGuardUser()->hasGroup("docentes")){
        $this->setWidget("public", new sfWidgetFormInputCheckbox(array('label' => 'Público'),array('class' => 'checkbox checkbox-default')));
    }
    $this->setValidator('component_id', new sfValidatorChoice( array('choices' => array_keys($choices), 'required' => false) ) );
  }
}
