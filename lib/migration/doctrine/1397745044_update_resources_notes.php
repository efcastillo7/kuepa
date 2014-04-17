<?php

class UpdateResourcesNotes extends Doctrine_Migration_Base
{
  public function up()
  {
  	$q = Doctrine_Manager::getInstance()->getCurrentConnection();
        // set all profiles as 'cursando'
        $query = "
        UPDATE profile_component_completed_status pccs SET avg_note = (
			SELECT 
				coalesce(avg(ea.value), null)
			FROM exercise_attemp ea inner join exercise e on ea.exercise_id = e.id  
				 inner join resource_data rd on e.id = rd.content
			WHERE
				rd.type = 'Exercise' and
				pccs.profile_id = ea.profile_id and
				pccs.component_id = rd.resource_id
			GROUP BY
				ea.profile_id, rd.resource_id
		);
        ";
        $q->execute($query);

        $query = "
        UPDATE profile_component_completed_status pccs SET attemps = (
			SELECT 
				coalesce(count(*), null)
			FROM exercise_attemp ea inner join exercise e on ea.exercise_id = e.id  
				 inner join resource_data rd on e.id = rd.content
			WHERE
				rd.type = 'Exercise' and
				pccs.profile_id = ea.profile_id and
				pccs.component_id = rd.resource_id
			GROUP BY
				ea.profile_id, rd.resource_id
		);
        ";
        $q->execute($query);
  }

  public function down()
  {
  }
}
