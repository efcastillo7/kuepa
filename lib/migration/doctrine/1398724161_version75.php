<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version75 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('flash_message', 'sf_guard_group_id', 'integer', '8', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('flash_message', 'sf_guard_group_id');
    }
}