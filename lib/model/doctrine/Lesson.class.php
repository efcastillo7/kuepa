<?php

/**
 * Lesson
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    kuepa
 * @subpackage model
 * @author     fiberbunny
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Lesson extends BaseLesson {

    /**
     * 
     * @return LessonTable
     */
    public static function getRepository() {
        return Doctrine_Core::getTable('Lesson');
    }

    public function getNextResource($previous_resource_id) {
        $previous_learning_path = LearningPath::getRepository()->createQuery("lp")
                ->where("lp.parent_id = ?", $this->getId())
                ->andWhere("lp.child_id = ?", $previous_resource_id)
                ->limit(1)
                ->fetchOne();
        
        return Resource::getRepository()->createQuery("r")
                ->innerJoin("r.LearningPath lp on r.id=lp.child_id")
                ->where("lp.parent_id = ?", $this->getId())
                ->andWhere("lp.position > ?", $previous_learning_path->getPosition())
                ->limit(1)
                ->fetchOne();
    }

}
