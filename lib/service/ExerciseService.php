<?php

class ExerciseService {

    private static $instance = null;
    private static $ICONS = array(
        "introduction" => "icon-info-sign",
        "multiple-choice" => "icon-check",
        "multiple-choice2" => "icon-check",
        "complete" => "icon-pencil",
        "relation" => "icon-resize-horizontal",
        "open" => "icon-align-left",
        "interactive" => "icon-picture"
    );

    /**
     *
     * @return ExerciseService
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new ExerciseService;
        }

        return self::$instance;
    }

    public function getIconFor($type) {

        if (array_key_exists($type, self::$ICONS)) {
            return self::$ICONS[$type];
        }

        return "";
    }

    public function find($id) {
        return Exercise::getRepository()->find($id);
    }

    /**
     *
     * @param type $exercise_id
     * @param type $type
     */
    public function addItem($exercise_id, $type, $parent_id = "") {
        $question = new ExerciseQuestion();
        $question
                ->setType($type)
                ->save();

        $exercise_question = new ExerciseHasExerciseQuestion();
        $exercise_question
                ->setExerciseId($exercise_id)
                ->setExerciseParentQuestionId($parent_id)
                ->setExerciseQuestionId($question->getId())
                ->save();

        return $question->getId();
    }

    /**
     *
     * @param type $exercise_id
     * @param type $type
     */
    public function addAnswerItem($question_id) {
        $question = ExerciseQuestion::getRepository()->find($question_id);

        if (!$question) {
            return false;
        }

        $answer_item = new ExerciseAnswerItem();
        $answer_item->setQuestion($question)
                ->save();

        return $answer_item->getId();
    }

    /**
     *
     * @param type $exercise_id
     * @param type $type
     */
    public function addAnswer($question_id) {
        $question = ExerciseQuestion::getRepository()->find($question_id);

        if (!$question) {
            return false;
        }

        $answer = new ExerciseAnswer();
        $answer->setQuestion($question)
                ->save();

        return $answer->getId();
    }

    /**
     *
     * @param type $exercise_id
     * @param type $type
     */
    public function RemoveItem($exercise_id, $question_id) {
        $q = ExerciseHasExerciseQuestion::getRepository()->createQuery('ex')
                ->delete("ExerciseHasExerciseQuestion")
                ->where('exercise_id = ? AND (exercise_question_id = ? OR exercise_parent_question_id = ?)', array($exercise_id, $question_id, $question_id));

        return $q->execute();
    }

    /**
     *
     * @param type $exercise_id
     * @param type $type
     */
    public function RemoveAnswer($answer_id) {
        $answer = ExerciseAnswer::getRepository()->find($answer_id);
        if ($answer) {
            return $answer->delete();
        }
        return false;
    }

    /**
     *
     * @param type $exercise_id
     * @param type $type
     */
    public function RemoveAnswerItem($answer_item_id) {
        $answer_item = ExerciseAnswerItem::getRepository()->find($answer_item_id);
        if ($answer_item) {
            return $answer_item->delete();
        }
        return false;
    }

    public function getQuestions($exercise_id, $parent_id = "") {
        $exercise = Exercise::getRepository()->find($exercise_id);
        return $exercise->getQuestionsByLevel($parent_id);
    }

    public function getQuestionValue($exercise_id, $id = "") {
        $exercise = Exercise::getRepository()->find($exercise_id);
        $value = $exercise->getQuestionValueByLevel($id);
        return $value > 0 ? $value : 0;
    }

    public function updateOrder($exercise_id, $question_id, $order) {
        $q = ExerciseHasExerciseQuestion::getRepository()->createQuery("eheq")
                ->update()
                ->set("position", $order)
                ->where("exercise_id = ?", $exercise_id)
                ->andWhere("exercise_question_id = ?", $question_id);

        return $q->execute();
    }

    public function saveAttemp($profile_id, $exercise_id, $time_taken = 0, $value = 0, $data = array()) {
        $exAttemp = new ExerciseAttemp();
        $exAttemp->setProfileId($profile_id)
                ->setExerciseId($exercise_id)
                ->setValue($value)
                ->setTimeTaken($time_taken)
                ->setContent(serialize($data))
                ->save();
    }

    public function getAttemps($profile_id, $exercise_id) {
        $q = Doctrine::getTable("ExerciseAttemp")->createQuery('ea')
                ->where('profile_id = ? and exercise_id = ?', array($profile_id, $exercise_id))
                ->orderBy('created_at asc');

        return $q->execute();
    }

    public function getCountQuestions($exercise_id, $parent_id = "") {
        $q = Doctrine::getTable("ExerciseHasExerciseQuestion")->createQuery('eheq')
                ->select('count(exercise_question_id)')
                ->where('exercise_id = ?', array($exercise_id));
        if (empty($parent_id)) {
            $q->andWhere("eheq.exercise_parent_question_id IS NULL");
        } else {
            $q->andWhere("eheq.exercise_parent_question_id = ?", $parent_id);
        }
        $qty = $q->execute(array(), Doctrine::HYDRATE_SINGLE_SCALAR);
        return( $qty );
    }

    public function saveQuestion($question, $params) {

        //Depending on the type generates the HTML
        switch ($question->getType()) {
            case "introduction": case "open": default: return;
            case "complete": $this->saveCompleteQuestion($question, $params); break;
            case "multiple-choice": case "multiple-choice2": $this->saveMultipleQuestion($question, $params); break;
            case "relation": $this->saveRelationQuestion($params); break;
        }
    }

