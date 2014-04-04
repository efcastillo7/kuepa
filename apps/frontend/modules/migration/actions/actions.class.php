<?php

/**
 * migration actions.
 *
 * @package    kuepa
 * @subpackage migration
 * @author     fiberbunny
 */
class migrationActions extends sfActions
{
	public function replaceChars($text){
		return $text;
		// return htmlentities($text);
	}

	public function executeExercise(sfWebRequest $request){
		$course = strtoupper($request->getParameter("course"));
		$quiz = $request->getParameter("quiz");
		$lesson_id = $request->getParameter("to");

		$mysql_conn = mysqli_connect("70.32.82.167","remote","r3m0teUS45%2","z110k_$course");
    	mysqli_query($mysql_conn, "SET NAMES utf8;");


    	$query = "select * from quiz where active = 1";
    	if($quiz){
    		$query .= " and id = " . $quiz;
    	}

    	$rexercises = mysqli_query($mysql_conn,$query);
    	$exercises = array();

    	while($rexcercise = mysqli_fetch_array($rexercises)){
    		$exercise_id = $rexcercise['id'];

    		//questions
    		$questions = array();
			$rquestions = mysqli_query($mysql_conn,"select * from quiz_question where id in (select question_id from quiz_rel_question where exercice_id = $exercise_id) order by position asc");

			while($rquestion = mysqli_fetch_array($rquestions)){
				$question_id = $rquestion['id'];

				//get answers
				$ranswers = mysqli_query($mysql_conn,"select * from quiz_answer where question_id = $question_id order by position asc");
				$answers = array();

				while($ranswer = mysqli_fetch_array($ranswers)){
					$answers[] = array(
						'title' => $ranswer['answer'],
						'correct' => $ranswer['correct'],
						'comment' => $ranswer['comment'],
						'ponderation' => $ranswer['ponderation'],
					);
				}

				/** Parseo de imagenes */
				$copy = true;
				$texto = $rquestion['description'];
				$regex = "/src=\"(.*?)\"/";
				preg_match_all($regex, $texto, $match);
				$urls = $match[1];
				$base_path_relative =  "/uploads/resources/$course/images/";

				//Cracion de directorios
				$base_path =  sfConfig::get('sf_upload_dir') . "/resources";
				if(!file_exists($base_path) && $copy){
					mkdir($base_path);
				}
				$base_path .= "/$course";
				if(!file_exists($base_path) && $copy){
					mkdir($base_path);
				}
				//images path
				if(!file_exists($base_path . "/images") && $copy){
					mkdir($base_path . "/images");
				}

				foreach($urls as $url){
					$pos = strrpos($url,"/");
					$imgname = str_replace(
						array(" ", "%", "/", "\""),
						array("-", "-", "-", "-"), 
						substr($url, $pos+1));

					// Se reemplazan todas a excepcion las que sean imagenes o  links externos
					// como las de las formulas http://latex.codecogs.com/
					if(strpos($url,"kuepa.com") !== false){
						$texto = str_replace($url, $base_path_relative. $imgname, $texto);
					}

					if(strpos($url,"http") === false){
						$url = "http://www.kuepa.com" . $url;
					}
					if(!file_exists($base_path . "/images/" . $imgname) && $copy)
						copy($url, $base_path . "/images/" . $imgname);
				}
				$questions[] = array(
					'title' => $rquestion['question'],
					'description' => $texto,
					'ponderation' => $rquestion['ponderation'],
					'position' => $rquestion['position'],
					'type' => $rquestion['type'],
					'numeration_label' => $rquestion['numeration_label'],
					'answers' => $answers
				);


			}

    		//add to array
    		$exercises[] = array(
    			'title' => $rexcercise['title'],
    			'description' => $rexcercise['description'],
    			'type' => $rexcercise['type'],
    			'max_attempt' => $rexcercise['max_attempt'],
    			'start_time' => $rexcercise['start_time'],
    			'end_time' => $rexcercise['end_time'],
    			'random' => $rexcercise['random'],
    			'results_disabled' => $rexcercise['results_disabled'],
    			'expired_time' => $rexcercise['expired_time'],
    			'questions' => $questions
			);
    	}

    	$this->exercises = $exercises;

    	mysqli_close($mysql_conn);

    	// $data = explode("::", "[Argentina] queda en la regiÃ³n [sur] de AmÃ©rica. La provincia [Ushuaia] es la provincia mÃ¡s al [austral] del mundo. ::10,10,10,5");
    	// echo var_dump($data);
    	// return;

    	$profile_id = $this->getUser()->getProfile()->getId();

    	$lesson = Lesson::getRepository()->getById($lesson_id);

    	for($i=0;$i<count($exercises);$i++){

    		//add exercise
    		$nexercise = new Exercise();
    		$nexercise->setTitle($exercises[$i]['title'])
    				 ->setDescription($exercises[$i]['description'])
    				 ->save();

    		//questions
    	    foreach($exercises[$i]['questions'] as $question){
    	    	switch ($question['type']) {
    	    		case 1:
    	    			$type = "multiple-choice";
    	    			break;
    	    		case 2:
    	    			$type = "multiple-choice2";
    	    			break;
    	    		case 3:
    	    			$type = "complete";
    	    			break;
    	    		case 4:
    	    			$type = "choose";
    	    			break;
    	    		case 5:
    	    			$type = "open";
    	    			break;
    	    		default:
    	    			$type = "multiple-choice";
    	    			break;
    	    	}

    	    	$nquestion = new ExerciseQuestion();
    	    	$nquestion->setTitle($question['title'])
    	    			  ->setDescription($question['description'])
    	    			  ->setValue($question['ponderation'])
    	    			  ->setType($type)
    	    			  ->save();

    	    	//set posible answers
    	        foreach($question['answers'] as $answer){
    	        	$nanswer = new ExerciseAnswer();
    	        	$nanswer->setComment($answer['comment'])
    	        		    ->setCorrect($answer['correct'])
    	        		    ->setExerciseQuestionId($nquestion->getId());
    	        		    
    	        	if($type == "complete"){
    	        		$data = explode("::", $answer['title']);
    	        		$nanswer->setValue($data[1]);
    	        		$nanswer->setTitle($data[0]);
    	        	}else{
    	        		$nanswer->setTitle($answer['title']);
						$nanswer->setValue($answer['ponderation']);
    	        	}

    	        	$nanswer->save();
    	        }

    	        //add question to exercise
    	        $exenn = new ExerciseHasExerciseQuestion();
    	        $exenn->setExerciseId($nexercise->getId())
    	        	  ->setExerciseQuestionId($nquestion->getId())
    	        	  ->setPosition(1)
    	        	  ->save();
			}


    		//add resource
	    	$resource = ResourceService::getInstance()->create(array(
				'name' => $exercises[$i]['title'],
				'description' => "",
				'profile_id' => $profile_id
			));

			$rec = new ResourceDataExercise();
			$rec->setResourceId($resource->getId())
				->setContent($nexercise->getId())
				->setEnabled(true)
				->setDuration(1)
				->save();

    		LessonService::getInstance()->addResourceToLesson($lesson->getId(), $resource->getId());
        	ComponentService::getInstance()->updateDuration($resource->getId());

    	}

	}	


 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$this->setTemplate("index2");

