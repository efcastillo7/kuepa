<?php use_helper("Date") ?>
<h2><?php echo $course->getName() ?></h2>

<style>
	table{table-layout: fixed;}
	table td{overflow: hidden;}
	.unit {background-color: gainsboro;}
	.bar { text-align: center}
	.progress { margin-bottom: 0px; }
</style>

<script src="js/dashboard.js"></script>



<div class="container">
	<div class="row">
		
	</div>
</div>

<!-- DASHBOARD A AEROLAB -->

<div class="container clearpadding">
	<div class="row">
    <div class="col-xs-7 dashboard-left">

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

    <div class="col-xs-5 dashboard-right">
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
		</div>
		</div>	
	</div><!-- /dashboard-right -->
</div> <!-- /container -->

<!-- DASHBOARD B AEROLAB -->

<div class="container clearpadding">

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
</div> <!-- /container -->



<!-- DASHBOARD AEROLAB -->


<div class="container clearpadding">
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

      </div><!-- /dashboard-left -->
  </div> <!-- /container -->
<div class="clear"></div>

<div class="container-fluid">
	<div >
	    <div class="comparative-table general-data">
	        <ul>
	          <li class="title-level-3">
	            <span class="name"></span>
	            <span>Tiempo dedicado</span>
	            <span>Índice de aprendizaje</span>
	            <span>Última conexión</span>
	            <span>Lecciones completadas</span>
	            <span>Nota promedio</span>
	          </li>
	          <!-- RENGLONES DE ALUMNOS -->
	          <li class="renglon" rel="tooltip" data-placement="top" title="40% completado">
	            <span class="name">
	              <div class="indicator" style="width: 100%;"></div>
	              <span class="triangle red"></span>
	              Nombre bastante largo de este alumno
	            </span>
	            <span>30hs</span>
	            <span>70%</span>
	            <span>10 <small>Días</small></span>
	            <span>15/47</span>
	            <span>3.1</span>
	          </li>
	          <li class="renglon darker" rel="tooltip" data-placement="top" title="40% completado">
	            <span class="name">
	              <div class="indicator" style="width: 10%;"></div>
	              <span class="triangle orange"></span>
	              Nombre del alumno
	            </span>
	            <span>30hs</span>
	            <span>70%</span>
	            <span>10 <small>Días</small></span>
	            <span>15/47</span>
	            <span>3.1</span>
	          </li>
	          <li class="renglon" rel="tooltip" data-placement="top" title="40% completado">
	            <span class="name">
	              <div class="indicator" style="width: 50%;"></div>
	              <span class="triangle green"></span>
	              Nombre del alumno
	            </span>
	            <span>30hs</span>
	            <span>70%</span>
	            <span>10 <small>Días</small></span>
	            <span>15/47</span>
	            <span>3.1</span>
	          </li>
	          <!-- /RENGLONES DE ALUMNOS -->
	        </ul>
	    </div>
	    <div class="comparative-table specific-data">
	        <ul>
	          <!-- TITULO NIVEL 1 -->
	          <li class="title-level-1">
	              Unidad uno
	              <span class="btn-lessons" data-target=".lecciones">
	                <i class="spr ico-arrow-table blank"></i>
	              </span>
	          </li>
	          <!-- /TITULO NIVEL 1 -->

	          <!-- TITULOS NIVEL 2 -->
	          <li class="title-level-2">
	            <!-- TITULO NIVEL 2 se muestra por default -->
	            <span class="displayed">Resumen</span>
	            <!-- /TITULO NIVEL 2 se muestra por default -->

	            <!-- COLUMNAS OCULTAS POR DEFAULT -->
	            <span class="none lecciones column">Los diferentes actores publicos y privados, individuales y colectivos, locales y extralocales en las problematicas ambientales
	              <span class="button" data-target=".l1">
	                <i class="spr ico-arrow-table"></i>
	              </span>
	            </span>

	            <span class="none lecciones column">Lección dos
	              <span class="button" data-target=".l2">
	                <i class="spr ico-arrow-table"></i>
	              </span>
	            </span>
	            <!-- /COLUMNAS OCULTAS POR DEFAULT -->
	          </li>
	          <!-- /TITULOS NIVEL 2 -->

	          <!-- TITULOS NIVEL 3 -->
	          <li class="title-level-3">
	            <span>Tiempo dedicado</span>
	            <span>Índice de aprendizaje</span>
	            <span>Nota</span>
	            <span>Progreso</span>

	            <!-- COLUMNAS OCULTAS POR DEFAULT, muestra el detalle de la leccion -->
	            <span class="none l1 collapsable first">Tiempo dedicado</span>
	            <span class="none l1 collapsable">Índice de aprendizaje</span>
	            <span class="none l1 collapsable">Nota</span>
	            <span class="none l1 progreso collapsable column">Progreso</span>

	            <span class="none l2 collapsable first">Tiempo dedicado</span>
	            <span class="none l2 collapsable">Índice de aprendizaje</span>
	            <span class="none l2 collapsable">Nota</span>
	            <span class="none l2 progreso collapsable column">Progreso</span>
	            <!-- /COLUMNAS OCULTAS POR DEFAULT, muestra el detalle de la leccion -->

	          </li>
	          <!-- /TITULOS NIVEL 3 -->

	          <!-- RENGLONES -->
	          <li class="renglon">
	            <!-- VISIBLE POR DEFAULT -->
	            <span>30 hs</span>
	            <span>70%</span>
	            <span>3.1</span>
	            <span>70%</span>
	            <!-- /VISIBLE POR DEFAULT -->

	            <!-- OCULTO POR DEFAULT -->
	            <span class="none l1 collapsable first">30 hs</span>
	            <span class="none l1 collapsable">70%</span>
	            <span class="none l1 collapsable">3.1</span>
	            <span class="none l1 progreso collapsable column">70%</span>

	            <span class="none l2 collapsable first">30 hs</span>
	            <span class="none l2 collapsable">70%</span>
	            <span class="none l2 collapsable">3.1</span>
	            <span class="none l2 progreso collapsable column">70%</span>
	            <!-- /OCULTO POR DEFAULT -->
	          </li>

	          <li class="renglon darker">
	            <!-- VISIBLE POR DEFAULT -->
	            <span>30 hs</span>
	            <span>70%</span>
	            <span>3.1</span>
	            <span class="border-right">70%</span>
	            <!-- /VISIBLE POR DEFAULT -->

	            <!-- OCULTO POR DEFAULT -->
	            <span class="none l1 collapsable first">30 hs</span>
	            <span class="none l1 collapsable">70%</span>
	            <span class="none l1 collapsable">3.1</span>
	            <span class="none l1 progreso collapsable column">70%</span>

	            <span class="none l2 collapsable first">30 hs</span>
	            <span class="none l2 collapsable">70%</span>
	            <span class="none l2 collapsable">3.1</span>
	            <span class="none l2 progreso collapsable column">70%</span>
	            <!-- /OCULTO POR DEFAULT -->
	          </li>

	          <li class="renglon">
	            <!-- VISIBLE POR DEFAULT -->
	            <span>30 hs</span>
	            <span>70%</span>
	            <span>3.1</span>
	            <span>70%</span>
	            <!-- /VISIBLE POR DEFAULT -->

	            <!-- OCULTO POR DEFAULT -->
	            <span class="none l1 collapsable first">30 hs</span>
	            <span class="none l1 collapsable">70%</span>
	            <span class="none l1 collapsable">3.1</span>
	            <span class="none l1 progreso collapsable column">70%</span>

	            <span class="none l2 collapsable first">30 hs</span>
	            <span class="none l2 collapsable">70%</span>
	            <span class="none l2 collapsable">3.1</span>
	            <span class="none l2 progreso collapsable column">70%</span>
	            <!-- /OCULTO POR DEFAULT -->
	          </li>
	          <!-- /RENGLONES -->

	        </ul>
	    </div>

	    <div class="comparative-table specific-data">
	        <ul>
	          <!-- TITULO NIVEL 1 -->
	          <li class="title-level-1">
	              Unidad uno
	              <span class="btn-lessons" data-target=".lecciones">
	                <i class="spr ico-arrow-table blank"></i>
	              </span>
	          </li>
	          <!-- /TITULO NIVEL 1 -->

	          <!-- TITULOS NIVEL 2 -->
	          <li class="title-level-2">
	            <!-- TITULO NIVEL 2 se muestra por default -->
	            <span class="displayed">Resumen</span>
	            <!-- /TITULO NIVEL 2 se muestra por default -->

	            <!-- COLUMNAS OCULTAS POR DEFAULT -->
	            <span class="none lecciones column">Los diferentes actores publicos y privados, individuales y colectivos, locales y extralocales en las problematicas ambientales
	              <span class="button" data-target=".l1">
	                <i class="spr ico-arrow-table"></i>
	              </span>
	            </span>

	            <span class="none lecciones column">Lección dos
	              <span class="button" data-target=".l2">
	                <i class="spr ico-arrow-table"></i>
	              </span>
	            </span>
	            <!-- /COLUMNAS OCULTAS POR DEFAULT -->
	          </li>
	          <!-- /TITULOS NIVEL 2 -->

	          <!-- TITULOS NIVEL 3 -->
	          <li class="title-level-3">
	            <span>Tiempo dedicado</span>
	            <span>Índice de aprendizaje</span>
	            <span>Nota</span>
	            <span>Progreso</span>

	            <!-- COLUMNAS OCULTAS POR DEFAULT, muestra el detalle de la leccion -->
	            <span class="none l1 collapsable first">Tiempo dedicado</span>
	            <span class="none l1 collapsable">Índice de aprendizaje</span>
	            <span class="none l1 collapsable">Nota</span>
	            <span class="none l1 progreso collapsable column">Progreso</span>

	            <span class="none l2 collapsable first">Tiempo dedicado</span>
	            <span class="none l2 collapsable">Índice de aprendizaje</span>
	            <span class="none l2 collapsable">Nota</span>
	            <span class="none l2 progreso collapsable column">Progreso</span>
	            <!-- /COLUMNAS OCULTAS POR DEFAULT, muestra el detalle de la leccion -->

	          </li>
	          <!-- /TITULOS NIVEL 3 -->

	          <!-- RENGLONES -->
	          <li class="renglon">
	            <!-- VISIBLE POR DEFAULT -->
	            <span>30 hs</span>
	            <span>70%</span>
	            <span>3.1</span>
	            <span>70%</span>
	            <!-- /VISIBLE POR DEFAULT -->

	            <!-- OCULTO POR DEFAULT -->
	            <span class="none l1 collapsable first">30 hs</span>
	            <span class="none l1 collapsable">70%</span>
	            <span class="none l1 collapsable">3.1</span>
	            <span class="none l1 progreso collapsable column">70%</span>

	            <span class="none l2 collapsable first">30 hs</span>
	            <span class="none l2 collapsable">70%</span>
	            <span class="none l2 collapsable">3.1</span>
	            <span class="none l2 progreso collapsable column">70%</span>
	            <!-- /OCULTO POR DEFAULT -->
	          </li>

	          <li class="renglon darker">
	            <!-- VISIBLE POR DEFAULT -->
	            <span>30 hs</span>
	            <span>70%</span>
	            <span>3.1</span>
	            <span class="border-right">70%</span>
	            <!-- /VISIBLE POR DEFAULT -->

	            <!-- OCULTO POR DEFAULT -->
	            <span class="none l1 collapsable first">30 hs</span>
	            <span class="none l1 collapsable">70%</span>
	            <span class="none l1 collapsable">3.1</span>
	            <span class="none l1 progreso collapsable column">70%</span>

	            <span class="none l2 collapsable first">30 hs</span>
	            <span class="none l2 collapsable">70%</span>
	            <span class="none l2 collapsable">3.1</span>
	            <span class="none l2 progreso collapsable column">70%</span>
	            <!-- /OCULTO POR DEFAULT -->
	          </li>

	          <li class="renglon">
	            <!-- VISIBLE POR DEFAULT -->
	            <span>30 hs</span>
	            <span>70%</span>
	            <span>3.1</span>
	            <span>70%</span>
	            <!-- /VISIBLE POR DEFAULT -->

	            <!-- OCULTO POR DEFAULT -->
	            <span class="none l1 collapsable first">30 hs</span>
	            <span class="none l1 collapsable">70%</span>
	            <span class="none l1 collapsable">3.1</span>
	            <span class="none l1 progreso collapsable column">70%</span>

	            <span class="none l2 collapsable first">30 hs</span>
	            <span class="none l2 collapsable">70%</span>
	            <span class="none l2 collapsable">3.1</span>
	            <span class="none l2 progreso collapsable column">70%</span>
	            <!-- /OCULTO POR DEFAULT -->
	          </li>
	          <!-- /RENGLONES -->

	        </ul>
	    </div>
	</div>
