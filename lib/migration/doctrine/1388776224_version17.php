<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version17 extends Doctrine_Migration_Base
{
    public function up()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("ALTER TABLE log_view_component CHANGE component_id resource_id INT");

        $this->addColumn('log_view_component', 'course_id', 'integer', '8', array(
             ));
        $this->addColumn('log_view_component', 'chapter_id', 'integer', '8', array(
             ));
        $this->addColumn('log_view_component', 'lesson_id', 'integer', '8', array(
             ));
        // $this->addColumn('log_view_component', 'resource_id', 'integer', '8', array(
        //      ));
    }

    public function down()
    {
        $q = Doctrine_Manager::getInstance()->getCurrentConnection();
        $q->execute("ALTER TABLE log_view_component CHANGE resource_id component_id INT");

        $this->removeColumn('log_view_component', 'course_id');
        $this->removeColumn('log_view_component', 'chapter_id');
        $this->removeColumn('log_view_component', 'lesson_id');
        // $this->removeColumn('log_view_component', 'resource_id');
    }
}