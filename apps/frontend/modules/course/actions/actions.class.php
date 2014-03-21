<?php

/**
 * course actions.
 *
 * @package    kuepa
 * @subpackage course
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class courseActions extends kuepaActions {


    public function preExecute()
  {
    parent::preExecute();
    
    $this->setLayout("layout_v2");
  }
  
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->courses = ComponentService::getInstance()->getCoursesForUser( $this->getProfile() );        
    }

    public function executeTest(sfWebRequest $request) {
        $id = $request->getParameter("id");

        $this->course = Course::getRepository()->createQuery("c")
                            // ->select("*")
                            ->leftJoin("c.Chapter ch")
                            ->leftJoin("ch.Lesson l")
                            ->leftJoin("l.Resource r")
                            ->where("c.id = ?", $id)
                            ->fetchOne();
        // $this->courses = ComponentService::getInstance()->getCoursesForUser($this->getUser()->getGuardUser()->getProfile()->getId());
    }

    public function executeDetails(sfWebRequest $request) {
        $id = $request->getParameter("id");

        $this->profile = $this->getProfile();
        $course = Course::getRepository()->getById($id);
        
        $components = array();
        $components[] = $course; 
        
        foreach ($course->getChapters() as $chapter) {
            $components[] = $chapter;
            foreach ($chapter->getLessons() as $lesson){
                $components[] = $lesson;
                foreach ($lesson->getResources() as $resource) {
                    $components[] = $resource;
                }
            }
        }

        ComponentService::getInstance()->addCompletedStatus( $components, $this->profile );
        
        $this->course = $course;   
    }

    public function executeExpanded(sfWebRequest $request) {
        $course_id = $request->getParameter('course_id');
        $type = $request->getParameter('type', 'grid');

        $this->profile = $this->getProfile();

        $course = Course::getRepository()->getById($course_id);
        $chapters = $course->getChildren();

        $components = array();
        $components[] = $course;
        
        foreach ($chapters as $chapter) {
            $components[] = $chapter;
        }
        
        // ComponentService::getInstance()->addCompletedStatus( $components, $this->profile );
        
        $this->course = $course;
        $this->chapters = $chapters;
        
        if ($request->isXmlHttpRequest()) {
            $response = Array(
                'status' => 'success',
                'template' => $this->getPartial($type)
            );

            return $this->renderText(json_encode($response));
        }

        return $this->renderText($this->getPartial($type));
    }

    public function executeCreate(sfWebRequest $request) {
        
        $id = $request->getParameter("id");
        
        if( $id ) {
            $form = new CourseForm(Course::getRepository()->getById($id));
        } else {
            $form = new CourseForm();
        }
        
        $values = $request->getParameter($form->getName());
        $response = Array(
            'status' => "error",
            'template' => "",
            'code' => 400
        );

        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            //create course
            $course = $form->save();

            //add to user
            if(!$id)
                CourseService::getInstance()->addTeacher($course->getId(), $this->getProfile()->getId());

            ComponentService::getInstance()->updateDuration( $course->getId() );

            $response['template'] = "Ha ".($id?"editado":"creado")." el curso satisfactoriamente";
            $response['status'] = "success";
            $response['course_id'] = $course->getId();
        } else {
            $response['template'] = $this->getPartial("form", array('form' => $form));
        }

        if ($request->isXmlHttpRequest()) {
            return $this->renderText(json_encode($response));
        }

        return $this->renderText($response['template']);
    }

}
