<?php

/**
 * Course
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    kuepa
 * @subpackage model
 * @author     fiberbunny
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Course extends BaseCourse
{
	const TYPE = 'Course';

    /**
     * 
     * @return CourseTable
     */
    public static function getRepository() {
        return Doctrine_Core::getTable('Course');
    }
    
    public function clearCache($event)
    {
        parent::clearCache($event);

        $collegeLearningPaths = CollegeLearningPath::getRepository()->findOneByComponentId( $this->getId() );
        
        foreach ( $collegeLearningPaths as $collegeLearningPath ) {
            CacheHelper::getInstance()->deleteByPrefix('Course_getCoursesForCollege', array( $collegeLearningPath->getCollegeId() ));
        }
    }

    public function __toString(){
        return $this->getId() . " - " . $this->getName();
    }

    public function getChapters(){
    	return CourseService::getInstance()->getChaptersList($this->getId());
    }

    public function getThumbnailPath(){
        return "/uploads/thumbnail/" . $this->getThumbnail();
    }

    public function getLastResourceViewed($profile_id){
        return LogService::getInstance()->getLastResourceIdViewed($profile_id, $this);
    }

    public function getTotalTime($profile_id){
        return LogService::getInstance()->getTotalTime($profile_id, $this);
    }
}
