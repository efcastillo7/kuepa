<?php use_helper("Date") ?>
<?php use_helper("LocalDate") ?>
<style>
	/*table{table-layout: fixed;}*/
	/*table td{overflow: hidden;}*/
	.unit {background-color: gainsboro;}
	.bar { text-align: center}
	.progress { margin-bottom: 0px; }
	table td{ min-width: 100px;}
	.bl { border-left: 1px solid #ddd;}
	.br { border-right: 1px solid #ddd;}
	.bt { border-top: 1px solid #ddd !important;}
</style>


<!-- //////////// DASHBOARD C REDESIGN /////////////// -->

<div class="tbdata-title-hd none">
	<h3 class="HelveticaLt">Reportes: <span class="HelveticaMd"><?php echo $course->getName() ?></span></h3>
</div>

<div class="tbdata none">
	<div id="table-corner" class="tbdata-corner">
		<?php if ($groups->count() > 0): ?>
			<div class="btn-group">
		  		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		    	<?php if ($group): ?>
					<?php echo $group->getName() ?>
	  		  	<?php else: ?>
					Todos 
				<?php endif; ?> <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" role="menu">
			  	<li><a href="<?php echo url_for("stats/class?course_id=" . $course->getId()) ?>">Todos</a></li>
			    <li class="divider"></li>
				<?php foreach ($groups as $group): ?>
					<li><a href="<?php echo url_for("stats/class?course_id=" . $course->getId() ."&group=" . $group->getId()) ?>"><?php echo $group->getName() ?></a></li>
				<?php endforeach ?>
			  </ul>
			</div>
		<?php endif ?>
			<div class="btn-group">
		  		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					Todos 
			  </button>
			</div>
	</div>
	<div id="table-hd" class="tbdata-hd">
		<table class="table table-hover">
			<thead>
				<tr>
					<td colspan="4">General</td>
					<?php foreach ($course->getChapters() as $chapter): ?>
					<td colspan="2" class="bl"><?php echo $chapter->getName() ?></td>
					<?php endforeach ?>
				</tr>
				<tr>
					<td>Progreso</td>
					<td>Tiempo dedicado</td>
					<td>Última Conexión</td>
					<td>Unidades Completadas</td>
					<!-- por unidad -->
					<?php foreach ($course->getChapters() as $chapter): ?>
					<td class="bl">Progreso</td>
					<td>Tiempo Dedicado</td>
					<?php endforeach ?>
					<!-- fin por unidad -->
				</tr>
			</thead>
		</table>
	</div>
	<div id="table-left" class="tbdata-left">
		<table class="table table-hover">
			<tbody>
				<?php foreach ($students as $student): ?>
				<tr><td class="td-first"><?php echo $student->getFullName() ?></td></tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
	<div class="tbdata-info">
		<table class="table table-hover table-bordered">
			<tbody>
				<?php foreach ($students as $student): ?>
				<tr>
					<td>
						<div class="progress">
							<?php if ($student->getComponentStatus($course->getId()) < 35): ?>
							<div class="progress-bar progress-bar-danger" style="width: <?php echo $student->getComponentStatus($course->getId())?>%;"><?php echo $student->getComponentStatus($course->getId())?>%</div>	
							<?php elseif ($student->getComponentStatus($course->getId()) < 70): ?>
							<div class="progress-bar progress-bar-warning" style="width: <?php echo $student->getComponentStatus($course->getId())?>%;"><?php echo $student->getComponentStatus($course->getId())?>%</div>
							<?php else: ?>
							<div class="progress-bar progress-bar-success" style="width: <?php echo $student->getComponentStatus($course->getId())?>%;"><?php echo $student->getComponentStatus($course->getId())?>%</div>
							<?php endif ?>
						</div>
					</td>
					<td>
						<span class="glyphicon glyphicon-time"></span>
						<?php 
							$time_course = LogService::getInstance()->getTotalTimeByRoute($student->getId(), array('course_id' => $course->getId()));
						if($time_course == 0):?>
						-
						<?php else: ?>
						<?php echo gmdate("H:i:s", $time_course) ?>
						<?php endif; ?>
					</td>
					<td>
						<span class="glyphicon glyphicon-log-in cyan"></span>
						<?php echo utcToLocalDate($student->getLastAccess(), "dd/M/yyyy H:mm") ?>
					</td>
					<td>
						<span class="glyphicon glyphicon-ok-circle green"></span>
						<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedChilds($course->getId(), $student->getId()) ?>
						/
						<?php echo $course->getChapters()->count() ?>
					</td>

					<!-- por unidad -->
					<?php foreach ($course->getChapters() as $chapter): $get_status = ($time_course > 0);?>
					<td>
						<?php if (!isset($status[$student->getId()]) || !isset($status[$student->getId()][$chapter->getId()])): ?>
						<?php $get_status = false; ?>
						-
						<?php else: ?>
						<?php echo $status[$student->getId()][$chapter->getId()] ?> %
						<?php endif ?>
					</td>
					<td>
						<?php if ($get_status){
							$time = LogService::getInstance()->getTotalTimeByRoute($student->getId(), array('course_id' => $course->getId(), 'chapter_id' => $chapter->getId())); 
						}else{ $time = 0;} ?>
						<?php 
						if($time == 0):?>
						-
						<?php else: ?>
						<?php echo gmdate("H:i:s", $time) ?>
						<?php endif; ?>
					</td>
					<?php endforeach ?>
					<!-- fin por unidad -->
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>


<script>
	$(window).scroll(function(){
	    $('#table-left').css({
	        'left': $(this).scrollLeft() //Use it later
	    });
	    $('#table-hd').css({
	        'top': $(this).scrollTop() - 100 //Use it later
	    });
	    
	});
</script>


<!-- //////////// DASHBOARD A   //////////// -->

<div class="container clearpadding none">
	<div class="row">
		<div class="col-xs-7">
		    <div class="dashboard-left">
		        <nav class="nav-dashboard">
		          <ul>
		            <li><a class="first" href="dashboard-a.php">Lista</a></li>
		            <li><a href="dashboard-b.php">Fichas</a></li>
		            <li><a class="last" href="dashboard-c.php">Comparativa</a></li>
		          </ul>
		        </nav>
		        <div class="order">
		          <select class="selectpicker" id="materia">
		            <option>Ordenar por</option>
		            <option>Opción 1</option>
		            <option>Opción 2</option>
		          </select>
		        </div>
		      	<div class="clearfix"></div>
		        <div class="table-dashboard">
		          <header>
		            <ul>
		              <li>
		                <div>Progreso</div>
		                <div>Ultima conexión</div>
		                <div>Lecciones completadas</div>
		                <div>Nota promedio</div>
		              </li>
		            </ul>
		          </header>
		            <ul class="body">
		                <li rel="tooltip" data-placement="top" title="40% completado">
		                    <div class="indicator" style="width: 10%;"></div>
		                    <span class="name"><span class="triangle red"></span>Nombre del alumno</span>
		                    <span>70%</span>
		                    <span>10 <small>Días</small></span>
		                    <span>15/47</span>
		                    <span>3.1</span>
		                </li>
		                <li rel="tooltip" data-placement="top" title="40% completado">
		                    <div class="indicator" style="width: 10%;"></div>
		                    <span class="name"><span class="triangle red"></span>Nombre del alumno</span>
		                    <span>70%</span>
		                    <span>10 <small>Días</small></span>
		                    <span>15/47</span>
		                    <span>3.1</span>
		                </li>
		                <li rel="tooltip" data-placement="top" title="40% completado">
		                    <div class="indicator" style="width: 40%;"></div>
		                    <span class="name"><span class="triangle orange"></span>Nombre del alumno</span>
		                    <span>70%</span>
		                    <span>10 <small>Días</small></span>
		                    <span>15/47</span>
		                    <span>3.1</span>
		                </li>
		                <li rel="tooltip" data-placement="top" title="70% completado">
		                    <div class="indicator" style="width: 70%;"></div>
		                    <span class="name"><span class="triangle green"></span>Nombre del alumno</span>
		                    <span>70%</span>
		                    <span>10 <small>Días</small></span>
		                    <span>15/47</span>
		                    <span>3.1</span>
		                </li>
		                <li rel="tooltip" data-placement="top" title="40% completado">
		                    <div class="indicator" style="width: 40%;"></div>
		                    <span class="name"><span class="triangle orange"></span>Nombre del alumno</span>
		                    <span>70%</span>
		                    <span>10 <small>Días</small></span>
		                    <span>15/47</span>
		                    <span>3.1</span>
		                </li>
		                <li rel="tooltip" data-placement="top" title="70% completado">
		                    <div class="indicator" style="width: 70%;"></div>
		                    <span class="name"><span class="triangle green"></span>Nombre del alumno</span>
		                    <span>70%</span>
		                    <span>10 <small>Días</small></span>
		                    <span>15/47</span>
		                    <span>3.1</span>
		                </li>
		                <li rel="tooltip" data-placement="top" title="40% completado">
		                    <div class="indicator" style="width: 40%;"></div>
		                    <span class="name"><span class="triangle orange"></span>Nombre del alumno</span>
		                    <span>70%</span>
		                    <span>10 <small>Días</small></span>
		                    <span>15/47</span>
		                    <span>3.1</span>
		                </li>
		                <li rel="tooltip" data-placement="top" title="70% completado">
		                    <div class="indicator" style="width: 70%;"></div>
		                    <span class="name"><span class="triangle green"></span>Nombre del alumno</span>
		                    <span>70%</span>
		                    <span>10 <small>Días</small></span>
		                    <span>15/47</span>
		                    <span>3.1</span>
		                </li>
		                <li rel="tooltip" data-placement="top" title="40% completado">
		                    <div class="indicator" style="width: 40%;"></div>
		                    <span class="name"><span class="triangle orange"></span>Nombre del alumno</span>
		                    <span>70%</span>
		                    <span>10 <small>Días</small></span>
		                    <span>15/47</span>
		                    <span>3.1</span>
		                </li>
		                <li rel="tooltip" data-placement="top" title="70% completado">
		                    <div class="indicator" style="width: 70%;"></div>
		                    <span class="name"><span class="triangle green"></span>Nombre del alumno</span>
		                    <span>70%</span>
		                    <span>10 <small>Días</small></span>
		                    <span>15/47</span>
		                    <span>3.1</span>
		                </li>
		                <li rel="tooltip" data-placement="top" title="70% completado">
		                  <div class="indicator" style="width: 70%;"></div>
		                  <span class="name"><span class="triangle red"></span>Nombre del alumno</span>
		                  <span>70%</span>
		                  <span>10 <small>Días</small></span>
		                  <span>15/47</span>
		                  <span>3.1</span>
		                </li>
		                <li rel="tooltip" data-placement="top" title="40% completado">
		                  <div class="indicator" style="width: 40%;"></div>
		                  <span class="name"><span class="triangle orange"></span>Nombre del alumno</span>
		                  <span>70%</span>
		                  <span>10 <small>Días</small></span>
		                  <span>15/47</span>
		                  <span>3.1</span>
		                </li>
		                <li rel="tooltip" data-placement="top" title="70% completado">
		                  <div class="indicator" style="width: 70%;"></div>
		                  <span class="name"><span class="triangle green"></span>Nombre del alumno</span>
		                  <span>70%</span>
		                  <span>10 <small>Días</small></span>
		                  <span>15/47</span>
		                  <span>3.1</span>
		                </li>
		                <li rel="tooltip" data-placement="top" title="70% completado">
		                  <div class="indicator" style="width: 70%;"></div>
		                  <span class="name"><span class="triangle red"></span>Nombre del alumno</span>
		                  <span>70%</span>
		                  <span>10 <small>Días</small></span>
		                  <span>15/47</span>
		                  <span>3.1</span>
		                </li>
		                <li rel="tooltip" data-placement="top" title="40% completado">
		                  <div class="indicator" style="width: 40%;"></div>
		                  <span class="name"><span class="triangle orange"></span>Nombre del alumno</span>
		                  <span>70%</span>
		                  <span>10 <small>Días</small></span>
		                  <span>15/47</span>
		                  <span>3.1</span>
		                </li>
		                <li rel="tooltip" data-placement="top" title="70% completado">
		                  <div class="indicator" style="width: 70%;"></div>
		                  <span class="name"><span class="triangle green"></span>Nombre del alumno</span>
		                  <span>70%</span>
		                  <span>10 <small>Días</small></span>
		                  <span>15/47</span>
		                  <span>3.1</span>
		                </li>
		            </ul>
		        </div>
		    </div><!-- /dashboard-left -->
		</div>

		<div class="col-xs-5">
		    <div class="dashboard-right">
		        <nav>
		            <a class="active">Alumno</a>
		            <a>Curso</a>
		        </nav>

		      <div class="header-summary">
		        Nombre alumno
		        <span class="spr close-box"></span>
		      </div>

		      <div class="box-summary">
		          <section class="circles-big">
		            <div class="left">
		              <hgroup>
		                <h3>45<small>hs</small></h3>
		                <h4>Dedicadas</h4>
		              </hgroup>
		              <input class="knob" value="75" data-fgColor="#ff6700" data-bgColor="#e9e9eb" data-width="150" data-thickness=".15" data-readOnly=true data-displayInput=false >
		            </div>

		            <div class="right">
		              <hgroup>
		                <h3>83<small>%</small></h3>
		                <h4>Indice de aprendizaje</h4>
		              </hgroup>
		              <input class="knob" value="75" data-fgColor="#ff6700" data-bgColor="#e9e9eb" data-width="150" data-thickness=".15" data-readOnly=true data-displayInput=false >
		            </div>
		          </section>

		          <section class="circles-small">
		            <div class="left">
		              <span class="inside">72%</span>
		              <input class="knob" value="75" data-fgColor="#ff6700" data-bgColor="#e9e9eb" data-width="60" data-height="60" data-thickness=".1" data-readOnly=true data-displayInput=false >
		              <span class="outside">Eficiencia</span>
		            </div>

		            <div class="right">
		              <span class="inside">54%</span>
		              <input class="knob" value="35" data-fgColor="#ff6700" data-bgColor="#e9e9eb" data-width="60" data-height="60" data-thickness=".1" data-readOnly=true data-displayInput=false >
		              <span class="outside">Esfuerzo</span>
		            </div>
		          </section>

		          <section class="percents">
		            <ul>
		              <li>Velocidad <span>20%</span></li>
		              <li>Completitud <span>20%</span></li>
		              <li>Destreza <span>20%</span></li>
		              <li>Persistencia <span>20%</span></li>
		            </ul>
		          </section>

		        </div><!-- /box-summary -->


		      <div class="box-list">

		        <header>
		          <ul>
		            <li>
		              <div class="text">Listado de unidades</div>
		              <div class="percent">Progreso</div>
		              <div class="time">Tiempo dedicado</div>
		              <div class="date">Fecha de aprobación</div>
		              <div class="note">Nota</div>
		              <div class="note">Nota pro.</div>
		            </li>
		          </ul>
		        </header>

		        <ul class="list-units">
		          <li class="level1" data-toggle="collapse" data-target="#sublesson1">
		            <div class="lp-bar-post"></div>
		            <div class="lp-node">
		              <div class="full-circle"></div>
		              <div class="lp-bar-prev viewed"></div>

		              <input class="knob knob-small" value="10" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-height="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
		            </div>

		            <div class="text">Lorem ipsum dolor sdf sdf sdf sdf sdfsdf </div>
		            <div class="percent">80%</div>
		            <div class="time">40hs</div>
		            <div class="date">29/02/14</div>
		            <div class="note">8</div>
		            <div class="note">8</div>
		          </li>

		          <?php ////////////////////////////////////////////////////////////////////////////////////////////////// SUBLECCION ?>
		          <div id="sublesson1" class="collapse sublesson">

		          <li>
		            <div class="lp-bar-post"></div>
		            <div class="lp-node">
		              <div class="full-circle"></div>
		              <div class="lp-bar-prev"></div>
		              <input class="knob knob-small" value="80" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-height="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
		            </div>

		            <div class="text">Lorem ipsum dolor </div>
		            <div class="percent">80%</div>
		            <div class="time">40hs</div>
		            <div class="date">29/02/14</div>
		            <div class="note">8</div>
		            <div class="note">8</div>
		          </li>

		          <li>
		              <div class="lp-bar-post"></div>
		              <div class="lp-node">
		                <div class="full-circle"></div>
		                <div class="lp-bar-prev"></div>
		                <input class="knob knob-small" value="40" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-height="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
		              </div>

		              <div class="text">Lorem ipsum dolor dolor dolor</div>
		              <div class="percent">80%</div>
		              <div class="time">40hs</div>
		              <div class="date">29/02/14</div>
		              <div class="note">8</div>
		              <div class="note">8</div>
		            </li>

		            <li>
		              <div class="lp-bar-post"></div>
		              <div class="lp-node">
		                <div class="full-circle"></div>
		                <div class="lp-bar-prev"></div>
		                <input class="knob knob-small" value="10" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-height="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
		              </div>

		              <div class="text">Lorem ipsum dolor dolor dolor dolor dolor dolor dolor dolor dolor</div>
		              <div class="percent">80%</div>
		              <div class="time">40hs</div>
		              <div class="date">29/02/14</div>
		              <div class="note">8</div>
		              <div class="note">8</div>
		            </li>

		          </div>
		          <?php /// SUBLECCION ?>

		        </ul>

		      </div>


		    </div><!-- /dashboard-right -->
		</div>
	</div>

</div> <!-- /container -->
<script src="js/dashboard.js"></script>



<!-- //////////// DASHBOARD B /////////////// -->


<div class="container clearpadding">
	<div class="row">
		<div class="col-xs-7">

		    <div class="dashboard-left">

		        <nav class="nav-dashboard">
		          <ul>
		            <li><a class="first" href="dashboard-a.php">Lista</a></li>
		            <li><a href="dashboard-b.php">Fichas</a></li>
		            <li><a class="last" href="dashboard-c.php">Comparativa</a></li>
		          </ul>
		        </nav>

		        <div class="order">
		          <select class="selectpicker" id="materia">
		            <option>Ordenar por</option>
		            <option>Opción 1</option>
		            <option>Opción 2</option>
		          </select>
		        </div>

		        <div class="clearfix margintop60"></div>


		      <article class="ficha-dashboard">

		        <div class="grafica">
		          <div class="grafica1 five"></div>
		          <div class="grafica2 one"></div>
		          <div class="grafica3 two"></div>

		          <i class="spr ico-ficha1"></i>
		          <i class="spr ico-ficha2"></i>
		          <i class="spr ico-ficha3"></i>
		          
		          <img src="img/avatar-dashboard.jpg">
		        </div>

		        <p class="text">Lorem ipsum <br> Consectetuer</p>

		        <section>
		          <div>
		            <p>Ultima conexión</p>
		            <p>10 <small>Dias</small></p>
		          </div>
		          <div class="middle">
		            <p>Lecciones Completas</p>
		            <p>15/47</p>
		          </div>
		          <div>
		            <p>Nota Promedio</p>
		            <p>3.1</p>
		          </div>
		        </section>

		      </article>

		      <article class="ficha-dashboard middle">

		        <div class="grafica">
		          <div class="grafica1 one"></div>
		          <div class="grafica2 one"></div>
		          <div class="grafica3 four"></div>

		          <i class="spr ico-ficha1"></i>
		          <i class="spr ico-ficha2"></i>
		          <i class="spr ico-ficha3"></i>

		          <img src="img/avatar-dashboard.jpg">
		        </div>

		        <p class="text">Lorem ipsum <br> Consectetuer</p>

		        <section>
		          <div>
		            <p>Ultima conexión</p>
		            <p>10 <small>Dias</small></p>
		          </div>
		          <div class="middle">
		            <p>Lecciones Completas</p>
		            <p>15/47</p>
		          </div>
		          <div>
		            <p>Nota Promedio</p>
		            <p>3.1</p>
		          </div>
		        </section>

		      </article>

		      <article class="ficha-dashboard">

		        <div class="grafica">
		          <div class="grafica1 three"></div>
		          <div class="grafica2 two"></div>
		          <div class="grafica3 five"></div>

		          <i class="spr ico-ficha1"></i>
		          <i class="spr ico-ficha2"></i>
		          <i class="spr ico-ficha3"></i>

		          <img src="img/avatar-dashboard.jpg">
		        </div>

		        <p class="text">Lorem ipsum <br> Consectetuer</p>

		        <section>
		          <div>
		            <p>Ultima conexión</p>
		            <p>10 <small>Dias</small></p>
		          </div>
		          <div class="middle">
		            <p>Lecciones Completas</p>
		            <p>15/47</p>
		          </div>
		          <div>
		            <p>Nota Promedio</p>
		            <p>3.1</p>
		          </div>
		        </section>

		      </article>


		      <?php for($i=0;$i<9;$i++){?>

		        <article class="ficha-dashboard <?php if( ($i+2)%3 == 0 ){echo "middle";} ?>">

		          <div class="grafica">
		            <div class="grafica1 one"></div>
		            <div class="grafica2 one"></div>
		            <div class="grafica3 five"></div>

		            <i class="spr ico-ficha1"></i>
		            <i class="spr ico-ficha2"></i>
		            <i class="spr ico-ficha3"></i>

		            <img src="img/avatar-dashboard.jpg">
		          </div>

		          <p class="text">Lorem ipsum <br> Consectetuer</p>

		          <section>
		            <div>
		              <p>Ultima conexión</p>
		              <p>10 <small>Dias</small></p>
		            </div>
		            <div class="middle">
		              <p>Lecciones Completas</p>
		              <p>15/47</p>
		            </div>
		            <div>
		              <p>Nota Promedio</p>
		              <p>3.1</p>
		            </div>
		          </section>

		        </article>
		      <?php } ?>


		    </div><!-- /dashboard-left -->
		</div>
		<div class="col-xs-5">

		    <div class="dashboard-right">
		      <nav>
		        <a class="active">Alumno</a>
		        <a>Curso</a>
		      </nav>

		      <div class="header-summary">
		        Nombre alumno
		        <span class="spr close-box"></span>
		      </div>

		      <div class="box-summary">
		        <section class="circles-big">
		          <div class="left">
		            <hgroup>
		              <h3>45<small>hs</small></h3>
		              <h4>Dedicadas</h4>
		            </hgroup>
		            <input class="knob" value="75" data-fgColor="#ff6700" data-bgColor="#e9e9eb" data-width="150" data-thickness=".15" data-readOnly=true data-displayInput=false >
		          </div>

		          <div class="right">
		            <hgroup>
		              <h3>83<small>%</small></h3>
		              <h4>Indice de aprendizaje</h4>
		            </hgroup>
		            <input class="knob" value="75" data-fgColor="#ff6700" data-bgColor="#e9e9eb" data-width="150" data-thickness=".15" data-readOnly=true data-displayInput=false >
		          </div>
		        </section>

		        <section class="circles-small">
		          <div class="left">
		            <span class="inside">72%</span>
		            <input class="knob" value="75" data-fgColor="#ff6700" data-bgColor="#e9e9eb" data-width="60" data-height="60" data-thickness=".1" data-readOnly=true data-displayInput=false >
		            <span class="outside">Eficiencia</span>
		          </div>

		          <div class="right">
		            <span class="inside">54%</span>
		            <input class="knob" value="35" data-fgColor="#ff6700" data-bgColor="#e9e9eb" data-width="60" data-height="60" data-thickness=".1" data-readOnly=true data-displayInput=false >
		            <span class="outside">Esfuerzo</span>
		          </div>
		        </section>

		        <section class="percents">
		          <ul>
		            <li>Velocidad <span>20%</span></li>
		            <li>Completitud <span>20%</span></li>
		            <li>Destreza <span>20%</span></li>
		            <li>Persistencia <span>20%</span></li>
		          </ul>
		        </section>

		      </div><!-- /box-summary -->


		      <div class="box-list">

		        <header>
		          <ul>
		            <li>
		              <div class="text">Listado de unidades</div>
		              <div class="percent">Progreso</div>
		              <div class="time">Tiempo dedicado</div>
		              <div class="date">Fecha de aprobación</div>
		              <div class="note">Nota</div>
		              <div class="note">Nota pro.</div>
		            </li>
		          </ul>
		        </header>

		        <ul class="list-units">
		          <li class="level1" data-toggle="collapse" data-target="#sublesson1">
		            <div class="lp-bar-post"></div>
		            <div class="lp-node">
		              <div class="full-circle"></div>
		              <div class="lp-bar-prev viewed"></div>

		              <input class="knob knob-small" value="10" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-height="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
		            </div>

		            <div class="text">Lorem ipsum dolor sdf sdf sdf sdf sdfsdf </div>
		            <div class="percent">80%</div>
		            <div class="time">40hs</div>
		            <div class="date">29/02/14</div>
		            <div class="note">8</div>
		            <div class="note">8</div>
		          </li>

		          <?php ////////////////////////////////////////////////////////////////////////////////////////////////// SUBLECCION ?>
		          <div id="sublesson1" class="collapse sublesson">

		            <li>
		              <div class="lp-bar-post"></div>
		              <div class="lp-node">
		                <div class="full-circle"></div>
		                <div class="lp-bar-prev"></div>
		                <input class="knob knob-small" value="80" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-height="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
		              </div>

		              <div class="text">Lorem ipsum dolor </div>
		              <div class="percent">80%</div>
		              <div class="time">40hs</div>
		              <div class="date">29/02/14</div>
		              <div class="note">8</div>
		              <div class="note">8</div>
		            </li>

		            <li>
		              <div class="lp-bar-post"></div>
		              <div class="lp-node">
		                <div class="full-circle"></div>
		                <div class="lp-bar-prev"></div>
		                <input class="knob knob-small" value="40" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-height="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
		              </div>

		              <div class="text">Lorem ipsum dolor dolor dolor</div>
		              <div class="percent">80%</div>
		              <div class="time">40hs</div>
		              <div class="date">29/02/14</div>
		              <div class="note">8</div>
		              <div class="note">8</div>
		            </li>

		            <li>
		              <div class="lp-bar-post"></div>
		              <div class="lp-node">
		                <div class="full-circle"></div>
		                <div class="lp-bar-prev"></div>
		                <input class="knob knob-small" value="10" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-height="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
		              </div>

		              <div class="text">Lorem ipsum dolor dolor dolor dolor dolor dolor dolor dolor dolor</div>
		              <div class="percent">80%</div>
		              <div class="time">40hs</div>
		              <div class="date">29/02/14</div>
		              <div class="note">8</div>
		              <div class="note">8</div>
		            </li>

		          </div>
		          <?php ////////////////////////////////////////////////////////////////////////////////////////////////// SUBLECCION ?>

		        </ul>

		      </div><!-- /box-list -->


		    </div><!-- /dashboard-right -->
		</div>
	</div>
</div> <!-- /container -->






<!-- //////////// PABLO ABZ. TABLE /////////////// -->

<div class="container-fluid container-full none">
	<div class="row">
		<div class="col-xs-12">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<td colspan="5">
							<h3 class="HelveticaLt"><?php echo $course->getName() ?>
								<?php if ($groups->count() > 0): ?>
									<div class="btn-group">
								  		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								    	<?php if ($group): ?>
											<?php echo $group->getName() ?>
							  		  	<?php else: ?>
											Todos 
										<?php endif; ?> <span class="caret"></span>
									  </button>
									  <ul class="dropdown-menu" role="menu">
									  	<li><a href="<?php echo url_for("stats/class?course_id=" . $course->getId()) ?>">Todos</a></li>
									    <li class="divider"></li>
										<?php foreach ($groups as $group): ?>
											<li><a href="<?php echo url_for("stats/class?course_id=" . $course->getId() ."&group=" . $group->getId()) ?>"><?php echo $group->getName() ?></a></li>
										<?php endforeach ?>
									  </ul>
									</div>
								<?php endif ?>
									<div class="btn-group">
								  		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											Todos 
									  </button>
									</div>
								</h3>
						</td>
						<?php foreach ($course->getChapters() as $chapter): ?>
						<td colspan="2" class="bl bt"><?php echo $chapter->getName() ?></td>
						<?php endforeach ?>
					</tr>
					<tr>
						<td class="td-first">Alumno</td>
						<td>Progreso</td>
						<td>Tiempo dedicado</td>
						<td>Última Conexión</td>
						<td>Unidades Completadas</td>

						<!-- por unidad -->
						<?php foreach ($course->getChapters() as $chapter): ?>
						<td class="bl">Progreso</td>
						<td>Tiempo Dedicado</td>
						<?php endforeach ?>
						<!-- fin por unidad -->
					</tr>
				</thead>
				<tbody>
					<?php foreach ($students as $student): ?>
					<tr>
						<td class="td-first"><?php echo $student->getFullName() ?></td>
						<td>
							<div class="progress">
								<?php if ($student->getComponentStatus($course->getId()) < 35): ?>
								<div class="bar bar-danger" style="width: <?php echo $student->getComponentStatus($course->getId())?>%;"><?php echo $student->getComponentStatus($course->getId())?>%</div>	
								<?php elseif ($student->getComponentStatus($course->getId()) < 70): ?>
								<div class="bar bar-warning" style="width: <?php echo $student->getComponentStatus($course->getId())?>%;"><?php echo $student->getComponentStatus($course->getId())?>%</div>
								<?php else: ?>
								<div class="bar bar-success" style="width: <?php echo $student->getComponentStatus($course->getId())?>%;"><?php echo $student->getComponentStatus($course->getId())?>%</div>
								<?php endif ?>
							</div>
						</td>
						<td>
							<?php 
								$time_course = LogService::getInstance()->getTotalTimeByRoute($student->getId(), array('course_id' => $course->getId()));
							if($time_course == 0):?>
							-
							<?php else: ?>
							<?php echo gmdate("H:i:s", $time_course) ?>
							<?php endif; ?>
						</td>
						<td><?php echo utcToLocalDate($student->getLastAccess(), "dd/M/yyyy H:mm") ?></td>
						<td>
							<?php echo ProfileComponentCompletedStatusService::getInstance()->getCompletedChilds($course->getId(), $student->getId()) ?>
							/
							<?php echo $course->getChapters()->count() ?>
						</td>

						<!-- por unidad -->
						<?php foreach ($course->getChapters() as $chapter): $get_status = ($time_course > 0);?>
						<td class="bl">
							<?php if (!isset($status[$student->getId()]) || !isset($status[$student->getId()][$chapter->getId()])): ?>
							<?php $get_status = false; ?>
							-
							<?php else: ?>
							<?php echo $status[$student->getId()][$chapter->getId()] ?> %
							<?php endif ?>
						</td>
						<td>
							<?php if ($get_status){
								$time = LogService::getInstance()->getTotalTimeByRoute($student->getId(), array('course_id' => $course->getId(), 'chapter_id' => $chapter->getId())); 
							}else{ $time = 0;} ?>
							<?php 
							if($time == 0):?>
							-
							<?php else: ?>
							<?php echo gmdate("H:i:s", $time) ?>
							<?php endif; ?>
						</td>
						<?php endforeach ?>
						<!-- fin por unidad -->
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>






				