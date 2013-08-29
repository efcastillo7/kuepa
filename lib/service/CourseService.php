<?php

class CourseService {
    private static $instance = null;
    
    public static function getInstance() {
        if(!self::$instance) {
            self::$instance = new CourseService;
        }
        
        return self::$instance;
    }
    
    public function create($values = array()){
        $course = ComponentService::getInstance()->create('Course', $values);

        return $course;
    }

    public function edit($course_id, $values = array()){
        //check if course
        return ComponentService::getInstance()->edit($course_id, $values);
    }

    public function delete($course_id){
        //check if course
        return ComponentService::getInstance()->delete($course_id);
    }

    public function addTeacher($course_id, $teacher_id){
        return ComponentService::getInstance()->addUserToComponent($course_id, $teacher_id);
    }

    public function removeTeacher($course_id, $teacher_id){
        return ComponentService::getInstance()->removeUserFromComponent($course_id, $teacher_id);
    }

    public function addStudent($course_id, $student_id){
        return ComponentService::getInstance()->addUserToComponent($course_id, $student_id);
    }

    public function removeStudent($course_id, $student_id){
        return ComponentService::getInstance()->removeUserFromComponent($course_id, $student_id);
    }

    public function getStudentsList($course_id){
        return ComponentService::getInstance()->getUsersFromComponent($course_id);    
    }

    public function getTeachersList($course_id){
        return ComponentService::getInstance()->getUsersFromComponent($course_id);    
    }

    public function getChaptersLists($course_id){
        return ComponentService::getInstance()->getChilds($course_id, Chapter::TYPE);
    }

    public function addChapterToCourse($course_id, $chapter_id){
        return ComponentService::getInstance()->addChildToComponent($course_id, $chapter_id);
    }

    public function removeChapterFromCourse($course_id, $child_id){
        return ComponentService::getInstance()->removeChildFromComponent($course_id, $child_id);
    }
}
