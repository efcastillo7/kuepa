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
	.student{ cursor: hand; cursor:pointer;}
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
	$(document).ready(function(){
		$(".student").click(function(){
		    var id = $(this).data("profile");
		    var obj = $("#info-data");

		    obj.hide();

		    $.ajax("/stats/getstudentstats",{
		    	dataType: 'html',
		    	data: {course_id: '<?php echo $course->getId() ?>', profile: id},
		    	success: function(data){
		    		// var obj = $("#info-data");

		    		obj.html(data);
		    		$(".knob", obj).knob({});
		    		obj.show();

		    	}
		    });
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
						<li><a href="<?php echo url_for("stats/class?type=lista&course_id=" . $course->getId()) ?>">Lista</a></li>
						<li><a href="<?php echo url_for("stats/class?type=ficha&course_id=" . $course->getId()) ?>">Fichas</a></li>
						<li><a href="<?php echo url_for("stats/class?type=comparativa&course_id=" . $course->getId()) ?>">Comparativa</a></li>
					</ul>
		        </nav>

		        <div class="order">
					<?php if ($groups->count() > 0): ?>
					<div class="btn-group">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<?php if ($group): ?>
							<?php echo $group->getName() ?>
						<?php else: ?>
						Todos 
						<?php endif; ?> 
						<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="?">Todos</a></li>
							<li class="divider"></li>
							<?php foreach ($groups as $group): ?>
							<li><a href="?group=<?php echo $group->getId() ?>"><?php echo $group->getName() ?></a></li>
							<?php endforeach ?>
						</ul>
					</div>
					<?php endif ?>
				</div>

		        <div class="clearfix margintop60"></div>

		      <?php for($i=0;$i<$students->count();$i++){?>

		        <article class="student ficha-dashboard <?php if( ($i+2)%3 == 0 ){echo "middle";} ?>" data-profile="<?php echo $students[$i]->getId() ?>">

		          <div class="grafica">
		            <div class="grafica1 one"></div>
		            <div class="grafica2 two"></div>
		            <div class="grafica3 five"></div>

		            <i class="spr ico-ficha1"></i>
		            <i class="spr ico-ficha2"></i>
		            <i class="spr ico-ficha3"></i>

		            <img src="<?php echo $students[$i]->getAvatarImage() ?>">
		          </div>

		          <p class="text"><?php echo $students[$i]->getFullName() ?></p>

		          <section>
		            <div>
		              <p>Ultima conexión</p>
		              <p><?php echo stdDates::day_diff($students[$i]->getLastAccess(),strtotime("now")) ?> <small>Dias</small></p>
		            </div>
		            <div class="middle">
		              <p>Lecciones Completas</p>
		              <p><?php echo isset($chapterAproved[$students[$i]->getId()]) ? $chapterAproved[$students[$i]->getId()] : 0; ?>
						/
						<?php echo $course->getChapters()->count() ?></p>
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

<div id="info-data">
<?php include_partial("lista-student", array('student' => $oneStudent, 'status' => $status, 'course' => $course, 'chapterTimes' => $chapterTimes, 'courseTimes' => $courseTimes)) ?>
</div>

	</div>
</div> <!-- /container -->
