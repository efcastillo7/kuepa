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
     * POST /lesson
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
                $form = new LessonForm;
            } else {
                $form = new LessonForm( Lesson::getRepository()->getById($id) );
            }
            
            $form->setValidator('_csrf_token', new sfValidatorPass);

            $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

            if (!$form->isValid()) {
                throw new BadRequest;
            }

            // create lesson
            // note(diego): should we move this to a service instead of using doctrine forms for the creation?
            $lesson = $form->save();

            //add to user
            if(!$id) {
                ChapterService::getInstance()->addLessonToChapter($form->getValue('chapter_id'), $lesson->getId());
            }
            
            $response['status'] = 'success';
            $response['lesson_id']  = $lesson->getId();
            $response['uri'] = $this->getContext()->getRouting()->generate('lesson_get', Array('id' => $lesson->getId()));

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
     * GET /lesson
     *
     * @param sfRequest $request A request object
     */
    public function executeList(sfWebRequest $request) {
        return $this->renderText('list');
    }

    /**
     * GET /lesson/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeGet(sfWebRequest $request) {
        try {
            $lesson = Lesson::getRepository()->getById($request->getParameter('id'));

            if (!$lesson) {
                throw new LessonNotFound;
            }

            return $this->renderText(json_encode($lesson->toArray()));
        } catch (ComponentNotFound $e) {
            $this->getResponse()->setStatusCode(404);

            return $this->renderText(json_encode(Array('status' => 'error')));
        } catch (Exception $e) {
            $this->getResponse()->setStatusCode(500);

            return $this->renderText(json_encode(Array('status' => 'error')));
        }
    }

    /**
     * PUT /lesson/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeEdit(sfWebRequest $request) {
        return $this->update($request);
    }

    /**
     * DELETE /lesson/{id}
     *
     * @param sfRequest $request A request object
     */
    public function executeDelete(sfWebRequest $request) {
        return $this->renderText('delete');
    }

}
