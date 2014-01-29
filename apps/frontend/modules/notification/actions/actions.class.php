<?php

/**
 * notification actions.
 *
 * @package    kuepa
 * @subpackage notification
 * @author     CristalMedia
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class notificationActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        if ($this->getUser()->isAuthenticated()) {
            $this->profile = $this->getUser()->getGuardUser()->getProfile();

            //get the first message
            $this->notifications = NotificationsService::getInstance()->getNotificationsForUser($this->profile->getId());
            $this->count = NotificationsService::getInstance()->getUnreadNotificationsCountForUser($this->profile->getId());
        }
    }

    /**
     *
     * @param sfWebRequest $request
     */
    public function executeSet_seen(sfWebRequest $request) {
        $notification_id = $request->getParameter("id");
        $profile_id = $this->getUser()->getGuardUser()->getProfile()->getId();

        $response = Array(
            'status' => "error",
            'template' => "No se puediron marcar como leídas las notificaciones",
            'code' => 400
        );

        if ($notification_id) {
            NotificationsService::getInstance()->markNotificationAsRead($profile_id, $notification_id);
        } else {
            NotificationsService::getInstance()->markAllNotificationsAsRead($profile_id);
        }

        $response['template'] = "Notificaciones marcadas como leídas";
        $response['status'] = "success";

        return $this->renderText(json_encode($response));
    }

    /**
     *
     * @param sfWebRequest $request
     */
    public function executeSet_interacted(sfWebRequest $request) {
        $notification_id = $request->getParameter("id");

        $response = Array(
            'status' => "error",
            'template' => "No se pudo marcar la notificación como interactuada",
            'code' => 400
        );

        $notification = Notification::getRepository()->find($notification_id);

        if ($notification) {
            $notification
                ->setClickedAt(date("Y-m-d h:m:s"))
                ->save();
            $response['template'] = "Notificación marcada como interactuada";
            $response['status'] = "success";
        }

        return $this->renderText(json_encode($response));
    }

    public function executeRefresh(sfWebRequest $r){

        $last = $r->getParameter("last_id");
        $p_count = $r->getParameter("count");

        $count = empty($p_count) ? 10 : $p_count;

        if ($this->getUser()->isAuthenticated()) {
            $this->profile = $this->getUser()->getGuardUser()->getProfile();

            //get the first message
            $this->notifications = NotificationsService::getInstance()->getNotificationsForUser($this->profile->getId(),$count,$last);
            $this->count = NotificationsService::getInstance()->getUnreadNotificationsCountForUser($this->profile->getId());
        }

    }

}
