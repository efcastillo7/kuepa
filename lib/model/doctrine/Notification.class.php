<?php

/**
 * Notification
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    kuepa
 * @subpackage model
 * @author     CristalMedia
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Notification extends BaseNotification {
    public static function getRepository() {
        return Doctrine_Core::getTable('Notification');
    }
}
