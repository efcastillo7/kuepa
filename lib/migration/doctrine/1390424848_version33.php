<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version33 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->removeColumn('video_session_participant', 'deleted_at');
    }

    public function down()
    {
        $this->addColumn('video_session_participant', 'deleted_at', 'timestamp', '25', array(
             'notnull' => '',
             ));
    }
}