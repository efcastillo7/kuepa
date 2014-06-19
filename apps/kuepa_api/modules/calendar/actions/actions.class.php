<?php

/**
 * calendar actions.
 *
 * @package    kuepa
 * @subpackage calendar
 * @author     kibind
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class calendarActions extends kuepaActions {
    
    public function executeGetSidebarData(sfWebRequest $request) {
 
        $sideBar = array();

        $sideBar["subjects"]    = CalendarEventTable::getInstance()->getCoursesWithEventsForUser( $this->getProfile()->getId(), $this->getUser()->getEnabledCourses() );
        $sideBar["hasTutorias"] = CalendarEventTable::getInstance()->getTutoriasByProfileId( $this->getProfile()->getId() );
        
        return $this->renderText(json_encode($sideBar));
    }
    
    public function executeDelete(sfWebRequest $request) {
        $id           = $request->getPostParameter("id");
        $event = CalendarEventTable::getInstance()->findOneById($id);
        $response = array(
                            "status" => "error",
                            "msg"    => "No se pudo eliminar el evento."
                         );
        if($event && $event->delete()){
            $response = array(
                                "status" => "success",
                                "msg"    => "Exito al eliminar el evento."
                             );
        }
        return $this->renderText(json_encode($response));
        
    }
    
    public function executeCreateEvent(sfWebRequest $request) {

        $title        = $request->getPostParameter("title");
        $description  = $request->getPostParameter("description");
        $start        = $request->getPostParameter("start");
        $end          = $request->getPostParameter("end");
        $publico      = $request->getPostParameter("publico");
        $subject      = $request->getPostParameter("subject");
        $address      = $request->getPostParameter("address");
        
        //validaciones
         
        $errores = array();
        
        try { 
            $validator = new sfValidatorString(array('required' => true));
            $title = $validator->clean($title);
        } catch (Exception $e) { 
            $errores['title'] = $e->getMessage();
        };
        
        try { 
            $validator = new sfValidatorString(array( 'required' => true ));
            $end = $validator->clean($end);
        } catch (Exception $e) { 
            $errores['end'] = $e->getMessage();
        };
                
        try { 
            $validator = new sfValidatorString(array( 'required' => true ));
            $start = $validator->clean($start);
        } catch (Exception $e) { 
            $errores['start'] = $e->getMessage();
        };
        
        if(count($errores)>0) {
            $response = array(
                "status"  => "error",
                "message" => $errores
            );
            return $this->renderText(json_encode($response));
        }
                
        $event = new CalendarEvent();

        if( $this->getGuardUser()->hasGroup("docentes") && $publico == "true"){
            $event->setRefId($subject);
            $event->setTipoRef(CalendarEvent::TIPO_REF_COURSE);
        }else{
            $event->setRefId($this->getProfile()->getId());
            $event->setTipoRef(CalendarEvent::TIPO_REF_PROFILE);
        }

        $event->setComponentId($subject);
        $event->setTitle($title);
        $event->setDescription($description);
         
        $event->setAddress($address);
         
        $event->setStart($start);
        $event->setEnd($end);

        $event->save();

        $event_subject = ComponentTable::getInstance()->findOneById($subject);
        
            $response = array(
                'id'            => $event->getId(),
                'title'         => $event->getTitle(),
                'start'         => $event->getStart(),
                'end'           => $event->getEnd(),
                'className'     => 'c-' . $event_subject->getColor(),
                'subject'       => $event_subject->getName(),
            	'subject_id'    => $event_subject->getId(),
                'allDay'        => false,
                'address'       => $event->getAddress(),
                'description'   => $event->getDescription(),
                'tipo_ref'      => $event->getTipoRef()
            );
        return $this->renderText(json_encode($response));
        
    }
   
    public function executeEditEvent(sfWebRequest $request) {
        
        $id           = $request->getPostParameter("id");
        $title        = $request->getPostParameter("title");
        $description  = $request->getPostParameter("description");
        $start        = $request->getPostParameter("start");
        $subject      = $request->getPostParameter("subject");
        $end          = $request->getPostParameter("end");
        $address      = $request->getPostParameter("address");
        $publico      = $request->getPostParameter("publico");
        
        //validaciones
         
        $errores = array();
        if($request->hasParameter("title")){
            try { 
                $validator = new sfValidatorString(array('required' => true));
                $title = $validator->clean($title);
            } catch (Exception $e) { 
                $errores['title'] = $e->getMessage();
            };
        }
        
        
        if($request->hasParameter("end")){
            try {
                $validator = new sfValidatorString(array( 'required' => false ));
                $end = $validator->clean($end);
            } catch (Exception $e){
                $errores['end'] = $e->getMessage();
            };
        }
        
        if($request->hasParameter("start")){
            try { 
                $validator = new sfValidatorString(array( 'required' => true ));
                $start = $validator->clean($start);
            } catch (Exception $e) { 
                $errores['start'] = $e->getMessage();
            };
        }
        if(count($errores)>0) {
            $response = array(
                "status"  => "error",
                "message" => $errores
            );
            return $this->renderText(json_encode($response));
        }
        
        $event = CalendarEvent::getRepository()->findOneById($id);
        
        if ($event) {
            if( $publico == "true" ){
                $event->setTipoRef(CalendarEvent::TIPO_REF_COURSE);
                $event->setRefId($subject);
            }else{
                $event->setTipoRef(CalendarEvent::TIPO_REF_PROFILE);
                $event->setRefId(sfContext::getInstance()->getUser()->getProfile()->getId());
            }
            if($title){$event->setTitle($title);}
            if($description){$event->setDescription($description);}
            if($start){$event->setStart(date("Y-m-d H:i",strtotime($start)));}
            if($end){$event->setEnd(date("Y-m-d H:i",strtotime($end)));}
            if($subject){$event->setComponentId($subject);}
            if($description){$event->setDescription($description);}
            if($address){$event->setAddress($address);}
            
            
            $event->save();
            
            return $this->renderText(json_encode(array(
                'id'          => $event->getId(),
                'title'       => $event->getTitle(),
                'description' => $event->getDescription(),
                'start'       => $event->getStart(),
                'end'         => $event->getEnd(),
                'address'     => $event->getAddress(),
                'allDay'      => false,
                'tipo_ref'    => $event->getTipoRef()
            )));
            
        }
        return false;
    }
    
    public function executeGetUserEventsByMonth(sfWebRequest $request) {
                
        $start           = $request->getGetParameter("start");
        $end             = $request->getGetParameter("end");
        $filterCourse    = $request->getGetParameter("filterCourse");
        $filterTutorias  = $request->getGetParameter("filterTutorias");
        
        $start = $start - (86400 * 7);
        $end = $end + (86400 * 7);
                
        $unformatted_events = CalendarEventTable::getInstance()->getUserEventsByMonth($start, $end, $filterCourse, $filterTutorias);
        
        if(!count($unformatted_events)){
            return 0;
        }
        
        foreach( $unformatted_events as $event ){
            
            $startDateTime = new DateTime($event["ce_start"]);
            $endDateTime   = new DateTime($event["ce_end"]);
            
            $editable = CalendarEventTable::getInstance()->abledToEdit($this->getUser(), $event["ce_component_id"], $event["ce_tipo_ref"]);
           
            $tmp_event = array(
                'id'          => $event["ce_id"],
                'title'       => $event["ce_title"],
                'start'       => $startDateTime->format('Y-m-d H:i'),
                'end'         => $endDateTime->format('Y-m-d H:i'),
                'className'   => 'c-' . $event["c_color"],
                'subject'     => $event["c_name"],
                'address'     => isset($event["ce_address"]) ? $event["ce_address"] : "",
                'description' => isset($event["ce_description"]) ? $event["ce_description"] : "",
                'allDay'      => false,
                'editable'    => $editable,
                'tipo_ref'    => $event["ce_tipo_ref"]
            );
            
            $events[] = $tmp_event;
            
        }
        
        return $this->renderText(json_encode($events));
    }

}
