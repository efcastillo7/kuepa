<?php

/**
 * chapter actions.
 *
 * @package    kuepa
 * @subpackage chapter
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class chapterActions extends kuepaActions {

    /**
     * POST /chapter
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
                $form = new ChapterForm;
            } else {
                $form = new ChapterForm( Chapter::getRepository()->find($id) );
            }
            
            $form->setValidator('_csrf_token', new sfValidatorPass);

            $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

            if (!$form->isValid()) {
                throw new BadRequest;
            }

            // create chapter
            // note(diego): should we move this to a service instead of using doctrine forms for the creation?
            $chapter = $form->save();

            //add to user
            if(!$id) {
                CourseService::getInstance()->addChapterToCourse($form->getValue('course_id'), $chapter->getId());
            }
            
            $response['status'] = 'success';
            $response['course_id']  = $chapter->getId();
            $response['uri'] = $this->getContext()->getRouting()->generate('chapter_get', Array('id' => $chapter->getId()));

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
     * GET /chapter
     *
     * @param sfRequest $request A request object
     */
    public function executeList(sfWebRequest $request) {
        return $this->renderText('list');
    }

    /**
     * GET /chapter/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeGet(sfWebRequest $request) {
        try {
            $chapter = Chapter::getRepository()->find($request->getParameter('id'));

            if (!$chapter) {
                throw new ComponentNotFound;
            }

            return $this->renderText(json_encode($chapter->toArray()));
        } catch (ComponentNotFound $e) {
            $this->getResponse()->setStatusCode(404);

            return $this->renderText(json_encode(Array('status' => 'error')));
        } catch (Exception $e) {
            $this->getResponse()->setStatusCode(500);

            return $this->renderText(json_encode(Array('status' => 'error')));
        }
    }

    /**
     * PUT /chapter/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeEdit(sfWebRequest $request) {
        return $this->update($request);
    }

    /**
     * DELETE /chapter/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeDelete(sfWebRequest $request) {
        return $this->renderText('delete');
    }

}
