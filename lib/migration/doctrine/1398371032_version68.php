<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version68 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('flash_message', 'college_id', 'integer', '8', array(
             ));
        $this->addColumn('flash_message', 'position', 'integer', '8', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('flash_message', 'college_id');
        $this->removeColumn('flash_message', 'position');
    }
}