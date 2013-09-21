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

    /**
     * POST /course
     *
     * @param sfRequest $request A request object
     */
    public function executeCreate(sfWebRequest $request) {
        return $this->update($request);
    }
    
    private function update(sfWebRequest $request) {
        try {
            $id = $request->getParameter("id");
            
            if(!$id) {
                $form = new CourseForm;
            } else {
                $form = new CourseForm( Course::getRepository()->find($id) );
            }
            
            $form->setValidator('_csrf_token', new sfValidatorPass);

            $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

            if (!$form->isValid()) {
                throw new BadRequest;
            }

            // create course
            // note(diego): should we move this to a service instead of using doctrine forms for the creation?
            $course = $form->save();

            //add to user
            if(!$form->isNew()) {
                CourseService::getInstance()->addTeacher($course->getId(), $this->getProfile()->getId());
            }
            
            $response['status'] = 'success';
            $response['course_id']  = $course->getId();
            $response['uri'] = $this->getContext()->getRouting()->generate('course_get', Array('id' => $course->getId()));

            $this->getResponse()->setStatusCode(201);
            
            return $this->renderText(json_encode($response));
        } catch (BadRequest $e) {
            $this->getResponse()->setStatusCode(400);
            
            $response = Array('status' => 'error');
            
            $response['form_errors'] = Array();
            
            foreach($form->getErrorSchema()->getErrors() as $field => $e) {
                $response['form_errors'][$field] = strval($e);
            }
                    
            return $this->renderText(json_encode($response));
        } catch (Exception $e) {
            $this->getResponse()->setStatusCode(500);
            throw $e;

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
        return $this->update($request);
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
