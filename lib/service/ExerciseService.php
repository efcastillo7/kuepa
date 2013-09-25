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
}