    private function saveCompleteQuestion($question, $params) {

        //Gets and saves the answer
        $answers = $question->getAnswers();

        if ($answers) {
            $answer = $answers[0];
        } else {
            $answer = new ExerciseAnswer();
            $answer->setQuestion($question);
        }

        $answer->setTitle($params["exercise_answer"])
                ->save();

        $updates = array();
        $new = array();
        $ids = array();

        foreach ($params as $name => $value) {

            //Gets the existing answer items and saves them
            if (preg_match_all("/complete\-value\-(\d+)/", $name, $matches)) {
                $id = $matches[1][0];
                if (!array_key_exists($id, $updates)) {
                    $updates[$id] = array();
                }
                $updates[$id]["value"] = $value;
            }

            //Gets the existing answer items and saves them
            if (preg_match_all("/complete\-text\-(\d+)/", $name, $matches)) {
                $id = $matches[1][0];
                if (!array_key_exists($id, $updates)) {
                    $updates[$id] = array();
                }
                $updates[$id]["text"] = $value;
            }

            //Gets the existing answer items and saves them
            if (preg_match_all("/complete\-value\-new\-(\d+)/", $name, $matches)) {
                $id = $matches[1][0];
                if (!array_key_exists($id, $new)) {
                    $new[$id] = array();
                }
                $new[$id]["value"] = $value;
            }

            //Gets the existing answer items and saves them
            if (preg_match_all("/complete\-text\-new\-(\d+)/", $name, $matches)) {
                $id = $matches[1][0];
                if (!array_key_exists($id, $new)) {
                    $new[$id] = array();
                }
                $new[$id]["text"] = $value;
            }
        }

        foreach ($updates as $id => $update) {
            $answer_item = ExerciseAnswerItem::getRepository()->find($id);
            $answer_item->setTitle($update["text"])
                    ->setValue($update["value"])
                    ->setAnswer($answer)
                    ->save();

            $ids[] = $answer_item->getId();
        }

        foreach ($new as $id => $item) {
            $answer_item = new ExerciseAnswerItem();
            $answer_item->setTitle($item["text"])
                    ->setValue($item["value"])
                    ->setAnswer($answer)
                    ->save();

            $ids[] = $answer_item->getId();
        }

        //Deletes garbage
        $used_ids = implode(",", $ids);
        $d = ExerciseAnswerItem::getRepository()->createQuery()
                ->delete("ExerciseAnswerItem")
                ->where("exercise_answer_id = ?", $answer->getId())
                ->andWhere("id NOT IN ({$used_ids})")
                ->execute();
    }

    private function saveMultipleQuestion($question, $params) {

        $question->setType($params["type"]);
        $question->save();

        $updates = array();

        foreach ($params as $name => $value) {

            //Gets the existing answer items and saves them
            if (preg_match_all("/answer\-value\-(\d+)/", $name, $matches)) {
                $id = $matches[1][0];
                if (!array_key_exists($id, $updates)) {
                    $updates[$id] = array();
                }
                $updates[$id]["value"] = $value;
            }

            //Gets the existing answer items and saves them
            if (preg_match_all("/answer\-text\-(\d+)/", $name, $matches)) {
                $id = $matches[1][0];
                if (!array_key_exists($id, $updates)) {
                    $updates[$id] = array();
                }
                $updates[$id]["text"] = $value;
            }

            //Gets the existing answer items and saves them
            if (preg_match_all("/answer\-correct\-(\d+)/", $name, $matches)) {
                $id = $matches[1][0];
                if (!array_key_exists($id, $updates)) {
                    $updates[$id] = array();
                }
                $updates[$id]["correct"] = $value;
            }
        }

        foreach ($updates as $id => $update) {
            $answer = ExerciseAnswer::getRepository()->find($id);
            $answer->setTitle($update["text"])
                    ->setValue($update["value"])
                    ->setCorrect($update["correct"])
                    ->save();
        }
    }

    private function saveRelationQuestion($params) {

        $answers_data = array();
        $relations_data = array();

        foreach ($params as $name => $value) {

            //Gets the existing answer items and saves them
            if (preg_match_all("/relation\-answer\-value\-(\d+)/", $name, $matches)) {
                $id = $matches[1][0];
                if (!array_key_exists($id, $answers_data)) {
                    $answers_data[$id] = array();
                }
                $answers_data[$id]["value"] = $value;
            }

            //Gets the existing answer items and saves them
            if (preg_match_all("/relation\-answer\-text\-(\d+)/", $name, $matches)) {
                $id = $matches[1][0];
                if (!array_key_exists($id, $answers_data)) {
                    $answers_data[$id] = array();
                }
                $answers_data[$id]["text"] = $value;
            }

            //Gets the existing answer items and saves them
            if (preg_match_all("/relation\-item\-related\-(\d+)/", $name, $matches)) {
                $id = $matches[1][0];
                if (!array_key_exists($id, $relations_data)) {
                    $relations_data[$id] = array();
                }
                $relations_data[$id]["related"] = $value;
            }

            //Gets the existing answer items and saves them
            if (preg_match_all("/relation\-item\-text\-(\d+)/", $name, $matches)) {
                $id = $matches[1][0];
                if (!array_key_exists($id, $relations_data)) {
                    $relations_data[$id] = array();
                }
                $relations_data[$id]["text"] = $value;
            }

        }

        foreach ($answers_data as $id => $answer_data) {
            $answer = ExerciseAnswer::getRepository()->find($id);
            $answer->setTitle($answer_data["text"])
                    ->setValue($answer_data["value"])
                    ->save();
        }

        foreach ($relations_data as $id => $relation) {
            $answer_item = ExerciseAnswerItem::getRepository()->find($id);
            $answer_item->setTitle($relation["text"])
                    ->setExerciseAnswerId($relation["related"])
                    ->save();
        }
    }

}
