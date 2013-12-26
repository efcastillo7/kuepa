<?php

class ExerciseService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new ExerciseService;
        }

        return self::$instance;
    }

    public function find($id){
        return Exercise::getRepository()->find($id);
    }

    public function saveAttemp($profile_id, $exercise_id, $time_taken = 0, $value = 0, $data = array()){
        $exAttemp = new ExerciseAttemp();
        $exAttemp->setProfileId($profile_id)
                 ->setExerciseId($exercise_id)
                 ->setValue($value)
                 ->setTimeTaken($time_taken)
                 ->setContent(serialize($data))
                 ->save();
    }

    public function getAttemps($profile_id, $exercise_id){
        $q = Doctrine::getTable("ExerciseAttemp")->createQuery('ea')
                ->where('profile_id = ? and exercise_id = ?', array($profile_id, $exercise_id))
                ->orderBy('created_at asc');

        return $q->execute();
    }

    public function getCountQuestions($exercise_id){
        $q = Doctrine::getTable("ExerciseHasExerciseQuestion")->createQuery('eheq')
             ->select('count(exercise_question_id)')
             ->where('exercise_id = ?', array($exercise_id ) );
        $qty = $q->execute(array(),Doctrine::HYDRATE_SINGLE_SCALAR);
        return( $qty );
    }
}
