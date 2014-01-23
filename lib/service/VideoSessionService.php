<?php

/**
 * Video Session Service
 *
 * @package    kuepa
 * @subpackage service
 * @author     CristalMedia
 *
 */
class VideoSessionService {

    private static $instance = null;
    public static $status_es = array(
        "pending"   => "Pendiente",
        "started"   => "En curso",
        "ended"     => "Finalizada"
    );

    public static $visibility_es = array(
        "public"    => "Pública",
        "private"   => "Privada"
    );

    const STATUS_PENDING    = 'pending';
    const STATUS_STARTED    = 'started';
    const STATUS_ENDED      = 'ended';

    const APP_ID            = 'eminent-expanse-427';
    const APP_ID_INT        = '36700081185';

    const TYPE_CLASS        = "class";
    const TYPE_SUPPORT      = "support";

    const PLATFORM_HANGOUTS = "hangouts";

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new VideoSessionService;
        }

        return self::$instance;
    }

    /**
     * Creates and persists a new video session
     *
     * @param type $profile_id the id of the creator's profile
     * @param type $curse_id the id of the related course
     * @param type $chapter_id the id of the related chapter
     * @param type $scheduled_for the date the video session is scheduled for
     * @param type $title the video session title
     * @param type $desription the video session description
     * @return \VideoSession the new video session
     */
    public function createVideoSession($profile_id, $type="class", $course_id = "", $chapter_id = "", $scheduled_for = "", $title = "", $desription = "") {

        $videoSession = new VideoSession();
        $videoSession->setProfileId($profile_id)
                ->setType($type)
                ->setCourseId($course_id)
                ->setChapterId($chapter_id)
                ->setScheduledFor($scheduled_for)
                ->setTitle($title)
                ->setDescription($desription)
                ->save();

        return $videoSession;
    }

    /**
     * Edits and persists an existing video session
     *
     * @param type $video_session_id the id of the video session being edited
     * @param type $values the modified values
     * @return \VideoSession the edited video session
     */
    public function editVideoSession($video_session_id, $values = array()) {
        $videoSession = VideoSession::getRepository()->find($video_session_id);

        if ($videoSession) {
            $values_keys = array('course_id', 'chapter_id', 'scheduled_for', 'title', 'description', 'url', 'status');

            foreach ($values_keys as $key) {

                if (isset($values[$key])) {
                    $videoSession->set($key, $values[$key]);
                }
            }

            $videoSession->save();
            return $videoSession;
        }

        return false;
    }

    /**
     *
     * @param type $video_session_id
     * @return type
     */
    public function delete($video_session_id) {
        $videoSession = VideoSession::getRepository()->find($video_session_id);

        if ($videoSession) {
            $videoSession->delete();
        }

        return;
    }

    /**
     *
     * @param type $video_session_id
     * @return type
     */
    public function deleteParticipants($video_session_id) {

        $q = Doctrine_Query::create()
            ->delete('VideoSessionParticipant vsp')
            ->where('vsp.video_session_id = ?',$video_session_id);

        return $q->execute();

    }

    /**
     *
     * @param string $video_session_id
     * @param array $participants_ids
     */
    public function updateParticipants($video_session_id, $participants_ids){
        $this->deleteParticipants($video_session_id);
        $participants_ids = array_unique($participants_ids);
        if(count($participants_ids)>0){
            foreach($participants_ids as $participant_id){
                $participant = new VideoSessionParticipant();
                $participant->setVideoSessionId($video_session_id);
                $participant->setProfileId($participant_id);
                $participant->save();
            }
        }
    }

    /**
     *
     * @param string $video_session_id
     * @param array $participants_ids
     */
    public function getParticipantsIds($video_session_id=""){

        if(empty($video_session_id)){
            return "";
        }

        $ids = array();
        $videoSessionParticipants = VideoSessionParticipant::getRepository()->findBy("video_session_id",$video_session_id);

        if (count($videoSessionParticipants) > 0) {
            foreach($videoSessionParticipants as $participant){
                $ids[] = $participant->getProfileId();
            }
        }

        return implode(",", $ids);
    }

    /**
     * Retrieves an array of the upcomming video sessions created by the user
     *
     * @param type $profile_id
     * @return array of \VideoSession
     */
    public function getNextVideoSessionsFromProfessor($profile_id) {

        return $this->getVideoSessionsFromProfessor(array(
            "next"          => true,
            "profile_id"    => $profile_id
        ));

    }

    /**
     * Retrieves an array of the past video sessions created by the user
     *
     * @param type $profile_id
     * @return \VideoSession
     */
    public function getPrevVideoSessionsFromProfessor($profile_id) {

        return $this->getVideoSessionsFromProfessor(array(
            "prev"          => true,
            "profile_id"    => $profile_id
        ));
    }

    /**
     * Retrieves an array of the previous or next video sessions created by the user
     * @param array $params
     * <ul>
     * <li><b>'next'</b> <i>boolean</i></li>
     * <li><b>'prev'</b> <i>boolean</i></li>
     * <li><b>'profile_id'</b> <i>boolean</i></li>
     * </ul>
     * @return \VideoSession[]
     * @throws Exception
     */
    public function getVideoSessionsFromProfessor($params = array()){

        $defaults   = array(
            "next"          => false,
            "prev"          => false,
            "profile_id"    => -1
        );

        $dateOp     = "<";
        $config     = $params + $defaults;

        if($config["next"] === true){
            $dateOp = ">";
        }

        if((int)$config["profile_id"] < 1){
            throw new Exception("Profile ID not specified");
        }

        $q = VideoSession::getRepository()->createQuery("vs")
                ->leftJoin('vs.Course c')
                ->where('vs.profile_id = ?', $config["profile_id"])
                ->andWhere("vs.type = 'class'")
                ->andWhere("vs.scheduled_for {$dateOp} NOW()")
                ->orderBy("vs.scheduled_for DESC");

        return $q->execute();

    }

    /**
     * Retrieves an array of the upcomming video sessions related to the user's courses
     *
     * @param type $profile_id
     * @return array of \VideoSession
     */
    public function getNextVideoSessionsForProfessor($profile_id) {

        return $this->getVideoSessionsForProfessor(array(
            "next"          => true,
            "profile_id"    => $profile_id
        ));

    }

    /**
     * Retrieves an array of the past video sessions related to the user's courses
     *
     * @param type $profile_id
     * @return \VideoSession
     */
    public function getPrevVideoSessionsForProfessor($profile_id) {

        return $this->getVideoSessionsForProfessor(array(
            "prev"          => true,
            "profile_id"    => $profile_id
        ));
    }

    /**
     * Retrieves an array of the upcomming video sessions related to the user's courses
     *
     * @param type $profile_id
     * @return array of \VideoSession
     */
    public function getNextVideoSessionsForUser($profile_id) {

        return $this->getVideoSessionsForUser(array(
            "next"          => true,
            "profile_id"    => $profile_id
        ));

    }

    /**
     * Retrieves an array of the past video sessions related to the user's courses
     *
     * @param type $profile_id
     * @return \VideoSession
     */
    public function getPrevVideoSessionsForUser($profile_id) {

        return $this->getVideoSessionsForUser(array(
            "prev"          => true,
            "profile_id"    => $profile_id
        ));
    }

    /**
     * Retrieves an array of the previous or next video sessions related to the user's courses
     * @param array $params
     * <ul>
     * <li><b>'next'</b> <i>boolean</i></li>
     * <li><b>'prev'</b> <i>boolean</i></li>
     * <li><b>'profile_id'</b> <i>boolean</i></li>
     * </ul>
     * @return \VideoSession[]
     * @throws Exception
     */
    public function getVideoSessionsForProfessor($params = array()){

        $defaults   = array(
            "next"          => false,
            "prev"          => false,
            "profile_id"    => -1
        );

        $dateOp     = "<";
        $config     = $params + $defaults;

        if($config["next"] === true){
            $dateOp = ">";
        }

        if((int)$config["profile_id"] < 1){
            throw new Exception("Profile ID not specified");
        }

        $courses = ComponentService::getInstance()->getCoursesForUser($config["profile_id"]);

        foreach($courses as $course){ $ids[]=$course->getId(); }


        $q = VideoSession::getRepository()->createQuery("vs")
                ->leftJoin('vs.Course c')
                ->where('c.id IN ('.implode(",", $ids).')')
                ->andWhere("vs.type = 'class'")
                ->andWhere("vs.scheduled_for {$dateOp} NOW()")
                ->orderBy("vs.scheduled_for DESC");

        return $q->execute();

    }

    /**
     * Retrieves an array of the previous or next video sessions related to the user's courses
     * @param array $params
     * <ul>
     * <li><b>'next'</b> <i>boolean</i></li>
     * <li><b>'prev'</b> <i>boolean</i></li>
     * <li><b>'profile_id'</b> <i>boolean</i></li>
     * </ul>
     * @return \VideoSession[]
     * @throws Exception
     */
    public function getVideoSessionsForUser($params = array()){

        $defaults   = array(
            "next"          => false,
            "prev"          => false,
            "profile_id"    => -1
        );

        $dateOp     = "<";
        $config     = $params + $defaults;

        if($config["next"] === true){
            $dateOp = ">";
        }

        if((int)$config["profile_id"] < 1){
            throw new Exception("Profile ID not specified");
        }

        $courses = ComponentService::getInstance()->getCoursesForUser($config["profile_id"]);

        foreach($courses as $course){ $courses_ids[]=$course->getId(); }

        //Retrieves public related video_session
        $qPublic = VideoSession::getRepository()->createQuery("vs")
                ->leftJoin('vs.Course c')
                ->where('c.id IN ('.implode(",", $courses_ids).')')
                ->andWhere("vs.type = 'class'")
                ->andWhere("vs.scheduled_for {$dateOp} NOW()")
                ->andWhere("vs.visibility = 'public'")
                ->orderBy("vs.scheduled_for DESC");

        //Private related video_session where the user is invited
        $qPrivate = VideoSession::getRepository()->createQuery("vs")
                ->innerJoin("vs.VideoSessionParticipant vsp")
                ->innerJoin('vs.Course c')
                ->where('c.id IN ('.implode(",", $courses_ids).')')
                ->andWhere("vs.type = 'class'")
                ->andWhere("vsp.profile_id = {$config["profile_id"]}")
                ->andWhere("vs.scheduled_for {$dateOp} NOW()");

        return $qPublic->execute()->merge($qPrivate->execute());

    }

    /**
     * Flags a video session as started
     * @param int $video_session_id
     */
    public function startVideoSession($video_session_id){
        $videoSession = VideoSession::getRepository()->find($video_session_id);
        $videoSession->setStatus(VideoSessionService::STATUS_STARTED);
        $videoSession->save();
    }

    /**
     * Flags a video session as ended
     * @param int $video_session_id
     */
    public function endVideoSession($video_session_id){
        $videoSession = VideoSession::getRepository()->find($video_session_id);
        $videoSession->setStatus(VideoSessionService::STATUS_ENDED);
        $videoSession->save();
    }

    /**
     * Updates the hangout url of a video_session so users can join
     * @param int $video_session_id
     * @param string $url
     */
    public function updateHangoutUrl($video_session_id, $hangout_url){
        $videoSession = VideoSession::getRepository()->find($video_session_id);
        $videoSession->setHangoutUrl($hangout_url);
        $videoSession->save();
    }

    public function getPendingSupportSessions(){
        return $this->getSupportSessions("pending");
    }

    public function getHistoricSupportSessions(){
        return $this->getSupportSessions("historic");
    }

    public function getSupportSessions($type){

        $status = $type == "pending" ? "IN ('pending','started')" : "= 'ended'";

        $q = VideoSession::getRepository()->createQuery("vs")
                ->leftJoin('vs.Course c')
                ->where("vs.type = 'support'")
                ->andWhere("vs.status {$status}")
                ->orderBy("vs.scheduled_for DESC");

        return $q->execute();
    }

    /**
     *
     * @param string $url
     * @param string $pid
     * @return string
     */
    public function injectProfileId($url="",$pid=""){
        if(!empty($url)){
            $decoded    = urldecode($url);
            $noParams   = substr($decoded, 0, strrpos($decoded, "{"));
            $params     = json_decode(substr($decoded,  strrpos($decoded, "{")));
            $params->profile_id = $pid;
            $newParams  = json_encode($params);
            return $noParams.urlencode($newParams);
        }
        return $url;
    }

}
