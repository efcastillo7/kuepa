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

<script src="js/dashboard.js"></script>

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
		
		
<?php 
$oneStudent = $students->getFirst(); 
?>

<?php include_partial("lista-student", array('student' => $oneStudent, 'status' => $status, 'course' => $course, 'chapterTimes' => $chapterTimes, 'courseTimes' => $courseTimes)) ?>
	</div>
</div> <!-- /container -->
