<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version21 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('predictive_learning_path', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '8',
              'autoincrement' => '1',
              'primary' => '1',
             ),
             'profile_id' => 
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             'course_id' => 
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             'chapter_id' => 
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             'lesson_id' => 
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             'position' => 
             array(
              'type' => 'integer',
              'length' => '8',
             ),
             'protected' => 
             array(
              'type' => 'boolean',
              'length' => '25',
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
             ), array(
             'primary' => 
             array(
              0 => 'id',
             ),
             ));
    }

    public function down()
    {
        $this->dropTable('predictive_learning_path');
    }
}