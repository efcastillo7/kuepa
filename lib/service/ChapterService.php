<?php

class ChapterService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new ChapterService;
        }

        return self::$instance;
    }

    public function create($values = array()) {
        $chapter = ComponentService::getInstance()->create('Chapter', $values);

        return $chapter;
    }

    public function edit($chapter_id, $values = array()) {
        //check if course
        return ComponentService::getInstance()->edit($chapter_id, $values);
    }

    public function delete($chapter_id) {
        //check if course
        return ComponentService::getInstance()->delete($chapter_id);
    }

    public function addLessonToChapter($chapter_id, $lesson_id) {
        return ComponentService::getInstance()->addChildToComponent($chapter_id, $lesson_id);
    }

    public function removeLessonFromChapter($chapter_id, $lesson_id) {
        return ComponentService::getInstance()->removeChildFromComponent($chapter_id, $lesson_id);
    }

    public function getLessonsLists($chapter_id) {
        return ComponentService::getInstance()->getChilds($chapter_id, Lesson::TYPE);
    }

}
