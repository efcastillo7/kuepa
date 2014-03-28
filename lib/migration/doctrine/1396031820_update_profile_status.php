<?php

class UpdateProfileStatus extends Doctrine_Migration_Base
{
  public function up()
  {
  	$q = Doctrine_Manager::getInstance()->getCurrentConnection();
        // set all profiles as 'cursando'
        $query = "
        UPDATE profile_learning_path set profile_learning_path_status_id = 1
        ";
        $q->execute($query);
  }

  public function down()
  {
  }
}
