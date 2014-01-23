<?php

/**
 * learningpath actions.
 *
 * @package    kuepa
 * @subpackage learningpath
 * @author     kibind
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class learningpathActions extends sfActions
{
    /**
     * POST /learningpath
     *
     * @param sfRequest $request A request object
     */
    public function executeCreate(sfWebRequest $request) {
        $course_id = $request->getParameter('course_id');
        $chapter_id = $request->getParameter('chapter_id');
        $lesson_id = $request->getParameter('lesson_id');
        $profile_id = $this->getUser()->getProfile()->getId();

        $ret = array();

        if($course_id && $chapter_id && $lesson_id){
        	$plp = LearningPathService::getInstance()->addNodeToPath($profile_id, $course_id, $chapter_id, $lesson_id);

        	if($plp){
	        	$ret = array(
	        		'id' => $plp->getId(),
	        		'position' => $plp->getPosition(),
	        		'course' => array('id' => $plp->getCourse()->getId(), 'name' => $plp->getCourse()->getName(), 'color' => $plp->getCourse()->getColor(), 'image' => $plp->getCourse()->getThumbnailPath()),
	        		'chapter' => array('id' => $plp->getChapter()->getId(),'name' =>  $plp->getChapter()->getName()),
	        		'lesson' => array('id' => $plp->getLesson()->getId(),'name' =>  $plp->getLesson()->getName()),
	    		);
        	}else{
        		$this->getResponse()->setStatusCode('409');
        	}
        }

        return $this->renderText(json_encode($ret));
    }

    public function executeAdddependencies(sfWebRequest $request) {
        $course_id = $request->getParameter('course_id');
        $chapter_id = $request->getParameter('chapter_id');
        $lesson_id = $request->getParameter('lesson_id');
        $exercise_id = $request->getParameter('exercise_id');
        $question_ids = $request->getParameter('question_ids ');
        $profile_id = $this->getUser()->getProfile()->getId();

        $ret = array();
        $dependencies = array();

        if($course_id && $chapter_id && $lesson_id){
            //get dependencies
            $dependencies = LessonService::getInstance()->getDependencyPathList($course_id, $chapter_id, $lesson_id);
        }elseif($exercise_id){
            //dependencies for that exercise
            $dependencies = LearningPathService::getInstance()->getExerciseDependencyPathList($exercise_id, $question_ids);
        }

        foreach ($dependencies as $dependency) {
            $plp = LearningPathService::getInstance()->addNodeToPath($profile_id, $dependency->getDependsCourseId(), $dependency->getDependsChapterId(), $dependency->getDependsLessonId());

            if($plp){
                $ret[] = array(
                    'id' => $plp->getId(),
                    'position' => $plp->getPosition(),
                    'course' => array('id' => $plp->getCourse()->getId(), 'name' => $plp->getCourse()->getName(), 'color' => $plp->getCourse()->getColor(), 'image' => $plp->getCourse()->getThumbnailPath()),
                    'chapter' => array('id' => $plp->getChapter()->getId(),'name' =>  $plp->getChapter()->getName()),
                    'lesson' => array('id' => $plp->getLesson()->getId(),'name' =>  $plp->getLesson()->getName()),
                );
            }
        }

        return $this->renderText(json_encode($ret));
    }

    /**
     * GET /learningpath
     *
     * @param sfRequest $request A request object
     */
    public function executeList(sfWebRequest $request) {
    	$profile_id = $this->getUser()->getProfile()->getId();

        $list = LearningPathService::getInstance()->getNodeList($profile_id);

        $ret = array();

        foreach ($list as $plp) {
        	$ret[] = array(
        		'id' => $plp->getId(),
        		'position' => $plp->getPosition(),
        		'course' => array('id' => $plp->getCourse()->getId(), 'name' => $plp->getCourse()->getName(), 'color' => $plp->getCourse()->getColor(), 'image' => $plp->getCourse()->getThumbnailPath()),
        		'chapter' => array('id' => $plp->getChapter()->getId(),'name' =>  $plp->getChapter()->getName()),
        		'lesson' => array('id' => $plp->getLesson()->getId(),'name' =>  $plp->getLesson()->getName()),
    		);
        }

        return $this->renderText(json_encode($ret));
    }

    /**
     * GET /learningpath/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeGet(sfWebRequest $request) {
        
    }

    /**
     * PUT /learningpath/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeEdit(sfWebRequest $request) {
        return $this->renderText('edit');
    }

    /**
     * DELETE /learningpath/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeDelete(sfWebRequest $request) {
        $profile_id = $this->getUser()->getProfile()->getId();
        $id = $request->getParameter("id");

        LearningPathService::getInstance()->deleteNodeFromPathID($profile_id, $id);

        return $this->renderText('ok');
    }

}
