<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version2 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->changeColumn('learning_path', 'enabled', 'boolean', '25', array(
             'default' => '1',
             ));
    }

    public function down()
    {

    }
}