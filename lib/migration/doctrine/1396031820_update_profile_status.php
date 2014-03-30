<?php

class UpdateProfileStatus extends Doctrine_Migration_Base
{
  public function up()
  {
  	$q = Doctrine_Manager::getInstance()->getCurrentConnection();
        // set all profiles as 'cursando'
        $query = "
        INSERT INTO profile_learning_path_status VALUES (null, 'Cursando'), (null, 'Aprobada');
        ";
        $q->execute($query);

        $query = "
        UPDATE profile_learning_path set profile_learning_path_status_id = 1;
        ";
        $q->execute($query);
  }

  public function down()
  {
  }
}
