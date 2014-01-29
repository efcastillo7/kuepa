<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version33 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('notification', array(
             'id' =>
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '8',
             ),
             'notification_action_id' =>
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             'profile_id' =>
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             'seen' =>
             array(
              'type' => 'bit',
              'length' => '',
             ),
             'clicked_at' =>
             array(
              'type' => 'timestamp',
              'length' => '25',
             ),
             'created_at' =>
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'primary' =>
             array(
              0 => 'id',
             ),
             ));
        $this->createTable('notification_action', array(
             'id' =>
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '8',
             ),
             'term_key' =>
             array(
              'type' => 'string',
              'length' => '',
             ),
             'profile_id' =>
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             'route_name' =>
             array(
              'type' => 'string',
              'length' => '',
             ),
             'params' =>
             array(
              'type' => 'blob',
              'length' => '',
             ),
             'wildcards' =>
             array(
              'type' => 'blob',
              'length' => '',
             ),
             'type' =>
             array(
              'type' => 'string',
              'length' => '50',
             ),
             'created_at' =>
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'primary' =>
             array(
              0 => 'id',
             ),
             ));
        $this->createTable('video_session_participant', array(
             'id' =>
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '8',
             ),
             'video_session_id' =>
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             'profile_id' =>
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             'first_conection' =>
             array(
              'type' => 'timestamp',
              'length' => '25',
             ),
             'last_connection' =>
             array(
              'type' => 'timestamp',
              'length' => '25',
             ),
             'interruptions' =>
             array(
              'type' => 'int',
              'length' => '',
             ),
             'seconds_online' =>
             array(
              'type' => 'int',
              'length' => '',
             ),
             'created_at' =>
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' =>
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'deleted_at' =>
             array(
              'notnull' => '',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'primary' =>
             array(
              0 => 'id',
             ),
             ));
        $this->addColumn('video_session', 'visibility', 'enum', '', array(
             'values' =>
             array(
              0 => 'public',
              1 => 'private',
             ),
             'default' => 'public',
             ));
    }

    public function down()
    {
        $this->dropTable('notification');
        $this->dropTable('notification_action');
        $this->dropTable('video_session_participant');
        $this->removeColumn('video_session', 'visibility');
    }
}