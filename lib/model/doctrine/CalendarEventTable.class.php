<?php

/**
 * CalendarEventTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CalendarEventTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object CalendarEventTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('CalendarEvent');
    }
    
    public function getCoursesWithEventsForUser($profileId) {

        $q = $this->createQuery('ce')
            ->select("DISTINCT ce.component_id, c.name, c.color ")
            ->addFrom('component c')
            ->where('c.id = ce.component_id')
            ->andWhere('(
                            (
                                ce.tipo_ref = "COURS" AND 
                                ce.ref_id IN ( 
                                    SELECT plp.component_id 
                                    FROM ProfileLearningPath AS plp 
                                    WHERE plp.profile_id = :profileId 
                                )
                             OR (
                                ce.tipo_ref = "PROFI" 
                                AND ce.ref_id = :profileId
                                ) 
                            )
                        )', array(":profileId" => $profileId));
        
        return $q->execute(array(), Doctrine::HYDRATE_SCALAR);
        
    }
    
    /*
     * Devuelve un array con todos los eventos para un rango de fechas
     */
    public function getUserEventsByMonth($start, $end, $filterCourse, $filterTutorials)
    {
        $courseEvents = array();
        $personalEvents = array();
        $videoSessionEvents = array();
        $profileId = sfContext::getInstance()->getUser()->getProfile()->getId();
        $profileLearningPathCourses = ProfileLearningPathTable::getInstance()->getCoursesArrayByIdProfile($profileId);
        
        $course = array();
        foreach($profileLearningPathCourses as $plp){
            $course[] = $plp["plp_component_id"];
        }
        
        if($filterCourse){
            
            $cQ = $this->createQuery('ce')
                ->addSelect('ce.id, ce.title, ce.start, ce.address, ce.end, ce.tipo_ref, c.color, c.name')
                ->addFrom('component c')
                ->Where('c.id = ce.component_id')
                ->addWhere('ce.tipo_ref = "COURS"')
                ->andWhereIn('ce.component_id', $course)
                ->addWhere('ce.start >= ?', date("Y-m-d H:i", $start))
                ->addWhere('ce.end <= ?', date("Y-m-d H:i", $end))
                ->andWhereIn('ce.ref_id', $filterCourse);
            
            $courseEvents = $cQ->execute(array(), Doctrine::HYDRATE_SCALAR);
            
        }
        
        if($filterCourse){
            
           $pQ = $this->createQuery('ce')
                ->addSelect('ce.id, ce.title, ce.start, ce.address, ce.end, ce.tipo_ref, c.color, c.name')
                ->addFrom('component c')
                ->addWhere('c.id = ce.component_id')
                ->andWhereIn('ce.component_id', $course)
                ->addWhere('ce.tipo_ref = "PROFI" AND ce.ref_id = ?', $profileId)
                ->addWhere('ce.start >= ?', date("Y-m-d H:i", $start))
                ->addWhere('ce.end <= ?', date("Y-m-d H:i", $end));
            $pQ->andWhereIn('ce.component_id', $filterCourse);
            
            $personalEvents = $pQ->execute(array(), Doctrine::HYDRATE_SCALAR);
        }
      
        if($filterTutorials){
            
            $vQ = $this->createQuery('ce')
                    ->addSelect('ce.id, ce.title, ce.start, ce.address, ce.end, ce.tipo_ref, c.color, c.name')
                    ->addFrom('component c')
                    ->addWhere('c.id = ce.component_id')
                    ->addFrom('videoSession vs')
                    ->addWhere('vs.id = ce.ref_id')
                    ->andWhereNotIn('ce.tipo_ref', array('COURS', 'PROFI'))
                    ->andWhereIn('ce.tipo_ref', $filterTutorials)
                    ->andWhereIn('ce.component_id', $course)
                    ->addWhere('ce.start >= ?', date("Y-m-d H:i", $start))
                    ->addWhere('ce.end <= ?', date("Y-m-d H:i", $end));

            $videoSessionEvents = $vQ->execute(array(), Doctrine::HYDRATE_SCALAR);
        }
        return array_merge($courseEvents, $personalEvents, $videoSessionEvents);
    }
    
    public function getTutoriasByProfileId($profileId){
        
        $profileLearningPathCourses = ProfileLearningPathTable::getInstance()->getCoursesArrayByIdProfile($profileId);
        
        $courses = "";
        
        foreach ($profileLearningPathCourses as $value) {
            $courses[] = $value["plp_component_id"];
        }
        
        $q = $this->createQuery('ce')
                ->addFrom('videoSession vs')
                ->addWhere('vs.id = ce.ref_id')
                ->addWhere('ce.tipo_ref = "CLASS"')
                ->addWhere('vs.profile_id = ?', $profileId)
                ->andWhereIn('vs.course_id', $courses)
                ->limit(1);
        
        return $q->execute(array(), Doctrine::HYDRATE_SCALAR);
        
    }
    
    public function findEventByVideoSessionId($videoSession){
        
        $q = $this->createQuery('ce')
                  ->addWhere('ce.tipo_ref = "CLASS"')
                  ->addWhere('ce.ref_id = ?',  $videoSession)
                  ->limit(1);
        
        return $q->execute();
        
    }
}