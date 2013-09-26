<?php

/**
 * ExerciseQuestion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    kuepa
 * @subpackage model
 * @author     fiberbunny
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class ExerciseQuestion extends BaseExerciseQuestion {

    public function evaluate($answer) {
        $score = array();
        switch ($this->getType()) {
            case "multiple-choice":
                //$answer es el ID del ExerciseAnswer elegido
                $exercise_answer = ExerciseAnswer::getRepository()->find($answer);
                $score[$answer] = $exercise_answer->getCorrect();
                break;
            case "multiple-choice2":
                //$answer es un array de IDS de ExerciseAnswer
                foreach ($answer as $exercise_answer_id) {
                    $exercise_answer = ExerciseAnswer::getRepository()->find($exercise_answer_id);
                    $score[$exercise_answer_id] = $exercise_answer->getCorrect();
                }
                break;
            case "complete":
            case "relation":
                //$answer es un array de strings del complete
                if (preg_match_all('/\[(.*?)\]/', $this->getAnswers()->getFirst()->getTitle(), $correct_answer_strings)) {
                    foreach ($correct_answer_strings[1] as $position => $one_correct_answer) {
                        $score[$position] = false;
                        foreach (explode(",", $one_correct_answer) as $one_correct_possible_answer) {
                            if (strtolower(trim($one_correct_possible_answer)) == strtolower(trim($answer[$position]))) {
                                $score[$position] = true;
                                break;
                            }
                        }
                    }
                }
                break;
            case "open":
                break;
            default:
                break;
        }
        return $score;
    }

}
