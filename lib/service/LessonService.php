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
        $lesson = ComponentService::getInstance()->create('Lesson', $values);

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

    public function getResourcesLists($lesson_id) {
        return ComponentService::getInstance()->getChilds($lesson_id, Resource::TYPE);
    }

}
