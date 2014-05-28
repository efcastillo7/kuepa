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

    public function getExerciseDependencyPathList($exercise_id, $exercise_question_id = null){
        $q = DependencyExercisePath::getRepository()->createQuery("dp")
                ->innerJoin("dp.DependsCourse dco")
                ->innerJoin("dp.DependsChapter dch")
                ->innerJoin("dp.DependsLesson dl")
                ->where("exercise_id = ?", $exercise_id)
                ->orderBy("dl.id asc");

        if($exercise_question_id){
            if(is_array($exercise_question_id)){
                $q->andWhereIn('exercise_question_id', $exercise_question_id);
            }else{
                $q->andWhere("exercise_question_id = ?", $exercise_question_id);   
            }
        }

        return($q->execute());
    }

    public function getLearningWayNodes($profile_id){
        $q = LearningWayItem::getRepository()->createQuery('lwi')
                ->innerJoin("lwi.LearningWay lw")
                ->innerJoin("lw.ProfileHasLearningWay phlw")
                ->where("phlw.profile_id = ?", $profile_id)
                ->orderBy('lwi.position asc');
                
        return $q->execute();

    }

    public function addLearningWaysToProfile($profile_id, $learning_ways = array()){
        if(count($learning_ways)){
            try{
                foreach ($learning_ways as $lwid) {
                    $lw = new ProfileHasLearningWay();
                    $lw->setProfileId($profile_id)
                       ->setLearningWayId($lwid)
                       ->save();
                }
            }catch(Exception $e){
                //exception only occurs if user already has that learning way
            }
        }

        return true;
    }
}
