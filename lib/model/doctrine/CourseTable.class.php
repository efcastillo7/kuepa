<?php

/**
 * CourseTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CourseTable extends ComponentTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object CourseTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Course');
    }
    
    public function getCoursesForUser($profile_id) {
        
        $query = $this->createQuery('c');
        $query->addWhere('c.Profiles.id = ?', $profile_id);
        
        return $query->execute();
    }
    public function getCoursesForCollege($college_id) {
        
        $query = $this->createQuery('c')
                    ->innerJoin('c.CollegeLearningPath clp')
                    ->where('clp.college_id = ?', $college_id);
        
        $query->useResultCache(true, null, cacheHelper::getInstance()->genKey('Course_getCoursesForCollege', array($college_id)) );
        
        return $query->execute();
    }
}