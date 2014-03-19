<?php

/**
 * lesson actions.
 *
 * @package    kuepa
 * @subpackage lesson
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class lessonActions extends kuepaActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->profile = $this->getProfile();

        $course_id = $request->getParameter('course_id');
        $chapter_id = $request->getParameter('chapter_id');
        $lesson_id = $request->getParameter('lesson_id');
        $resource_id = $request->getParameter('resource_id');

        $following_lesson_id = $request->getParameter('following_lesson_id');
        $previous_lesson_id = $request->getParameter('previous_lesson_id');

        // $this->course = Course::getRepository()->getById($course_id);
        // $this->chapter = Chapter::getRepository()->getById($chapter_id);
        // $this->lesson = Lesson::getRepository()->getById($lesson_id);

        $components_ids = array($course_id, $chapter_id, $lesson_id);

        if($resource_id != null){
            $components_ids[] = $resource_id;
        }

        $components = ComponentService::getInstance()->getComponents($components_ids);
        //get keys of data fliped for search
        $keys = array_flip($components->getPrimaryKeys());

        //set
        $this->course = $components->get($keys[$course_id]);
        $this->chapter = $components->get($keys[$chapter_id]);
        $this->lesson = $components->get($keys[$lesson_id]);

        //get resource is not in list
        if($resource_id != null){
            $this->resource = $components->get($keys[$resource_id]);
        }else{
            $this->resource = $this->lesson->getChildren()->getFirst();
        }

        if ($lesson_id != null) {
            $this->lesson->setActualResource($resource_id);
        } else if ($previous_lesson_id != null) {
            $this->lesson = $this->chapter->getNextChild($previous_lesson_id);
            if ($this->lesson == null)
                $this->lesson = $this->chapter->getChildren()->getFirst();
            $lesson_id = $this->lesson->getId();
        } else if ($following_lesson_id != null) {
            $this->lesson = $this->chapter->getPreviousChild($following_lesson_id);
            if ($this->lesson == null)
                $this->lesson = $this->chapter->getChildren()->getFirst();
            $lesson_id = $this->lesson->getId();
        } else {
            $this->lesson = $this->chapter->getChildren()->getFirst();
            $lesson_id = $this->lesson->getId();
        }
                        
        $this->has_next_resource = ($this->lesson->getNextResourceId() != null);
        $this->has_previous_resource = ($this->lesson->getPreviousResourceId() != null);

        $this->is_last_resource = $this->lesson->atLastResource();
        $this->is_first_resource = $this->lesson->atFirstResource();

        // //update log
        // LogService::getInstance()->viewResource(
        //                                 $this->getUser()->getProfile()->getId(), 
        //                                 Resource::TYPE,
        //                                 $this->course->getId(),
        //                                 $this->chapter->getId(),
        //                                 $this->lesson->getId(),
        //                                 $this->resource->getId()
        //                             );        

        //set ProfileComponentCompletedStatus
       if($this->getUser()->getAttribute("ComponentCompleteStatus") == null ||
            (
             !in_array($this->resource->getId(),$this->getUser()->getAttribute("ComponentCompleteStatus")) || 
             !in_array($this->lesson->getId(),$this->getUser()->getAttribute("ComponentCompleteStatus")) || 
             !in_array($this->chapter->getId(),$this->getUser()->getAttribute("ComponentCompleteStatus")) || 
             !in_array($this->course->getId(),$this->getUser()->getAttribute("ComponentCompleteStatus"))
            )
        ){
           ProfileComponentCompletedStatusService::getInstance()->add(
                                            $this->getProfile(),
                                            $this->resource,
                                            $this->lesson,
                                            $this->chapter,
                                            $this->course
                                        );
           
            $ids = array($this->resource->getId(),$this->lesson->getId(), $this->chapter->getId(), $this->course->getId());
            $this->getUser()->setAttribute("ComponentCompleteStatus", $this->getUser()->getAttribute("ComponentCompleteStatus") == null ? $ids: array_merge( $this->getUser()->getAttribute("ComponentCompleteStatus"), $ids));
            
        }
        

        // TODO: llevar a una
        $this->notes = NoteService::getInstance()->getNotes($this->getProfile()->getId(), $resource_id);
        $this->comments = array();
        // $this->comments = NoteService::getInstance()->getComments($resource_id);

        $this->type = $this->resource->getResourceData()->getFirst()->getType();
        
        $this->setLayout("layout_v2");
    }

    public function executeCreate(sfWebRequest $request) {
        $id = $request->getParameter("id");

        if ($id) {
            $form = new LessonForm(Lesson::getRepository()->getById($id));
        } else {
            $form = new LessonForm();
        }

        $values = $request->getParameter($form->getName());
        $response = Array(
            'status' => "error",
            'template' => "",
            'code' => 400
        );

        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            //create lesson
            $lesson = $form->save();

            //add lesson to chapter
            if (!$id)
                ChapterService::getInstance()->addLessonToChapter($values['chapter_id'], $lesson->getId());

            ComponentService::getInstance()->updateDuration( $lesson->getId() );

            $response['template'] = "Ha " . ($id ? "editado" : "creado") . " la lección satisfactoriamente";
            $response['status'] = "success";
        } else {
            $response['template'] = $this->getPartial("form", array('form' => $form));
        }

        if ($request->isXmlHttpRequest()) {
            return $this->renderText(json_encode($response));
        }

        return $this->renderText($response['template']);
    }


    public function executeList(sfWebRequest $request){
        $this -> lessons = Lesson::getRepository()->createQuery('l')
                ->limit(10)
                ->execute();

    }

    public function executeDependencyTree(sfWebRequest $request){
        //$course
        //$chapter
        $lesson_id     = $request->getParameter('lesson_id');
        $this->lesson  = ComponentService::getInstance()->find($lesson_id);
        $chapter       = ComponentService::getInstance()->getParents($lesson_id);
        $this->chapter = $chapter[0];
        $course        = ComponentService::getInstance()->getParents($this -> chapter->getId());
        $this->course  = $course[0];

        $this->courses = Course::getRepository()
                           ->createQuery('c')
                           ->orderBy("c.name")
                           ->execute();
        //$this -> lessons = LessonService::getInstance()->getDependencyPath($lesson_id);
 
    }

    /** Ajax request */
    public function executeDependencyPathList(sfWebRequest $request){
        //sfLoader::loadHelpers('Partial');
         sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');

        $course_id = $request->getParameter('course_id');
        $chapter_id = $request->getParameter('chapter_id');
        $lesson_id = $request->getParameter('lesson_id');

        $dp_list = LessonService::getInstance()->getDependencyPathList($course_id, $chapter_id, $lesson_id);

        $partial = get_partial('dependency_path_list', array('dp_list' => $dp_list));
        $response = Array(
            'status' => "error",
            'template' => $partial,
            'code' => 200
        );

        if ($request->isXmlHttpRequest()) {
            return $this->renderText(json_encode($response));
        }

        return $this->renderText($response['template']);
    }

    /** Ajax request */
    public function executeGetDependsLessonList(sfWebRequest $request){
        //sfLoader::loadHelpers('Partial');
        sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');

        $course_id = $request->getParameter('course_id');
        $chapter_id = $request->getParameter('chapter_id');
        $lesson_id = $request->getParameter('lesson_id');
        $depends_chapter_id = $request->getParameter('depends_chapter_id');

        /*
         * build query to bring the lesson based on course and chapter
         * and add a flag(based on DependencyPath) to check as selected
         */
        /*
        // Traer las lecciones para el curso y capitulo X
        // No se pueden traer por curso y capitulo, debido a la recursividad
        // No es un arbol jerarquico perfecto
        // Asi que se traen todas las lecciones del capitulo sin 
        // importar de que curso son
        */
        $lessons = ComponentService::getInstance()->getChilds($depends_chapter_id);
        $locals =  array('lessons' => $lessons,
                         'course_id' => $course_id,
                         'chapter_id' => $chapter_id,
                         'lesson_id' => $lesson_id);
 
        $partial = get_partial('depends_lesson_list', $locals);
        $response = Array(
            'status' => "error",
            'template' => $partial,
            'code' => 200
        );

        if ($request->isXmlHttpRequest()) {
            return $this->renderText(json_encode($response));
        }

        return $this->renderText($response['template']);
    }

    public function executeSaveDependency(sfWebRequest $request){
        $form = $request->getParameter('dependency_path');
        $depends_lesson_ids = $form['depends_lesson_id'];
        unset($form['depends_lesson_id']);

        foreach ($depends_lesson_ids as $key => $lesson_id){
            $form['depends_lesson_id'] = $lesson_id;
             LessonService::getInstance()->addDependencyToLesson($form);
        } 
        $response = Array(
            'status' => "error",
            'template' => "okookokk",
            'code' => 400
        ); 

        if ($request->isXmlHttpRequest()) {
            return $this->renderText(json_encode($response));
        }

        return $this->renderText($response['template']);
     }

    public function executeDeleteDependency(sfWebRequest $request){
        $dependency_path_id = $request->getParameter('dependency_path_id');
        LessonService::getInstance()->removeDependencyForLesson($dependency_path_id);

        $response = Array(
            'status' => "error",
            'template' => "okookokk",
            'code' => 400
        ); 

        if ($request->isXmlHttpRequest()) {
            return $this->renderText(json_encode($response));
        }

        return $this->renderText($response['template']);
    }

    public function executeExpanded2(sfWebRequest $request) {
        $course_id = $request->getParameter('course_id');
        $chapter_id = $request->getParameter('chapter_id');
        $lesson_id = $request->getParameter('lesson_id');

        $this->profile = $this->getProfile();

        $this->course = Course::getRepository()->getById($course_id);
        $this->chapter = Chapter::getRepository()->getById($chapter_id);
        if($lesson_id){
            $this->lesson = Lesson::getRepository()->getById($lesson_id);
        }else{
            $this->lesson = new Lesson();
        }
        $this->resource = new Resource();

        if ($request->isXmlHttpRequest()) {
            $response = Array(
                'status' => 'success',
                'template' => $this->getPartial('lesson/menu_lessons')
            );

            return $this->renderText(json_encode($response));
        }

        return $this->renderText($this->getPartial('lesson/menu_lessons'));
    }

}