  	$persist = true;
  	$copy = true;
  	$copy_video = false;

    $mysql_conn = mysqli_connect("70.32.82.167","remote","r3m0teUS45%2","110k_dokeos_main");
    mysqli_query($mysql_conn, "SET NAMES utf8;");

    $course_code = $request->getParameter("course");

    $rlessons = mysqli_query($mysql_conn,"select * from course c 
			inner join curso_leccion cl on c.code = cl.course_code
			inner join leccion l on cl.leccion_id = l.leccion_id
			inner join unidad u on l.idunidad = u.idunidad
		where
			c.code = '$course_code'
		order by 
			cl.orden");

    $lessons = array();
    $unidades = array();

    while($rless = mysqli_fetch_array($rlessons))
	{
		if(!isset($unidades[$rless['idunidad']])){
			$unidades[$rless['idunidad']] = array(
				'nombre' => $this->replaceChars($rless['nombreunidad']),
				'lessons' => array()
			);
		}

		$lesson_id = $rless['leccion_id'];

		$lesson = array(
			'id' => $rless['leccion_id'],
			'nombre' => $this->replaceChars($rless['leccion_nombre']),
			'unidad' => $this->replaceChars($rless['nombreunidad']),
			'descripcion' => $this->replaceChars($rless['observacion']),
			'cantidad_palabras' => $rless['cantidad_palabras'],
			'recursos' => array()
		);

		$rtrec = mysqli_query($mysql_conn, "SELECT  r.CodiRecu AS id, r.NombRecu AS nombre, '' AS url, o.orden AS orden, r.TipoRecu
			    FROM  recurso r
			     INNER JOIN leccion_recursos l ON r.CodiRecu  = l.recursos_id
			     INNER JOIN ordenobjetosleccion o ON o.idobjeto  = l.leccion_recursos_id AND nombretabla = 'leccion_recursos'
			    WHERE o.leccion_id = '$lesson_id'
			    UNION 
			    SELECT  l.id, l.nombre, l.url, o.orden AS orden, '' AS TipoRecu
			    FROM  leccion_enlaces l
			     INNER JOIN ordenobjetosleccion o ON o.idobjeto  = l.id AND nombretabla = 'leccion_enlaces'
			    WHERE o.leccion_id = '$lesson_id'
			    ORDER BY orden ASC");

		while($trec = mysqli_fetch_array($rtrec)){
			//tipo recurso
			$recurso_id = $trec['id'];

			switch ($trec['TipoRecu']) {
				case 3: //Video
					$query = "SELECT * FROM recurso where CodiRecu = $recurso_id";
					$lectura = mysqli_query($mysql_conn,$query);
					$lectura = mysqli_fetch_array($lectura);

					$data = array(
						'titulo' => $this->replaceChars($lectura['NombRecu']),
						'texto' => "",
						'cantidad_palabras' => 0,
						'links' => array(
							"rec_$recurso_id.mp4",
							"rec_$recurso_id.ogg",
							"rec_$recurso_id.jpg"
						),
					);

					break;

				case 9: // Lectura
					$query = "SELECT * FROM lectura where codirecu = $recurso_id and actual = 1";
					$lectura = mysqli_query($mysql_conn,$query);
					$lectura = mysqli_fetch_array($lectura);

					$regex = "/src=\"(.*?)\"/";
					preg_match_all($regex, $lectura['texto'], $match);
					$data['links'] = $match[1];

					$base_path =  "/uploads/resources/$course_code/images/";

					$texto = $lectura['texto'];

					foreach($data['links'] as $link){
						$pos = strrpos($link,"/");
						$imgname = str_replace(
							array(" ", "%", "/", "\""),
							array("-", "-", "-", "-"), 
							substr($link, $pos+1));
						$texto = str_replace($link, $base_path . $imgname, $texto);
					}

					$data = array(
						'titulo' => $this->replaceChars($lectura['titulo']),
						'texto' => $texto,
						'cantidad_palabras' => $lectura['cantidad_palabras'],
						'links' => $match[1]
					);
					
					break;

				case '6': // Consulta rapida	
					$query = "SELECT * FROM consulta where codirecu = $recurso_id and actual = 1";
					$lectura = mysqli_query($mysql_conn,$query);
					$lectura = mysqli_fetch_array($lectura);

					$regex = "/src=\"(.*?)\"/";

					$texto = "
						<h4>Concepto</h4>
						<p>".stripslashes($lectura['Concepto'])."</p>
						<h4>Definición</h4>
						<p>".stripslashes($lectura['Definici'])."</p>
						<h4>Fórmulas</h4>
						<p>".stripslashes($lectura['Formulas'])."</p>
						<h4>Consejos</h4>
						<p>".stripslashes($lectura['Tips'])."</p>";

					preg_match_all($regex, $texto, $match);
					$data['links'] = $match[1];

					$base_path =  "/uploads/resources/$course_code/images/";


					foreach($data['links'] as $link){
						$pos = strrpos($link,"/");
						$imgname = str_replace(
							array(" ", "%", "/", "\""),
							array("-", "-", "-", "-"), 
							substr($link, $pos+1));
						$texto = str_replace($link, $base_path . $imgname, $texto);
					}

					$data = array(
						'titulo' => $this->replaceChars($lectura['Concepto']),
						'texto' => $texto,
						'cantidad_palabras' => $lectura['cantidad_palabras'],
						'links' => $match[1]
					);
					break;

				case '5': // Ejercicios Resueltos
					$query = "SELECT * FROM enunejerresu where codirecu = $recurso_id and actual = 1";
					$ejer_resu = mysqli_query($mysql_conn,$query);
					$ejer_resu = mysqli_fetch_array($ejer_resu);

					$regex = "/src=\"(.*?)\"/";

					$texto = "
						<h4>Enunciado</h4>
						<p>".stripslashes($ejer_resu['enunciad'])."</p>";
					// Ejercicios
						$query2 = "SELECT * FROM soluejerresu where codirecu = $recurso_id and codiejer ='".$ejer_resu['codiejer']."'";
						$r_sol_eje = mysqli_query($mysql_conn,$query2);
						$ejer_counter = 1;
						while($sol_eje = mysqli_fetch_array($r_sol_eje) ){
							$texto .= "<h2>Paso No. $ejer_counter </h2>";
							$texto .= "<p>".stripslashes($sol_eje['solucion'])."</p>";
							if ( $sol_eje['explicacion'] != "" ){
								$texto .= "<i>Explicación</i>";
								$texto .= "<p>".stripslashes($sol_eje['explicacion'])."</p>";
							}
							$ejer_counter++;
						}
 
					preg_match_all($regex, $texto, $match);
					$data['links'] = $match[1];
					$base_path =  "/uploads/resources/$course_code/images/";
					foreach($data['links'] as $link){
						$pos = strrpos($link,"/");
						$imgname = str_replace(
							array(" ", "%", "/", "\""),
							array("-", "-", "-", "-"), 
							substr($link, $pos+1));
						// if it has http, it could be a math formula
						// like http://latex.codecogs.com/gif.latex?f(x)=x^{3}-3x^{2}-4x+12
						if(strpos($link,"http") === false){
							$texto = str_replace($link, $base_path . $imgname, $texto);
						}
					}

					$data = array(
						'titulo' => $this->replaceChars($ejer_resu['titulo']),
						'texto' => $texto,
						'cantidad_palabras' => $ejer_resu['cantidad_palabras'],
						'links' => $match[1]
					);
					break;

				
				default:
					$query = "SELECT * FROM leccion_enlaces where id = $recurso_id";;
					$lectura = mysqli_query($mysql_conn,$query);
					$lectura = mysqli_fetch_array($lectura);

					$regex = "/src=\"(.*?)\"/";
					preg_match_all($regex, $lectura['url'], $match);

					$data = array(
						'titulo' => $this->replaceChars($lectura['nombre']),
						'texto' => $this->replaceChars($lectura['descripcion']),
						'url' => $lectura['url'],
						'embebido' => $lectura['urlembebido'],
						'cantidad_palabras' => 0,
						'links' => $match[1]
					);	

					break;
			}


			$lesson['recursos'][] = array(
				'id' => $trec['id'],
				'nombre' => $this->replaceChars($trec['nombre']),
				'url' => $trec['url'],
				'orden' => $trec['orden'],
				'tipo' => $trec['TipoRecu'],
				'data' => $data
			);
		}

		$unidades[$rless['idunidad']]['lessons'][] = $lesson;

	}

	mysqli_close($mysql_conn);

	$this->unidades = $unidades;

	//check if dir exists
	$base_path =  sfConfig::get('sf_upload_dir') . "/resources";
	if(!file_exists($base_path) && $copy){
		mkdir($base_path);
	}

	$base_path .= "/$course_code";
	if(!file_exists($base_path) && $copy){
		mkdir($base_path);
	}

	//images path
	if(!file_exists($base_path . "/images") && $copy){
		mkdir($base_path . "/images");
	}

	//video path
	if(!file_exists($base_path . "/videos") && $copy){
		mkdir($base_path . "/videos");
	}


	$base_path .= "/";

	$profile_id = $this->getUser()->getProfile()->getId();

	if($persist){
		$course = CourseService::getInstance()->create(array(
			'name' => $course_code,
			'descripcion' => "$course_code",
			'profile_id' => $profile_id
		));

		//add dummy user for testing
		CourseService::getInstance()->addTeacher($course->getId(), $profile_id);
		//add to session
		$this->getUser()->addEnabledCourses($course->getId());
		

		foreach ($unidades as $unidad) {
			$chapter = ChapterService::getInstance()->create(array(
				'name' => $unidad['nombre'],
				'profile_id' => $profile_id
			));

			CourseService::getInstance()->addChapterToCourse($course->getId(), $chapter->getId());

			foreach ($unidad['lessons'] as $lesson) {
				$nlesson = LessonService::getInstance()->create(array(
					'name' => $lesson['nombre'],
					'description' => $lesson['descripcion'],
					'profile_id' => $profile_id,
					'node_id' => $lesson['id']
				));

				//add lesson to chapter
				ChapterService::getInstance()->addLessonToChapter($chapter->getId(), $nlesson->getId());

				//add resources
				foreach ($lesson['recursos'] as $recurso) {
					//set resource
					$resource = ResourceService::getInstance()->create(array(
						'name' => $recurso['nombre'],
						'description' => $recurso['data']['titulo'],
						'profile_id' => $profile_id
					));

					//set resource data
					switch ($recurso['tipo']) {
						case 5: 
							foreach ($recurso['data']['links'] as $link) {
								$pos = strrpos($link,"/");
								$imgname = str_replace(
									array(" ", "%", "/", "\""),
									array("-", "-", "-", "-"), 
									substr($link, $pos+1));

								if(strpos($link,"http") === false){
									$link = "http://www.kuepa.com" . $link;
									if(!file_exists($base_path . "/images/" . $imgname) && $copy)
										copy($link, $base_path . "/images/" . $imgname);
								}
							}

						case 6:
						case 9:
							foreach ($recurso['data']['links'] as $link) {
								$pos = strrpos($link,"/");
								$imgname = str_replace(
									array(" ", "%", "/", "\""),
									array("-", "-", "-", "-"), 
									substr($link, $pos+1));

								if(strpos($link,"http") === false){
									$link = "http://www.kuepa.com" . $link;
								}
								if(!file_exists($base_path . "/images/" . $imgname) && $copy)
									copy($link, $base_path . "/images/" . $imgname);
							}


							$rec = new ResourceDataText();
							$rec->setResourceId($resource->getId())
								->setContent($recurso['data']['texto'])
								->setEnabled(true)
								->setDuration(1)
								->save();

							break;
						case 3:
							foreach ($recurso['data']['links'] as $link) {
								$imgname = str_replace(
									array(" ", "%", "/", "\""),
									array("-", "-", "-", "-"), 
									$link);

								$link = "http://www.kuepa.com/escuela/video/" . $link;

								if(!file_exists($base_path . "videos/" . $imgname) && $copy && $copy_video)
									copy($link, $base_path . "videos/" . $imgname);
							}

							$rec = new ResourceDataVideo();

							$rec->setResourceId($resource->getId())
								->setContent("/uploads/resources/$course_code/videos/" . $recurso['data']['links'][0])
								->setEnabled(true)
								->setDuration(1)
								->setVideoType('embebed')
								->save();
							break;
						
						default:
							if($recurso['data']['embebido'] == 1){
								$rec = new ResourceDataVideo();

								$rec->setResourceId($resource->getId())
									->setContent($recurso['data']['links'][0])
									->setEnabled(true)
									->setDuration(1)
									->setVideoType('youtube')
									->save();
							}else{
								$rec = new ResourceDataEmbeddedWeb();

								$rec->setResourceId($resource->getId())
									->setContent($recurso['url'])
									->setEnabled(true)
									->setDuration(1)
									->save();
							}
							break;
					}

					//add reource to lesson
					LessonService::getInstance()->addResourceToLesson($nlesson->getId(), $resource->getId());
	        		ComponentService::getInstance()->updateDuration($resource->getId());

				}
			}
		}
	}

	//crear curso
	//crear unidades
	//crear lecciones
	//crear recursos
  }

  public function executeCalculateTime2(sfWebRequest $request){
  	$this->setDuration($request->getParameter("id"));
  }

  protected function setDuration($component_id){
	$component = Component::getRepository()->getById($component_id);
	$duration = 0;

    if ( $component->getType() == Resource::TYPE  ){ // Resource
        $duration = $component->calculateTime();
    }else{
        $childs = ComponentService::getInstance()->getChilds($component->getId());
        foreach($childs as $child){
        	$duration += $this->setDuration($child->getId());
        }
    }

    //update duration
    $component->setDuration($duration);
    $component->save();

    return $duration;
  }

  
  /**
  *  Proceso de Actualizar las duraciones 
  *  de Components, Recursos,Lesson,
  */
  public function executeCalculateTime(sfWebRequest $request){
      $offset = ( $request->getParameter('offset') ) ? $request->getParameter('offset') : 0;
      // Calcular los recursos
      $resources = Resource::getRepository()->createQuery('r')
                ->where('r.duration >=  ? ','0')
                ->limit(5)
                ->offset($offset)
                ->execute();
      foreach($resources as $key => $resource){
        ComponentService::getInstance()->updateDuration($resource->getId());
      }
      $this->resources = $resources;
      $txt= "<script>window.location.href='/migration/CalculateTime/offset/".($offset+5)."';</script>";
      //$this->redirect('migration/CalculateTime?offset='.($offset+30) );
      return($this->renderText($txt));
  }

  public function executeRedologviewcomponent(sfWebRequest $request){
  	$q = Doctrine_Manager::getInstance()->getCurrentConnection();
	$query = "SELECT distinct(resource_id) as resource_id FROM log_view_component where resource_id is null or course_id is null or chapter_id is null or lesson_id is null";

	$result = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAssoc($query);

	foreach ($result as $value) {
		$resource_id = $value['resource_id'];

		$resource = Resource::getRepository()->getById($resource_id);

		$lessons = ComponentService::getInstance()->getParents($resource_id);

		if($lessons && $lessons->count()){
			$lesson = $lessons->getFirst();

			$chapters = ComponentService::getInstance()->getParents($lesson->getId());

			if($chapters && $chapters->count()){
				$chapter = $chapters->getFirst();

				$courses = ComponentService::getInstance()->getParents($chapter->getId());

				if($courses && $courses->count()){
					$course = $courses->getFirst();

					//UPDATE
					$query = "UPDATE log_view_component set course_id = {$course->getId()}, chapter_id = {$chapter->getId()}, lesson_id = {$lesson->getId()} where resource_id = {$resource_id}";
					Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query);
					// echo "$query <br>";
				}
			}
			// die();
		}
	}

	//remove lost ones
	$query = "DELETE FROM log_view_component WHERE resource_id is null or course_id is null or chapter_id is null or lesson_id is null";
	Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query);
  }

}
