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

    public function getStudentsList($course_id, $colleges_ids = null){
        //colleges that has that course

        if(!$colleges_ids){
            $colleges = College::getRepository()->createQuery('c')
                            ->innerJoin("c.Components co")
                            ->where('co.id = ?', $course_id)
                            ->execute();

            $colleges_ids = $colleges->getPrimaryKeys();
        }

        $max = 250;

        //direct users
        $q1 = Profile::getRepository()->createQuery('p')
                ->innerJoin("p.ProfileLearningPath plp")
                ->where('plp.component_id = ?', $course_id)
                ->innerJoin('p.sfGuardUser sgu')
                ->innerJoin('sgu.sfGuardUserGroup sgug')
                ->innerJoin('sgug.Group sgg')
                ->andWhere('sgg.name = ?', 'estudiantes')
                ->andWhere('sgu.is_active = true')
                ->limit($max)
                ->execute();

        //users from college
        if(count($colleges_ids)){
            $q2 = Profile::getRepository()->createQuery('p')
                    ->innerJoin('p.sfGuardUser sgu')
                    ->innerJoin('sgu.sfGuardUserGroup sgug')
                    ->innerJoin('sgug.Group sgg')
                    ->andWhere('sgg.name = ?', 'estudiantes')
                    ->innerJoin("p.ProfileCollege pc")
                    // ->innerJoin("pc.College c")
                    // ->innerJoin("c.CollegeLearningPath clp")
                    ->andWhere('sgu.is_active = true')
                    ->limit($max)
                    ->whereIn("pc.college_id", $colleges_ids)
                    ->execute();

            // return $q2;
            return $users = $q1->merge($q2);
        }

        return $q1;


        // $q = Profile::getRepository()->createQuery('p')
        //         ->innerJoin('p.ProfileLearningPath plp')
        //         ->innerJoin('p.sfGuardUser sgu')
        //         ->innerJoin('sgu.sfGuardUserGroup sgug')
        //         ->innerJoin('sgug.Group sgg')
        //         ->where('plp.component_id = ?', $course_id)
        //         ->andWhere('sgg.name = ?', 'estudiantes');

        // return $q->execute();
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

    public function getCoursesAndChapters($courses){
        $query = Course::getRepository()->createQuery('c');

        if(is_array($courses) && count($courses)){
            $query->whereIn('id', $courses);
        }else{
            $query->where('id = ?',$courses);
        }

        if (is_array($courses) && count($courses) == 0){
            return array();
        }

        $query->leftJoin('c.Children ch');

        return $query->execute();
    }

    public function getCourseTree($course_id){
        $fields = array(
            "c.id", "c.name", "c.thumbnail", "c.level", "c.color", "c.duration", //"c.description",
            "ch.id", "ch.name", "ch.thumbnail", "ch.level", "ch.color", "ch.duration", //"ch.description",
            "l.id", "l.name", "l.thumbnail", "l.level", "l.color", "l.duration", //"l.description",
            "r.id", "r.name", "r.thumbnail", "r.level", "r.color", "r.duration", //"r.description",
        );

        $course = Course::getRepository()->createQuery("c")
                            ->select(implode(",", $fields))
                            ->leftJoin("c.Chapter ch")
                            ->leftJoin("ch.Lesson l")
                            ->leftJoin("l.Resource r")
                            ->where("c.id = ?", $course_id)
                            ->fetchArray();

        return $course;
    }

    public function getCourseAndChaptersAndLessonsAndRresourcesArray($course_id){
        //get course content
        $course_db = Doctrine::getTable("Course")->createQuery("c")
                    ->leftJoin("c.LearningPath lp1")
                    ->leftJoin("lp1.Child chap")
                    ->leftJoin("chap.LearningPath lp2")
                    ->leftJoin("lp2.Child les")
                    ->leftJoin("les.LearningPath lp3")
                    ->leftJoin("lp3.Child res")
                    ->where("c.id = ?", $course_id)
                    ->orderBy("lp1.position asc, lp2.position asc, lp3.position asc")
                    ->fetchArray();

        //set array
        $course = array();
        $component_properties = array('id', 'name', 'thumbnail', 'level', 'color', 'duration', 'deadline', 'description');

        $course_db = $course_db[0];

        //copy course values
        //copy default values
        foreach($component_properties as $comp_prop){
            $course[$comp_prop] = $course_db[$comp_prop];
        }
        $course['chapters'] = array();

        //foreach chapter
        foreach($course_db['LearningPath'] as $key => $ar_chap){
            //copy default values
            $nchapter = array();
            foreach($component_properties as $comp_prop){
                $nchapter[$comp_prop] = $ar_chap['Child'][$comp_prop];
            }
            //get enabled
            $nchapter['enabled'] = $ar_chap['enabled'];
            $nchapter['position'] = $ar_chap['position'];
            $nchapter['lessons'] = array();

            //foreach lessons
            foreach ($ar_chap['Child']['LearningPath'] as $key => $ar_les) {
                $nlesson = array();

                //copy default values
                foreach($component_properties as $comp_prop){
                    $nlesson[$comp_prop] = $ar_les['Child'][$comp_prop];
                }

                $nlesson['enabled'] = $ar_les['enabled'];
                $nlesson['position'] = $ar_les['position'];
                $nlesson['resources'] = array();

                //foreach resource
                foreach($ar_les['Child']['LearningPath'] as $key => $ar_res){
                    $nresource = array();

                    //copy default values
                    foreach($component_properties as $comp_prop){
                        $nresource[$comp_prop] = $ar_res['Child'][$comp_prop];
                    }

                    $nresource['enabled'] = $ar_res['enabled'];
                    $nresource['position'] = $ar_res['position'];
                    $nresource['data'] = array();

                    //get ResourceData manually (Child is not Resource)
                    $resources_data = ResourceData::getRepository()->createQuery("r")->where("resource_id = ?", $ar_res['Child']['id'])->fetchArray();

                    //if is exercise then moveit to
                    for ($i=0; $i<count($resources_data);$i++) {
                        if($resources_data[$i]['type'] == ResourceDataExercise::TYPE){
                            $exercise = Exercise::getRepository()->createQuery('ex')
                                            ->innerJoin('ex.Questions q')
                                            ->innerJoin('q.Answers a')
                                            ->where('ex.id = ?',$resources_data[$i]['content'])
                                            ->fetchArray();
                            
                            $resources_data[$i]['exercise'] = $exercise;
                        }
                    }

                    $nresource['data'] = $resources_data;

                    //add resource to lesson
                    $nlesson['resources'][] = $nresource;
                }

                //add lesson to chapter
                $nchapter['lessons'][] = $nlesson;
            }

            //add chapter to course
            $course['chapters'][] = $nchapter;
        }

        return $course;
    }

    public function getCourseAndChaptersAndLessonsArray($course_id){
        //get course content
        $course_db = Doctrine::getTable("Course")->createQuery("c")
                    ->leftJoin("c.LearningPath lp1")
                    ->leftJoin("lp1.Child chap")
                    ->leftJoin("chap.LearningPath lp2")
                    ->leftJoin("lp2.Child les")
                    ->where("c.id = ?", $course_id)
                    ->orderBy("lp1.position asc, lp2.position asc, lp3.position asc")
                    ->fetchArray();

        //set array
        $course = array();
        $component_properties = array('id', 'name', 'thumbnail', 'level', 'color', 'duration', 'deadline', 'description');

        $course_db = $course_db[0];

        //copy course values
        //copy default values
        foreach($component_properties as $comp_prop){
            $course[$comp_prop] = $course_db[$comp_prop];
        }
        $course['chapters'] = array();

        //foreach chapter
        foreach($course_db['LearningPath'] as $key => $ar_chap){
            //copy default values
            $nchapter = array();
            foreach($component_properties as $comp_prop){
                $nchapter[$comp_prop] = $ar_chap['Child'][$comp_prop];
            }
            //get enabled
            $nchapter['enabled'] = $ar_chap['enabled'];
            $nchapter['position'] = $ar_chap['position'];
            $nchapter['lessons'] = array();

            //foreach lessons
            foreach ($ar_chap['Child']['LearningPath'] as $key => $ar_les) {
                $nlesson = array();

                //copy default values
                foreach($component_properties as $comp_prop){
                    $nlesson[$comp_prop] = $ar_les['Child'][$comp_prop];
                }

                $nlesson['enabled'] = $ar_les['enabled'];
                $nlesson['position'] = $ar_les['position'];

                //add lesson to chapter
                $nchapter['lessons'][] = $nlesson;
            }

            //add chapter to course
            $course['chapters'][] = $nchapter;
        }

        return $course;
    }
}
