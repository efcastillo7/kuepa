<script type="text/javascript" src="/js/dashboard.js"></script>
<script type="text/javascript" src="/js/Chart.js"></script>
<div class="dashboard-student">
	<article class="units">
		<h1><?php echo $course->getName() ?></h1>
		<div class="scroleable">
			<div class="content">
				<?php foreach ($chapters as $chapter): ?>
				<div class="wrap-box">
					<div class="box">
						<p><?php echo $chapter->getName() ?></p>
						<p>Ultima conexion 11/03/14</p>
					</div>
					<div class="bubble"><i class="spr ico-check-dashboard"></i> </div>
					<div class="big-bubble">
						<article class="ficha-dashboard">
							<div class="grafica">
								<div class="back"></div>
								<div class="grafica1 one"></div>
								<div class="grafica2 one"></div>
								<div class="grafica3 five"></div>
								<i class="spr ico-ficha1"></i><i class="spr ico-ficha2"></i><i class="spr ico-ficha3"></i>

								<hgroup>
									<h3><small>Ultima conexion</small> 11/03/14</h3>
									<h4><?php echo $chapter->getCacheCompletedStatus() ?> %</h4>
								</hgroup>
							</div>
						</article>
					</div>
				</div>
			<?php endforeach ?>

			<div class="column-right">
				<div class="spr circle-right"><span>El curso finaliza el <strong>28/03/14</strong> </span></div>
			</div>

		</div><!-- content -->
	</div><!-- scroleable -->

	<div class="column-left">
		<i class="spr circle-left"></i>
	</div>
		   <!--  <div class="column-right">
		        <div class="spr circle-right"><span>El curso finaliza el <strong>28/03/14</strong> </span></div>
		    </div> -->
		    <div class="line"></div>
		    <div class="reference">
		    	<ul>
		    		<li><i class="spr ico-ficha1"></i> Avance</li>
		    		<li><i class="spr ico-ficha2"></i> Aprendizaje</li>
		    		<li><i class="spr ico-ficha3"></i> Desempeño</li>
		    	</ul>
		    </div>
		</article>

	</div>

	<div class="container dashboard-student">
		<div class="row">
			<article class="graphics">
				<div class="col-xs-12 col-md-6">
					<div class="data">
						<div class="gr grafica1">
							<input class="knob" value="60" data-fgColor="#f2ac25" data-bgColor="#e9e9eb" data-width="130" data-thickness=".12" data-skin="" data-readOnly=true data-displayInput=false >
							<hgroup>
								<h3>16<small> Días</small></h3>
								<h4>Restan para el examen</h4>
							</hgroup>
						</div>
						<div class="gr grafica2">
							<hgroup>
								<h3>7</h3>
								<h4>Lecciones restantes</h4>
							</hgroup>
							<input class="knob" value="60" data-fgColor="#8fcf22 " data-bgColor="#e9e9eb" data-width="130" data-thickness=".12" data-skin="" data-readOnly=true data-displayInput=false >
						</div>
						<div class="grafica3">
							<div class="graf-small">
								<input class="knob" value="60" data-fgColor="#8fcf22" data-bgColor="#e9e9eb" data-width="60" data-height="60" data-thickness=".12" data-skin="" data-readOnly=true data-displayInput=false >
								<span class="inside">45</span>
								<span class="outside">Horas dedicadas</span>
							</div>
							<div class="graf-small">
								<input class="knob" value="60" data-fgColor="#dd3600" data-bgColor="#e9e9eb" data-width="60" data-height="60" data-thickness=".12" data-skin="" data-readOnly=true data-displayInput=false >
								<span class="inside">7.2</span>
								<span class="outside">Horas diarias necesarias </span>
							</div>
						</div>
					</div>
					<p class="title5">El curso finaliza el <span class="HelveticaBd orange">28/03/14</span></p>
				</div><!-- /left -->

				<div class="col-xs-12 col-md-6">
					<div class="box-list">
						<header>
							<ul>
								<li>
									<div class="title">Listado de unidades</div>
									<div class="generic">Tiempo dedicado</div>
									<div class="generic">Indice de aprendizaje</div>
									<div class="resources">Recursos vistos/totales</div>
									<div class="generic">Nota</div>
									<div class="generic">Fecha de aprobación</div>
								</li>
							</ul>
						</header>

						<ul class="list-units">
							<?php foreach ($chapters as $chapter): ?>
							<li class="level1" data-toggle="collapse" data-target="#sublesson<?php echo $chapter->getId()?>">
								<div class="lp-bar-post"></div>
								<div class="lp-node">
									<div class="full-circle"></div>
									<div class="lp-bar-prev viewed"></div>

									<input class="knob knob-small" value="<?php echo $chapter->getCacheCompletedStatus() ?>" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-height="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
								</div>

								<div class="title"><?php echo $chapter->getName() ?></div>
								<div class="generic">40hs</div>
								<div class="generic"><?php echo $chapter->getCacheCompletedStatus() ?>%</div>
								<div class="generic">11/18</div>
								<div class="generic">8</div>
								<div class="generic">29/02/14</div>
							</li>

							<div id="sublesson<?php echo $chapter->getId()?>" class="collapse sublesson">
							<?php foreach ($chapter->getLessons() as $lesson): ?>
								<li>
									<div class="lp-bar-post"></div>
									<div class="lp-node">
										<div class="full-circle"></div>
										<div class="lp-bar-prev"></div>
										<input class="knob knob-small" value="<?php echo $lesson->getCacheCompletedStatus() ?>" data-fgColor="#F76E26" data-bgColor="#ddd" data-width="24" data-height="24" data-thickness=".24" data-skin="" data-angleOffset=-5 data-readOnly=true data-displayInput=false >
									</div>

									<div class="title"><?php echo $lesson->getName() ?></div>
									<div class="generic">40hs</div>
									<div class="generic"><?php echo $lesson->getCacheCompletedStatus() ?>%</div>
									<div class="generic">11/18</div>
									<div class="generic">8</div>
									<div class="generic">29/02/14</div>
								</li>
							<?php endforeach ?>
							</div>
						<?php ////////////////////////////////////////////////////////////////////////////////////////////////// SUBLECCION ?>
					<?php endforeach ?>

				</ul>

			</div><!-- /box-list -->
		</div> <!-- /right -->
	</article>
