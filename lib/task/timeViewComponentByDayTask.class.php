<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of timeViewComponentByDayTask
 *
 * @author ppicatto
 */
class timeViewComponentByDayTask extends kuepaBaseTask
{
	
	protected function configure()
	{
		parent::preConfigure();
		
		$this->name = 'time-view-component-by-day';
		$this->briefDescription = 'Genera los datos de la tabla time_view_component_by_day.';
		$this->detailedDescription = <<<EOF
La tarea [time-view-component-by-day|INFO] realiza el calculo de tiempo en el que el usuario se encuentra en el sitio sumando todas las updated_at agrupadas por dia, profile y recurso de la tabla LogViewComponent.
Call it with: [php symfony kuepa:time-view-component-by-day|INFO]
EOF;
                $this->addArgument('ayer', sfCommandArgument::OPTIONAL, 'Generar todos los registros. [1 = true - 0 = false]');
	}

	public function doExecute($arguments = array(), $options = array())
	{		
             $this->log('--- Comienzo de ejecucion: "time-view-component-by-day"');
             
             $ayer = isset($arguments["ayer"]) ? (boolean) $arguments["ayer"] : true;
             $q = Doctrine_Manager::getInstance()->getCurrentConnection();
             $query = "
                    INSERT INTO time_view_component_by_day (
                            profile_id, 
                            course_id,
                            chapter_id,
                            lesson_id,
                            resource_id,
                            type,
                            time_view,
                            day
                    )
                    SELECT 
                            l.profile_id AS l__profile_id,
                            l.course_id AS l__course_id,
                            l.chapter_id AS l__chapter_id,
                            l.lesson_id AS l__lesson_id,
                            l.resource_id AS l__resource_id,
                            l.type AS l__type,
                            SUM(TIME_TO_SEC(l.updated_at) - TIME_TO_SEC(l.created_at)) AS time_view,
                            date(l.updated_at) AS day 
                    FROM log_view_component l
                    ";
                    $query .= $ayer ? ' WHERE date(updated_at) = CURDATE() - INTERVAL 1 DAY '  :' ';
                    $query .= "GROUP BY 
                            l.profile_id,
                            l.course_id,
                            l.chapter_id,
                            l.lesson_id,
                            l.resource_id,
                            DAY(l.updated_at)
                    HAVING SUM(TIME_TO_SEC(l.updated_at) - TIME_TO_SEC(l.created_at)) > 0
                    ORDER BY day asc";
             $result = $q->execute($query);
             
             $this->log('--- Se cargo con exito la tabla: "time-view-component-by-day"');
        }
}
