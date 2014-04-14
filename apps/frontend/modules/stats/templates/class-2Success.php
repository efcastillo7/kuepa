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
