<?php

class LearningPathService {

    private static $instance = null;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new LearningPathService;
        }

        return self::$instance;
    }

    public function addNodeToPath($profile_id, $course_id, $chapter_id, $lesson_id, $protected = false){
        $position = $this->getLastIndex($profile_id)+1;
        $plp = null;

        try{
            $plp = new PredictiveLearningPath();
            $plp->setProfileId($profile_id)
                ->setCourseId($course_id)
                ->setChapterId($chapter_id)
                ->setLessonId($lesson_id)
                ->setPosition($position)
                ->setProtected($protected)
                ->save();
        }catch(Exception $e){
            $plp = null;
        }

        return $plp;
    }

    public function deleteNodeFromPathID($profile_id, $id){
        $plp = PredictiveLearningPath::getRepository()->createQuery('plp')
                ->where('profile_id = ? and id = ?', array($profile_id, $id))
                ->fetchOne();

        if($plp){
            $position = $plp->getPosition();

            //delete
            $plp->delete();

            //update order
            $q = PredictiveLearningPath::getRepository()->createQuery('plp')
                    ->update()
                    ->set('position', 'position -1')
                    ->where('position > ?', $position)
                    ->execute();
        }

        return;
    }

    public function deleteNodeFromPath($profile_id, $course_id, $chapter_id, $lesson_id){
        $plp = PredictiveLearningPath::getRepository()->createQuery('plp')
                ->where('profile_id = ? and course_id = ? and chapter_id = ? and lesson_id = ?', array($profile_id, $course_id, $chapter_id, $lesson_id))
                ->fetchOne();

        if($plp){
            $position = $plp->getPosition();

            //delete
            $plp->delete();

            //update order
            $q = PredictiveLearningPath::getRepository()->createQuery('plp')
                    ->update()
                    ->set('position', 'position -1')
                    ->where('position > ?', $position)
                    ->execute();
        }

        return;
    }

    public function getNodeList($profile_id){
        $plp = PredictiveLearningPath::getRepository()->createQuery('plp')
                ->where('profile_id = ?', $profile_id)
                ->orderBy('position asc')
                ->execute();

        return $plp;
    }

    public function getLastIndex($profile_id){
        $q = PredictiveLearningPath::getRepository()->createQuery('plp')
                ->select('MAX(position) as position')
                ->where('profile_id = ?', $profile_id)
                ->fetchOne();

        if($q){
            return $q->getPosition();
        }

        return 0;
    }

    public function getExerciseDependencyPathList($exercise_id){
        $q = DependencyExercisePath::getRepository()->createQuery("dp")
                ->where("exercise_id = ?", $exercise_id);

        return($q->execute());
    }

    public function getExerciseQuestionDependencyPathList($exercise_id, $exercise_question_id){
        $q = DependencyExercisePath::getRepository()->createQuery("dp")
                ->where("exercise_id = ?", $exercise_id)
                ->andWhere("exercise_question_id = ?", $exercise_question_id);

        return($q->execute());
    }
}