</div>

<div class="row">
	<article class="graphics">
		<div class="col-xs-12 col-md-6">
			<div class="chart">
				<h3>Indices de aprendizaje</h3>
				<div class="wrap-radar">
					<div class="legend-top">Velocidad <span>50%</span></div>
					<div class="legend-right">Completitud <span>80%</span></div>
					<div class="legend-bottom">Destreza <span>90%</span></div>
					<div class="legend-left">Persistencia<span>50%</span></div>
					<canvas id="radar" height="300" width="300"></canvas>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-6">
			<div class="chart">
				<h3>Avance semanal</h3>
				<canvas id="line" height="400" width="430"></canvas>
			</div>
			<script>
			var radarChartData = {
			            //labels : ["Velocidad","Completitud","Destreza","Persistencia"],
			            datasets : [
			            {
			            	fillColor : "rgba(220,220,220,0.5)",
			            	strokeColor : "rgba(220,220,220,1)",
			            	pointColor : "rgba(220,220,220,1)",
			            	pointStrokeColor : "#fff",
			            	data : [65,59,90,81]
			            }
			            ]
			        }
			        var lineChartData = {
			        	labels : ["Semana 1","Semana 2","Semana 3","Semana 4"],
			        	datasets : [
			        	{
			        		fillColor : "rgba(220,220,220,0)",
			        		strokeColor : "rgba(220,220,220,1)",
			        		pointColor : "rgba(220,220,220,1)",
			        		pointStrokeColor : "#fff",
			        		data : [20,60,50,10]
			        	}
			        	]
			        }
			        new Chart(document.getElementById("line").getContext("2d")).Line(lineChartData);
			        new Chart(document.getElementById("radar").getContext("2d")).Radar(radarChartData);
			        </script>
			    </div>
			</article>
		</div>
</div> <!-- /container -->