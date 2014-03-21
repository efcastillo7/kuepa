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
        $course = ComponentService::getInstance()->create(Course::TYPE, $values);

        return $course;
    }

    public function find($id){
        return ComponentService::getInstance()->find($id);
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
        $q = Profile::getRepository()->createQuery('p')
                ->innerJoin('p.ProfileLearningPath plp')
                ->innerJoin('p.sfGuardUser sgu')
                ->innerJoin('sgu.sfGuardUserGroup sgug')
                ->innerJoin('sgug.Group sgg')
                ->where('plp.component_id = ?', $course_id)
                ->andWhere('sgg.name = ?', 'estudiantes');

        return $q->execute();
    }

    public function getTeachersList($course_id){
        $q = Profile::getRepository()->createQuery('p')
                ->innerJoin('p.ProfileLearningPath plp')
                ->innerJoin('p.sfGuardUser sgu')
                ->innerJoin('sgu.sfGuardUserGroup sgug')
                ->innerJoin('sgug.Group sgg')
                ->where('plp.component_id = ?', $course_id)
                ->andWhere('sgg.name = ?', 'docentes');

        return $q->execute();
    }

    public function getChaptersList($course_id, $deep = false){
        if($deep){
            $q = Doctrine::getTable("Chapter")->createQuery("ch")
                    ->innerJoin("ch.Lesson l")
                    ->innerJoin("ch.Course c")
                    ->innerJoin("l.Resource r")
                    ->where("c.id = ?", $course_id);

            return $q->execute();
        }

        return ComponentService::getInstance()->getChilds($course_id, Chapter::TYPE);
    }

    public function addChapterToCourse($course_id, $chapter_id){
        return ComponentService::getInstance()->addChildToComponent($course_id, $chapter_id);
    }

    public function removeChapterFromCourse($course_id, $child_id){
        return ComponentService::getInstance()->removeChildFromComponent($course_id, $child_id);
    }

    public function getCourses($courses){
        $query = Course::getRepository()->createQuery('c');

        if(is_array($courses) && count($courses)){
            $query->whereIn('id', $courses);
        }else{
            $query->where('id = ?',$courses);
        }

        if (is_array($courses) && count($courses) == 0){
            return array();
        }

        return $query->execute();
    }
}
