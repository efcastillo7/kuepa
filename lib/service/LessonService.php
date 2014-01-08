<?php

class LessonService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new LessonService;
        }

        return self::$instance;
    }

    public function create($values = array()) {
        $lesson = ComponentService::getInstance()->create(Lesson::TYPE, $values);

        return $lesson;
    }

    public function edit($lesson_id, $values = array()) {
        //check if course
        return ComponentService::getInstance()->edit($lesson_id, $values);
    }

    public function delete($lesson_id) {
        //check if course
        return ComponentService::getInstance()->delete($lesson_id);
    }

    public function addResourceToLesson($lesson_id, $resource_id) {
        return ComponentService::getInstance()->addChildToComponent($lesson_id, $resource_id);
    }

    public function removeResourceFromLesson($lesson_id, $resource_id) {
        return ComponentService::getInstance()->removeChildFromComponent($lesson_id, $resource_id);
    }

    public function getResourcesList($lesson_id) {
        return ComponentService::getInstance()->getChilds($lesson_id, Resource::TYPE);
    }

    public function getDependencyPathList($course_id, $chapter_id, $lesson_id){
        $q = DependencyPath::getRepository()->createQuery("dp");
        $q->where("course_id = ?", $course_id)
          ->andWhere("chapter_id = ?", $chapter_id)
          ->andWhere("lesson_id = ?", $lesson_id);
        return($q->execute());
    }

    public function checkLessonOnDependencyPath($course_id, $chapter_id, $lesson_id, $depends_lesson_id){
        $q = DependencyPath::getRepository()->createQuery("dp");
        $q->where("depends_lesson_id = ?", $depends_lesson_id)
          ->andWhere("course_id = ?", $course_id)
          ->andWhere("chapter_id = ?", $chapter_id)
          ->andWhere("lesson_id = ?", $lesson_id);
        return($q->execute());
    }

    public function addDependencyToLesson($form_values){
        $dp = new DependencyPath();
        $dp ->setCourseId( $form_values['course_id'] )
            ->setChapterId( $form_values['chapter_id'] )
            ->setLessonId( $form_values['lesson_id'] )
            ->setDependsCourseId( $form_values['depends_course_id'] )
            ->setDependsChapterId( $form_values['depends_chapter_id'] )
            ->setDependsLessonId( $form_values['depends_lesson_id'] )
            ->save();
        return($dp);
     }

    public function removeDependencyForLesson($dependency_path_id){
        $dp = DependencyPath::getRepository()->find($dependency_path_id);
        if ($dp) {
            $dp->delete();
        }
     }

}
