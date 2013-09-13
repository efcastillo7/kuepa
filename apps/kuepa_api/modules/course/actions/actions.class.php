<?php

/**
 * course actions.
 *
 * @package    kuepa
 * @subpackage course
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class courseActions extends sfActions {

    /**
     * POST /course
     *
     * @param sfRequest $request A request object
     */
    public function executeCreate(sfWebRequest $request) {
        try {
            $form = new CourseForm;
            $values = $request->getParameter($form->getName());

            $form->bind($values);

            if (!$form->isValid()) {
                throw new BadRequest;
            }

            // create course
            // note(diego): should we move this to a service instead of using doctrine forms for the creation?
            $course = $form->save();

            //add to user
            CourseService::getInstance()->addTeacher($course->getId(), $this->getProfile()->getId());
            
            $response['status'] = 'success';
            $response['id']  = $course->getId();
            $response['uri'] = $this->getContext()->getRouting()->generate('course_get', Array('id' => $course->getId()));

            $this->getResponse()->setStatusCode(201);
            
            return $this->renderText(json_encode($response));
        } catch (BadRequest $e) {
            $this->getResponse()->setStatusCode(400);

            return $this->renderText(json_encode(Array('status' => 'error')));
        } catch (Exception $e) {
            $this->getResponse()->setStatusCode(500);

            return $this->renderText(json_encode(Array('status' => 'error')));
        }
    }

    /**
     * GET /course
     *
     * @param sfRequest $request A request object
     */
    public function executeList(sfWebRequest $request) {
        return $this->renderText('list');
    }

    /**
     * GET /course/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeGet(sfWebRequest $request) {
        try {
            $course = Course::getRepository()->find($request->getParameter('id'));

            if (!$course) {
                throw new ComponentNotFound;
            }

            return $this->renderText(json_encode($course->toArray()));
        } catch (ComponentNotFound $e) {
            $this->getResponse()->setStatusCode(404);

            return $this->renderText(json_encode(Array('status' => 'error')));
        } catch (Exception $e) {
            $this->getResponse()->setStatusCode(500);

            return $this->renderText(json_encode(Array('status' => 'error')));
        }
    }

    /**
     * PUT /course/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeEdit(sfWebRequest $request) {
        return $this->renderText('edit');
    }

    /**
     * DELETE /course/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeDelete(sfWebRequest $request) {
        return $this->renderText('delete');
    }

}
