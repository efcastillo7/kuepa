<?php

/**
 * calendar actions.
 *
 * @package    kuepa
 * @subpackage calendar
 * @author     fiberbunny
 */
class calendarActions extends kuepaActions {

    public function preExecute()
    {
      parent::preExecute();

      $this->setLayout("layout_v2");
    }

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) 
    {
        $this->form = new CalendarEventForm();        
    }
    
    public function executeEditEvent(sfWebRequest $request)
    {   
        
        $this->id = $request->getParameter('id');
        $title = $request->getParameter('title');
        $public = $request->getParameter('public') == "true" ? true : false;
        $subject = $request->getParameter('subject');
        $start = $request->getParameter('start');
        $end = $request->getParameter('end');
        
        
        
        if( $this->id ){   
            
            $event = CalendarEventTable::getInstance()->findOneById($request->getParameter('id'));
            
            if ( !$event->isEditable( $this->getUser() ) )
            {
                echo "No tienes los permisos suficientes para ejecutar esta accion";
                exit;
            }
            
            $this->form = new CalendarEventForm($event);
            
            $startDateTime = new DateTime($event->getStart());
            
            $this->form->setDefault('start_date',$startDateTime->format("d/m/Y"));
            $this->form->setDefault('start_time',$startDateTime->format("H:i"));
            
            $endDateTime = new DateTime($event->getEnd());
            
            $this->form->setDefault('end_date',$endDateTime->format("d/m/Y"));
            $this->form->setDefault('end_time',$endDateTime->format("H:i"));
            
            $this->form->setDefault('component_id',$event->getComponentId());
                        
            $this->form->setDefault('public',$event->getTipoRef() == CalendarEvent::TIPO_REF_PROFILE ? false : true);
            
        }else{
            $this->form = new CalendarEventForm();
        }
        
        //Si ya cargo datos el el pop-up de evento se los paso.
        if($title){$this->form->setDefault('title',$title);}
        if($public){$this->form->setDefault('public',$public);}
        if($subject){$this->form->setDefault('component_id',$subject);}
        if($start){$this->form->setDefault('start_date',$start);}
        if($start){$this->form->setDefault('start_hours',$start);}
        if($end){$this->form->setDefault('end_date',$end);}
        if($start){$this->form->setDefault('end_hours',$start);}
        
    }
}