</div>

<script src="js/dashboard.js"></script>



<!-- /DASHBOARD AEROLAB -->




<table class="table table-hover">
	<thead>
		<tr>
			<td colspan="2"></td>
			<?php foreach ($students as $student): ?>
			<th><?php echo $student->getFullName() ?></th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Fecha de Primera Conexión</td>
			<?php foreach ($students as $student): ?>
			<th><?php echo format_date($student->getFirstAccess(), "dd/M/yyyy H:mm") ?></th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Fecha de Última Conexión</td>
			<?php foreach ($students as $student): ?>
			<th><?php echo format_date($student->getLastAccess(), "dd/M/yyyy H:mm") ?></th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Tiempo Total Dedicado</td>
			<?php foreach ($students as $student): ?>
			<th>
				<?php if ($student->getTotalTime($sf_data->getRaw('course')) > 0): ?>
					<?php echo gmdate("H:i:s",$student->getTotalTime($sf_data->getRaw('course'))) ?>
				<?php else: ?>
					-
				<?php endif ?>
			</th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Promedio de Horas por Semana</td>
			<?php foreach ($students as $student): ?>
			<th> 
				<?php echo gmdate("H:i", $student->getWeekTime($sf_data->getRaw('course'))) ?> hs 
			</th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Nota Promedio</td>
			<?php foreach ($students as $student): ?>
			<th>-</th>
			<?php endforeach ?>
		</tr>
		<tr>
			<td colspan="2">Avance General</td>
			<?php foreach ($students as $student): ?>
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
			<?php endforeach ?>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th colspan="<?php echo 2+$students->count() ?>"><br> Detalle por Unidad</th>
		</tr>
		<?php foreach ($course->getChapters() as $chapter): ?>
			<tr class="unit">
				<td colspan="2"><b><?php echo $chapter->getName() ?></b></td>
				<?php foreach ($students as $student): ?>
				<td>
					<?php if ($student->getComponentStatus($chapter->getId()) == 100): ?>
						<span class="label label-success"><i class='icon-ok'></i></span>
					<?php endif; ?>
				</td>
				<?php endforeach ?>
			</tr>
			<?php foreach ($chapter->getLessons() as $lesson): ?>
			<tr>
				<td></td><td><?php echo $lesson->getName() ?></td>	
				<?php foreach ($students as $student): ?>
				<td>
					<?php if ($student->getComponentStatus($lesson->getId()) == 100): ?>
						<i class='icon-ok'></i>
					<?php elseif($student->getComponentStatus($lesson->getId()) > 0): ?>
						<?php echo $student->getComponentStatus($lesson->getId()) ?> %
					<?php else: ?>
						-
					<?php endif ?>
				</td>
				<?php endforeach ?>
			</tr>
			<?php endforeach ?>

		<?php endforeach ?>
	</tbody>
	
</table>

				