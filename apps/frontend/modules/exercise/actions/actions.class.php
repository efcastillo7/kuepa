<?php

/**
 * exercise actions.
 *
 * @package    kuepa
 * @subpackage exercise
 * @author     fiberbunny
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class exerciseActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {

    }

    public function executeEdit(sfWebRequest $request) {
        $this->lesson_id = $request->getParameter("lesson_id");
        $this->exercise_id = $request->getParameter('exercise_id');

        if ($this->exercise_id) {
            $exercise = Exercise::getRepository()->find($this->exercise_id);
            $this->questions = ExerciseService::getInstance()->getQuestions($this->exercise_id);
        } else {
            $exercise = new Exercise();
            $this->questions = array();
        }

        $this->form = new ExerciseForm($exercise);
    }

    public function executeCreate(sfWebRequest $request) {
        $id = $request->getParameter('id');

        if (!empty($id)) {
            $exercise = Exercise::getRepository()->find($id);
        } else {
            $exercise = new Exercise();
        }

        $form = new ExerciseForm($exercise);

        $response = Array(
            'status' => "error",
            'template' => "",
            'code' => 400
        );

        $params = $request->getParameter($form->getName());

        $form->bind( $params, $request->getFiles($form->getName()) );

        if ($form->isValid()) {

            $exercise = $form->save();

            ExerciseService::getInstance()->editResource($exercise,$request->getParameter("lesson_id"),$this->getUser()->getProfile()->getId());

            $response['template'] = "Ha " . ($id ? "editado" : "creado") . " el ejercicio satisfactoriamente";
            $response['status'] = "success";
            $response['exercise_id'] = $exercise->getId();
        } else {
            $errors = array();
            foreach ($form->getErrorSchema()->getErrors() as $error) {
                $errors[] = $error->__toString();
            }
            $response["errors"] = json_encode($errors);
            $response['template'] = $this->renderText("Error");
        }

        if ($request->isXmlHttpRequest()) {
            return $this->renderText(json_encode($response));
        }

        return $this->renderText($response['template']);
    }

    public function executeEditItemForm(sfWebRequest $request) {

        //Gets the question and exercise ids
        $exercise_id = $request->getParameter('exercise_id');
        $question_id = $request->getParameter('question_id');

        //Gets the question
        $question = ExerciseQuestion::getRepository()->find($question_id);
        $answers = $question->getAnswers();

        //Default response
        $response = Array(
            'status' => "error",
            'template' => "No se encontró la pregunta #{$question_id}",
            'code' => 400
        );

        //If the question doesn't exist throws an error
        if (!$question) {
            return $this->renderText(json_encode($response));
        }

        //Creates a question form
        $form = new ExerciseQuestionForm($question);

        //Depending on the type generates the HTML
        switch ($question->getType()) {
            case "introduction":
                $subQuestions = ExerciseService::getInstance()->getQuestions($exercise_id, $question_id);
                $response['form'] = $this->getPartial("edit_question_form", array("form" => $form, "exercise_id" => $exercise_id));
                $response['template'] = $this->getPartial("edit_introduction", array("questions" => $subQuestions, "exercise_id" => $exercise_id));
                $response['status'] = "success";
                break;
            case "multiple-choice": case "multiple-choice2": case "true-false":
                $response['form'] = $this->getPartial("edit_question_form", array("form" => $form, "exercise_id" => $exercise_id));
                $response['template'] = $this->getPartial("edit_question_choice", array("answers" => $answers, "question" => $question));
                break;
            case "open":
                $response['form'] = $this->getPartial("edit_question_form", array("form" => $form, "exercise_id" => $exercise_id));
                $response['template'] = $this->getPartial("edit_question_open", array());
                break;
            case "complete":
                $response['form'] = $this->getPartial("edit_question_form", array("form" => $form, "exercise_id" => $exercise_id));
                $response['template'] = $this->getPartial("edit_question_complete", array("answer" => $answers[0]));
                break;
            case "relation":
                $answers_items = $question->getItems();
                $response['form'] = $this->getPartial("edit_question_form", array("form" => $form, "exercise_id" => $exercise_id));
                $response['template'] = $this->getPartial("edit_question_relation", array("answers" => $answers, "answers_items" => $answers_items));
                break;
            case "interactive":
                $response['form'] = $this->getPartial("edit_question_form", array("form" => $form, "exercise_id" => $exercise_id));
                $response['template'] = $this->getPartial("edit_question_interactive", array("answers" => $answers));
                break;
        }

        return $this->renderText(json_encode($response));
    }

    public function executeRemoveItem(sfWebRequest $request) {
        $question_id = $request->getParameter('question_id');
        $exercise_id = $request->getParameter('exercise_id');

        $remove = ExerciseService::getInstance()->removeItem($exercise_id, $question_id);

        if ($remove) {
            $response = Array(
                'status' => "success",
                'template' => "Item removed successfuly",
                'code' => 200
            );
        } else {
            $response = Array(
                'status' => "error",
                'template' => "Item removed successfuly",
                'code' => 400
            );
        }


        return $this->renderText(json_encode($response));
    }

    public function executeRemoveAnswer(sfWebRequest $request) {
        $answer_id = $request->getParameter('answer_id');

        $remove = ExerciseService::getInstance()->removeAnswer($answer_id);

        if ($remove) {
            $response = Array(
                'status' => "success",
                'template' => "Answer removed successfuly",
                'code' => 200
            );
        } else {
            $response = Array(
                'status' => "error",
                'template' => "Error while removing answer",
                'code' => 400
            );
        }


        return $this->renderText(json_encode($response));
    }

    public function executeRemoveAnswerItem(sfWebRequest $request) {
        $answer_item_id = $request->getParameter('answer_item_id');

        $remove = ExerciseService::getInstance()->removeAnswerItem($answer_item_id);

        if ($remove) {
            $response = Array(
                'status' => "success",
                'template' => "Answer item removed successfuly",
                'code' => 200
            );
        } else {
            $response = Array(
                'status' => "error",
                'template' => "Error while removing item",
                'code' => 400
            );
        }


        return $this->renderText(json_encode($response));
    }

    public function executeEditItem(sfWebRequest $request) {
        $id = $request->getParameter('id');
        $exercise_id = $request->getParameter('exercise_id');

        if ($id) {
            $question = ExerciseQuestion::getRepository()->find($id);
        } else {
            $question = new ExerciseQuestion();
        }

        $form = new ExerciseQuestionForm($question);

        $response = Array(
            'status' => "error",
            'template' => "",
            'code' => 400
        );

        $params = $request->getParameter($form->getName());

        $form->bind($params, $request->getFiles($form->getName()));

        if ($form->isValid()) {

            $question = $form->save();

            ExerciseService::getInstance()->saveQuestion($question, $request->getPostParameters());

            $response['template'] = "Ha " . ($id ? "editado" : "creado") . " la pregunta satisfactoriamente";
            $response['status'] = "success";
            $response['question_id'] = $question->getId();
            $response['value'] = $value = ExerciseService::getInstance()->getQuestionValue($exercise_id, $id);
        } else {
            $errors = array();
            foreach ($form->getErrorSchema()->getErrors() as $error) {
                $errors[] = $error->__toString();
            }

            $response["errors"] = json_encode($errors);
            $response['template'] = "Error";
        }

        if ($request->isXmlHttpRequest()) {
            return $this->renderText(json_encode($response));
        }

        return $this->renderText($response['template']);
    }

    public function executeAddItem(sfWebRequest $request) {
        $exercise_id = $request->getParameter('exercise_id');
        $type = $request->getParameter('type');
        $parent_id = $request->getParameter('parent_id');

        $question_id = ExerciseService::getInstance()->addItem($exercise_id, $type, $parent_id);

        $response = Array(
            'status' => "success",
            'question_id' => $question_id,
            'template' => "Item added successfuly",
            'code' => 200
        );

        return $this->renderText(json_encode($response));
    }

    public function executeAddAnswer(sfWebRequest $request) {
        $question_id = $request->getParameter('question_id');

        $answer_id = ExerciseService::getInstance()->addAnswer($question_id);

        $response = Array(
            'status' => "success",
            'answer_id' => $answer_id,
            'template' => "Answer added successfuly",
            'code' => 200
        );

        if (!$answer_id) {
            $response = Array(
                'status' => "error",
                'template' => "Error while adding answer",
                'code' => 200
            );
        }

        return $this->renderText(json_encode($response));
    }

    public function executeAddAnswerItem(sfWebRequest $request) {
        $question_id = $request->getParameter('question_id');

        $answer_item_id = ExerciseService::getInstance()->addAnswerItem($question_id);

        $response = Array(
            'status' => "success",
            'answer_item_id' => $answer_item_id,
            'template' => "Answer added successfuly",
            'code' => 200
        );

        if (!$answer_item_id) {
            $response = Array(
                'status' => "error",
                'template' => "Error while adding answer",
                'code' => 200
            );
        }

        return $this->renderText(json_encode($response));
    }

    public function executeOrder(sfWebRequest $request) {
        $params = $request->getPostParameters();

        $exercise_id = $request->getParameter("exercise_id");

        foreach ($params as $id => $order) {
            if ((int) $id > 0) {
                ExerciseService::getInstance()->updateOrder($exercise_id, $id, $order);
            }
        }

        $response = Array(
            'status' => "success",
            'template' => "Items reordered",
            'code' => 200
        );

        return $this->renderText(json_encode($response));
    }

    public function executeValidate(sfWebRequest $request) {
        $exercise_id = $request->getParameter('exercise_id');
        $user_id = $this->getUser()->getProfile()->getId();

        $values = $request->getPostParameters();
        $answers = $values['exercise'][$exercise_id];

        //get exercise
        $exercise = Exercise::getRepository()->find($exercise_id);

        //evaluate
        $correct_values = $exercise->evaluate($answers);

        //save response
        ExerciseService::getInstance()->saveAttemp($user_id, $exercise_id, 0, $correct_values['score'], $values);

        //update stats
        $resource_ids = ExerciseService::getInstance()->getResourceIdsArray($exercise_id);
        ProfileComponentCompletedStatusService::getInstance()->addExerciseAttemp($user_id, $resource_ids, $correct_values['score']);

        //get attemps
        $attemps = ExerciseService::getInstance()->getAttemps($user_id, $exercise_id);

        $r_attemps = array();

        foreach ($attemps as $attemp) {
            $r_attemps[] = $attemp->getValue();
        }

        //get question ids
        $question_ids = array();
        foreach ($correct_values['questions'] as $key => $value) {
            //if response is not correct
            if (!$value['correct']) {
                $question_ids[] = $key;
            }
        }

        //exercise dependencies
        $dependencies_arr = LearningPathService::getInstance()->getExerciseDependencyPathList($exercise->getId(), $question_ids);
        $dependencies = array();

        foreach ($dependencies_arr as $dependency) {
            $dependencies[] = array(
                'course' => array('id' => $dependency->getDependsCourse()->getId(), 'name' => $dependency->getDependsCourse()->getName(), 'color' => $dependency->getDependsCourse()->getColor(), 'image' => $dependency->getDependsCourse()->getThumbnailPath()),
                'chapter' => array('id' => $dependency->getDependsChapter()->getId(), 'name' => $dependency->getDependsChapter()->getName()),
                'lesson' => array('id' => $dependency->getDependsLesson()->getId(), 'name' => $dependency->getDependsLesson()->getName()),
            );
        }

        $ar_response = array(
            'exercise' => array(
                'id' => $exercise_id,
                'questions' => array('count' => $exercise->getQuestions()->count()),
                'score' => array('total' => $exercise->getTotalScore(), 'value' => $correct_values['score']),
            ),
            'questions' => $correct_values['questions'],
            'attemps' => $r_attemps,
            'dependencies' => $dependencies
        );

        if ($request->isXmlHttpRequest()) {
            $response = Array(
                'status' => 'success',
                'data' => $ar_response
            );

            return $this->renderText(json_encode($response));
        }

        return $this->renderText(json_encode($ar_response));
    }

}
