<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version12 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('resource_data', 'reading_time', 'integer', '8', array(
             'default' => '0',
             ));
    }

    public function down()
    {
        $this->removeColumn('resource_data', 'reading_time');
    }
}