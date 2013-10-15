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
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {

    $mysql_conn = mysqli_connect("127.0.0.1","root","p4ssw0rd123","110k_dokeos_main");
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
				case 3:
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

				case 9:
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
	if(!file_exists($base_path)){
		mkdir($base_path);
	}

	$base_path .= "/$course_code";
	if(!file_exists($base_path)){
		mkdir($base_path);
	}

	//images path
	if(!file_exists($base_path . "/images")){
		mkdir($base_path . "/images");
	}

	//video path
	if(!file_exists($base_path . "/videos")){
		mkdir($base_path . "/videos");
	}


	$base_path .= "/";

	$profile_id = $this->getUser()->getProfile()->getId();

	$course = CourseService::getInstance()->create(array(
		'name' => $course_code,
		'descripcion' => "$course_code",
		'profile_id' => $profile_id
	));

	//add dummy user for testing
	CourseService::getInstance()->addTeacher($course->getId(), $profile_id);
	

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
				'profile_id' => $profile_id
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
							if(!file_exists($base_path . "/images/" . $imgname))
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

							if(!file_exists($base_path . "videos/" . $imgname))
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
			}
		}
	}

	//crear curso
	//crear unidades
	//crear lecciones
	//crear recursos
  }
}
