<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version13 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->addColumn('profile_component_completed_status', 'velocity_index', 'float', '', array(
             ));
        $this->addColumn('profile_component_completed_status', 'completitud_index', 'float', '', array(
             ));
        $this->addColumn('profile_component_completed_status', 'skill_index', 'float', '', array(
             ));
        $this->addColumn('profile_component_completed_status', 'persistence_index', 'float', '', array(
             ));
        $this->addColumn('profile_component_completed_status', 'effort_index', 'float', '', array(
             ));
        $this->addColumn('profile_component_completed_status', 'efficiency_index', 'float', '', array(
             ));
        $this->addColumn('profile_component_completed_status', 'learning_index', 'float', '', array(
             ));
    }

    public function down()
    {
        $this->removeColumn('profile_component_completed_status', 'velocity_index');
        $this->removeColumn('profile_component_completed_status', 'completitud_index');
        $this->removeColumn('profile_component_completed_status', 'skill_index');
        $this->removeColumn('profile_component_completed_status', 'persistence_index');
        $this->removeColumn('profile_component_completed_status', 'effort_index');
        $this->removeColumn('profile_component_completed_status', 'efficiency_index');
        $this->removeColumn('profile_component_completed_status', 'learning_index');
    }
}